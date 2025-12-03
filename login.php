<?php
session_start();
require_once 'db.php';

$error = '';

// Si ya está logueado, redirigir según su rol
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['rol'] == 'admin') {
        header("Location: admin-index.php");
    } else {
        header("Location: client-index.php");
    }
    exit();
}

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        // CONSULTA ACTUALIZADA para coincidir con tu tabla
        $stmt = $conn->prepare("SELECT user_id, email, password, name, apellido, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            // Verificar la contraseña
            if (password_verify($password, $user['password'])) {
                // Iniciar sesión - VARIABLES ACTUALIZADAS
                $_SESSION['user_id'] = $user['user_id'];  // Cambiado de 'id' a 'user_id'
                $_SESSION['email'] = $user['email'];
                $_SESSION['nombre'] = $user['name'];      // Cambiado de 'nombre' a 'name'
                $_SESSION['apellido'] = $user['apellido'];
                $_SESSION['rol'] = $user['role'];         // Cambiado de 'rol' a 'role'

                // Redirigir según el rol
                if ($user['role'] == 'admin') {           // Cambiado de 'rol' a 'role'
                    header("Location: admin-index.php");
                } else {
                    header("Location: client-index.php");
                }
                exit();
            } else {
                $error = "Correo o contraseña incorrectos.";
            }
        } else {
            $error = "Correo o contraseña incorrectos.";
        }
        $stmt->close();
    } else {
        $error = "Por favor, completa todos los campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrowFlow Agency - Iniciar Sesión</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <!-- METANAVEGACIÓN -->
    <div class="meta-nav">
        <a href="login.php">Iniciar sesión</a>
        <a href="registro.php">Registrarse</a>
    </div>
    <!-- HEADER -->
    <header>
        <div class="logo">
            <img src="../imags/logo.png" alt="Logo" class="logo-img">
            <h1>GrowFlow Agency</h1>
        </div>
        <nav class="main-nav">
            <a href="index.html">Inicio</a>
            <a href="blog.html">Blog</a>
            <a href="servicios.html">Servicios</a>
            <a href="nosotros.html">Sobre Nosotros</a>
            <a href="preguntas-frecuentes.html">Preguntas Frecuentes</a>
            <a href="registro.php" class="btn-registrarse">Regístrate</a>
        </nav>
    </header>
    <!-- CONTENEDOR LOGIN -->
    <section class="lgn-container">
        <div class="lgn-box">
            <h2 class="lgn-title">Iniciar Sesión</h2>
            <?php if ($error): ?>
                <div class="error-message" style="color: red; background: #ffe6e6; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            <form class="lgn-form" method="POST" action="login.php">
                <input type="email" name="email" placeholder="Correo electrónico" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <button type="submit" class="lgn-btn">Ingresar</button>
            </form>
            <a href="#" class="lgn-link">¿Olvidaste tu contraseña?</a>
        </div>
    </section>
    <!-- FOOTER -->
    <footer>
        <p>© 2025 - GrowFlow Agency. Todos los derechos reservados.</p>
        <div class="footer-links">
            <a href="form_contacto.html">Formulario de contacto</a>
            <a href="preguntas-frecuentes.html">Preguntas frecuentes</a>
        </div>
    </footer>
</body>

</html>