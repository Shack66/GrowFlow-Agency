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

// Función para verificar login
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Función para verificar si es admin
function isAdmin() {
    return isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin';
}

// Función para redirigir si no está logueado
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.html?redirect=' . urlencode($_SERVER['REQUEST_URI']));
        exit();
    }
}

// Función para redirigir si no es admin
function requireAdmin() {
    requireLogin();
    if (!isAdmin()) {
        header('Location: index.html');
        exit();
    }
}
?>

