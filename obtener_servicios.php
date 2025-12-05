<?php
session_start();
require_once 'db.php';

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => true, 'mensaje' => 'No autenticado']);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    // Consultar los servicios del usuario con sus datos
    $query = "SELECT 
                request_id,
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
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    $servicios = [];
    
    while ($fila = $resultado->fetch_assoc()) {
        // Formatear la fecha de solicitud
        $fecha_solicitud = new DateTime($fila['created_at']);
        $fecha_formateada = $fecha_solicitud->format('d/m/Y H:i');
        
        // Determinar el texto del estado
        $estado_texto = 'Pendiente';
        switch($fila['status']) {
            case 'approved':
            case 'accepted':
                $estado_texto = 'Aceptado';
                break;
            case 'rejected':
                $estado_texto = 'Rechazado';
                break;
            case 'in_progress':
                $estado_texto = 'En Proceso';
                break;
            case 'completed':
                $estado_texto = 'Completado';
                break;
            case 'pending':
            default:
                $estado_texto = 'Pendiente';
                break;
        }
        
        // Procesar respuestas del formulario (answers está en JSON)
        $respuestas_array = [];
        if (!empty($fila['answers'])) {
            $answers_decoded = json_decode($fila['answers'], true);
            
            if ($answers_decoded) {
                // Las preguntas están como pregunta-0, pregunta-1, pregunta-2, pregunta-3
                $preguntas_labels = [
                    'pregunta-0' => '¿Cuál es tu objetivo principal?',
                    'pregunta-1' => '¿Cuál es tu presupuesto mensual aproximado?',
                    'pregunta-2' => '¿Cuánto tiempo llevas en el mercado?',
                    'pregunta-3' => 'Describe tu necesidad específica para este servicio'
                ];
                
                foreach ($answers_decoded as $key => $value) {
                    // Solo procesar preguntas (ignorar service_name, fecha_reunion, etc)
                    if (strpos($key, 'pregunta-') === 0) {
                        $respuestas_array[] = [
                            'pregunta' => $preguntas_labels[$key] ?? $key,
                            'respuesta' => $value
                        ];
                    }
                }
            }
        }
        
        // Verificar si tiene reunión válida (no null, no vacío, no 0000-00-00)
        $tiene_reunion = false;
        $fecha_reunion_formateada = '';
        $hora_reunion_formateada = '';
        $reunion_completa = '';
        
        if (!empty($fila['meeting_date']) && 
            $fila['meeting_date'] !== '0000-00-00' && 
            $fila['meeting_date'] !== null &&
            !empty($fila['meeting_time']) && 
            $fila['meeting_time'] !== '00:00:00' && 
            $fila['meeting_time'] !== null) {
            
            $tiene_reunion = true;
            
            // Formatear fecha de reunión
            try {
                $fecha_obj = new DateTime($fila['meeting_date']);
                $fecha_reunion_formateada = $fecha_obj->format('d/m/Y');
                
                // Formatear hora de reunión
                $hora_obj = new DateTime($fila['meeting_time']);
                $hora_reunion_formateada = $hora_obj->format('h:i A');
                
                // Crear texto completo
                $reunion_completa = $fecha_reunion_formateada . ' a las ' . $hora_reunion_formateada;
            } catch (Exception $e) {
                // Si hay error al formatear, no tiene reunión válida
                $tiene_reunion = false;
            }
        }
        
        $servicio = [
            'id' => $fila['request_id'],
            'nombre_servicio' => $fila['service_name'],
            'descripcion' => $fila['description'] ?: 'Sin descripción',
            'estado' => $fila['status'],
            'estado_texto' => $estado_texto,
            'fecha_solicitud' => $fila['created_at'],
            'fecha_formateada' => $fecha_formateada,
            'respuestas' => $respuestas_array,
            'tiene_reunion' => $tiene_reunion,
            'fecha_reunion_raw' => $fila['meeting_date'],
            'hora_reunion_raw' => $fila['meeting_time'],
            'fecha_reunion_formateada' => $fecha_reunion_formateada,
            'hora_reunion_formateada' => $hora_reunion_formateada,
            'reunion_completa' => $reunion_completa
        ];
        
        $servicios[] = $servicio;
    }
    
    echo json_encode([
        'success' => true,
        'data' => $servicios,
        'count' => count($servicios)
    ]);
    
} catch (Exception $e) {
    error_log("Error en obtener_servicios.php: " . $e->getMessage());
    echo json_encode([
        'error' => true,
        'mensaje' => 'Error al obtener servicios: ' . $e->getMessage()
    ]);
}
?>