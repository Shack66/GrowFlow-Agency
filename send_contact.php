<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        die("Todos los campos son obligatorios");
    }

    $stmt = $conn->prepare("INSERT INTO contact_forms (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    if ($stmt->execute()) {
        echo "
        <h2>Mensaje enviado correctamente</h2>
        <p>Gracias por escribirnos, $name</p>
        <a href='form_contacto.html'>Volver al formulario</a>
        ";
    } else {
        echo "Error al insertar: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Acceso no permitido";
}
?>
