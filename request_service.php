<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    die("Acceso no autorizado");
}

$user_id = $_SESSION['user_id'];
$service_name = $_POST['service_name'] ?? '';
$description = $_POST['pregunta-3'] ?? '';
$meeting_date = $_POST['fecha_reunion'] ?? NULL;
$meeting_time = $_POST['hora_reunion'] ?? NULL;
$status = 'pending';

// Guardar todas las respuestas como JSON
$answers = json_encode($_POST, JSON_UNESCAPED_UNICODE);

$stmt = $conn->prepare("INSERT INTO service_requests 
(user_id, service_name, description, status, meeting_date, meeting_time, answers)
VALUES (?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("issssss", 
    $user_id,
    $service_name,
    $description,
    $status,
    $meeting_date,
    $meeting_time,
    $answers
);

if($stmt->execute()){
    echo "¡Solicitud registrada correctamente!";
} else {
    echo "Error al registrar la solicitud: " . $stmt->error;
}
