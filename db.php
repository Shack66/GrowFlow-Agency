<?php
$host = "mysql-growflow.alwaysdata.net"; 
$user = "growflow";
$pass = "GrowFlowps2025";
$dbname = "growflow_db";

// Conexion MySQL
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>