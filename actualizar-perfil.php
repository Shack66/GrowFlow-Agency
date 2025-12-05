<?php
// actualizar-perfil.php
session_start();
require_once 'db.php';

// Para depuración - quitar en producción
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar que el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'No autenticado']);
    exit;
}

// Verificar que es una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Obtener datos del formulario
$user_id = $_SESSION['user_id'];
$name = trim($_POST['nombre'] ?? '');
$apellido = trim($_POST['apellido'] ?? '');
$email = trim($_POST['email'] ?? '');

// Validar datos obligatorios
if (empty($name) || empty($apellido) || empty($email)) {
    echo json_encode(['success' => false, 'message' => 'Nombre, apellido y email son obligatorios']);
    exit;
}

// Validar formato de email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Email no válido']);
    exit;
}

try {
    // Verificar si el email ya existe en otro usuario
    $sql_check = "SELECT user_id FROM users WHERE email = ? AND user_id != ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("si", $email, $user_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    
    if ($result_check->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Este email ya está registrado por otro usuario']);
        exit;
    }
    $stmt_check->close();
    
    // Actualizar datos del usuario
    $sql = "UPDATE users SET name = ?, apellido = ?, email = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $apellido, $email, $user_id);
    
    if ($stmt->execute()) {
        // Actualizar datos en la sesión
        $_SESSION['name'] = $name;
        $_SESSION['apellido'] = $apellido;
        $_SESSION['email'] = $email;
        
        echo json_encode([
            'success' => true, 
            'message' => 'Perfil actualizado correctamente',
            'data' => [
                'nombre' => $name,
                'apellido' => $apellido,
                'email' => $email
            ]
        ]);
    } else {
        throw new Exception("Error en la ejecución: " . $stmt->error);
    }
    
    $stmt->close();
    
} catch (Exception $e) {
    error_log("Error en actualizar-perfil.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error del servidor: ' . $e->getMessage()]);
}

?>