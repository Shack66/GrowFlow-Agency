<?php
session_start();
require_once 'db.php';

// Verificar sesión
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => true, 'mensaje' => 'No autenticado']);
    exit;
}

// Para depuración - quitar en producción
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Consultar servicios con JOIN para obtener nombre y email del usuario
    $query = "SELECT 
                sr.request_id,
                sr.user_id,
                sr.service_name,
                sr.description,
                sr.status,
                sr.created_at,
                sr.meeting_date,
                sr.meeting_time,
                sr.answers,
                u.name as user_name,
                u.email as user_email
              FROM service_requests sr
              LEFT JOIN users u ON sr.user_id = u.user_id
              ORDER BY sr.created_at DESC";
    
    $resultado = $conn->query($query);
    
    if (!$resultado) {
        throw new Exception("Error en consulta: " . $conn->error);
    }
    
    $servicios = [];
    while ($fila = $resultado->fetch_assoc()) {
        $servicio = [
            'request_id' => $fila['request_id'],
            'user_id' => $fila['user_id'],
            'user_name' => $fila['user_name'] ?? 'Usuario desconocido',
            'user_email' => $fila['user_email'] ?? 'Email no disponible',
            'service_name' => $fila['service_name'],
            'description' => $fila['description'] ?? '',
            'status' => $fila['status'] ?? 'pending',
            'created_at' => $fila['created_at'],
            'meeting_date' => $fila['meeting_date'],
            'meeting_time' => $fila['meeting_time'],
            'answers' => $fila['answers']
        ];
        
        $servicios[] = $servicio;
    }
    
    echo json_encode([
        'success' => true,
        'data' => $servicios,
        'count' => count($servicios)
    ]);
    
} catch (Exception $e) {
    error_log("Error en admin_obtener_servicios.php: " . $e->getMessage());
    echo json_encode([
        'error' => true, 
        'mensaje' => 'Error del servidor: ' . $e->getMessage()
    ]);
}
?>