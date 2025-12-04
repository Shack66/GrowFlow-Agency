<?php
// Archivo para verificar autenticación en páginas protegidas
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Función para verificar si es admin
function esAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] == 'admin';
}

// Función para verificar si es cliente
function esCliente() {
    return isset($_SESSION['role']) && $_SESSION['role'] == 'client';
}

// Función para requerir rol específico
function requiereRol($rol) {
    if (!isset($_SESSION['role']) || $_SESSION['role'] != $rol) {
        header("Location: login.php");
        exit();
    }
}
?>