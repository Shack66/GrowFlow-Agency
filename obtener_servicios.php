<?php
// Iniciar sesión
session_start();

// Configurar cabecera para JSON
header('Content-Type: application/json');

// Verificar que el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'error' => true,
        'mensaje' => 'No autenticado. Por favor, inicia sesión.'
    ]);
    exit;
}

// Obtener ID del usuario desde la sesión
$user_id = $_SESSION['user_id'];

try {
    // Incluir el archivo de conexión a la base de datos
    require_once 'db.php';
    
    // Verificar si la conexión existe y es válida
    if (!isset($conn) || !($conn instanceof mysqli)) {
        throw new Exception("Error: Conexión a base de datos no disponible");
    }
    
    // Consultar servicios del usuario usando consultas preparadas
    $query = "SELECT 
                request_id,
                user_id,
                service_name,
                description,
                status,
                created_at,
                meeting_date,
                meeting_time,
                answers
              FROM service_requests 
              WHERE user_id = ? 
              ORDER BY created_at DESC";
    
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        throw new Exception("Error preparando la consulta: " . $conn->error);
    }
    
    $stmt->bind_param("i", $user_id);
    
    if (!$stmt->execute()) {
        throw new Exception("Error ejecutando la consulta: " . $stmt->error);
    }
    
    $resultado = $stmt->get_result();
    
    $servicios = [];
    
    while ($fila = $resultado->fetch_assoc()) {
        // Verificar si se agendó reunión - MANEJO DE AMBOS CASOS
        $meeting_date = $fila['meeting_date'];
        $meeting_time = $fila['meeting_time'];
        
        // Determinar si tiene reunión agendada
        $tieneReunion = false;
        
        if (!empty($meeting_date) && !empty($meeting_time)) {
            // Verificar que no sean valores "vacíos" o de ceros
            $date_is_valid = !in_array($meeting_date, ['0000-00-00', '00:00:00', '0000-00-00 00:00:00', '']);
            $time_is_valid = !in_array($meeting_time, ['00:00:00', '00:00', '']);
            
            if ($date_is_valid && $time_is_valid) {
                // Verificar formato de fecha (puede ser Y-m-d o Y-m-d H:i:s)
                $date_parts = explode('-', $meeting_date);
                if (count($date_parts) === 3 && 
                    checkdate($date_parts[1], $date_parts[2], $date_parts[0]) &&
                    $date_parts[0] != '0000') {
                    $tieneReunion = true;
                }
            }
        }
        
        // Decodificar respuestas JSON si están en ese formato
        $respuestas_array = [];
        
        if (!empty($fila['answers'])) {
            // Intentar decodificar como JSON
            $respuestas_decodificadas = json_decode($fila['answers'], true);
            
            // Si es un JSON válido, usarlo
            if (json_last_error() === JSON_ERROR_NONE && is_array($respuestas_decodificadas)) {
                $respuestas_array = $respuestas_decodificadas;
            } else {
                // Si no es JSON válido, crear estructura básica
                $respuestas_array = [
                    [
                        'pregunta' => 'Información del servicio',
                        'respuesta' => $fila['answers']
                    ]
                ];
            }
        }
        
        // Formatear datos para el frontend
        $servicio = [
            'id' => $fila['request_id'],
            'user_id' => $fila['user_id'],
            'nombre_servicio' => $fila['service_name'] ?? 'Servicio sin nombre',
            'descripcion' => $fila['description'] ?? 'Sin descripción disponible',
            'estado' => $fila['status'] ?? 'pending',
            'fecha_solicitud' => $fila['created_at'],
            'fecha_reunion_raw' => $meeting_date,
            'hora_reunion_raw' => $meeting_time,
            'tiene_reunion' => $tieneReunion,
            'respuestas' => $respuestas_array
        ];
        
        // Formatear fecha de solicitud para mejor presentación
        if (!empty($fila['created_at']) && $fila['created_at'] != '0000-00-00 00:00:00') {
            $fecha = new DateTime($fila['created_at']);
            $servicio['fecha_formateada'] = $fecha->format('d/m/Y H:i');
        } else {
            $servicio['fecha_formateada'] = 'Fecha no disponible';
        }
        
        // Formatear fecha de reunión si existe y es válida
        if ($tieneReunion) {
            // Asegurar formato correcto para DateTime
            $fechaReunionStr = $meeting_date;
            if (strlen($meeting_date) === 10) { // Formato Y-m-d
                $fechaReunionStr .= ' ' . $meeting_time;
            }
            
            try {
                $fechaReunion = new DateTime($fechaReunionStr);
                $servicio['fecha_reunion_formateada'] = $fechaReunion->format('d/m/Y');
                
                // Formatear hora de reunión
                $hora_formateada = date("h:i A", strtotime($meeting_time));
                $servicio['hora_reunion_formateada'] = $hora_formateada;
                
                // Fecha y hora combinadas
                $servicio['reunion_completa'] = $servicio['fecha_reunion_formateada'] . ' a las ' . $servicio['hora_reunion_formateada'];
                $servicio['fecha_reunion'] = $fechaReunion->format('Y-m-d');
                $servicio['hora_reunion'] = $meeting_time;
            } catch (Exception $e) {
                // Si hay error al parsear, marcar como sin reunión
                $servicio['tiene_reunion'] = false;
                error_log("Error al parsear fecha de reunión: " . $e->getMessage());
            }
        } else {
            // Limpiar valores si no tiene reunión válida
            $servicio['fecha_reunion'] = null;
            $servicio['hora_reunion'] = null;
            $servicio['fecha_reunion_formateada'] = null;
            $servicio['hora_reunion_formateada'] = null;
            $servicio['reunion_completa'] = null;
        }
        
        // Traducir estado a texto legible
        $estados = [
            'pending' => 'Pendiente',
            'in_progress' => 'En Proceso',
            'completed' => 'Completado',
            'rejected' => 'Rechazado',
            'cancelled' => 'Cancelado',
            'approved' => 'Aprobado',
            'review' => 'En Revisión'
        ];
        
        $estado_key = strtolower($fila['status'] ?? 'pending');
        $servicio['estado_texto'] = $estados[$estado_key] ?? ucfirst($estado_key);
        
        $servicios[] = $servicio;
    }
    
    // Liberar recursos
    $stmt->close();
    
    // Devolver los servicios
    echo json_encode([
        'success' => true,
        'data' => $servicios,
        'count' => count($servicios)
    ], JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    // Registrar error en log
    error_log("Error en obtener_servicios.php: " . $e->getMessage());
    
    // Devolver error en formato JSON
    echo json_encode([
        'error' => true,
        'mensaje' => 'Error al obtener servicios',
        'detalle' => $e->getMessage()
    ]);
}
?>