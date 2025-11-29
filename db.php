<?php
$host = "mysql-growflow.alwaysdata.net"; 
$user = "growflow"; // usuario principal para la web
$pass = "GrowFlowps2025"; // contraseña del usuario growflow
$dbname = "growflow_db";

// Conexion MySQL
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4"); // recomendado
?>
