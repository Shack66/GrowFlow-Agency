<?php
require_once 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $name = trim($_POST['name']);
    $apellido = trim($_POST['apellido']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Verificar si el correo ya existe
    $sql = "SELECT user_id FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // El correo ya existe
        echo "<script>alert('El correo ya está registrado.'); window.location='registro.php';</script>";
        exit();
    }

    // Hashear contraseña
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insertar nuevo usuario
    $sql = "INSERT INTO users (name, apellido, email, password, role) 
            VALUES (?, ?, ?, ?, 'client')";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $apellido, $email, $hashedPassword);

    if ($stmt->execute()) {
        echo "<script>alert('Registro exitoso. Ahora puedes iniciar sesión.'); window.location='login.php';</script>";
        exit();
    } else {
        echo "Error en el registro: " . $stmt->error;
    }
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrowFlow Agency - Registro</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <!-- METANAVEGACIÓN -->
    <div class="meta-nav">
        <a href="login.php">Iniciar sesión</a>
        <a href="registro.php">Registrarse</a>
    </div>

    <!-- HEADER -->
    <header class="header">
        <div class="logo">
            <img src="imags/logo.png" alt="Logo" class="logo-img">
            <h1>GrowFlow Agency</h1>
        </div>

        <!-- Botón hamburguesa -->
        <button class="hamburger" id="hamburger" aria-label="Menú">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>

        <!-- Navegación -->
        <nav class="main-nav" id="mainNav">
            <a href="index.html">Inicio</a>
            <a href="blog.html">Blog</a>
            <a href="servicios.html">Servicios</a>
            <a href="nosotros.html">Sobre Nosotros</a>
            <a href="preguntas-frecuentes.html">Preguntas Frecuentes</a>
            <a href="registro.php" class="btn-registrarse">Regístrate</a>
        </nav>
    </header>

    <!-- CONTENEDOR REGISTRO -->
    <section class="lgn-container">
        <div class="lgn-box">
            <h2 class="lgn-title">Registrarse</h2>

            <form class="lgn-form" id="form-registro" action="registro.php" method="POST">
                <input type="text" name="name" placeholder="Nombre" required>
                <input type="text" name="apellido" placeholder="Apellido" required>
                <input type="email" name="email" placeholder="Correo electrónico" required>
                <input type="password" name="password" placeholder="Contraseña" required>

                <button type="submit" class="lgn-btn">Enviar</button>
            </form>

            <p style="padding-top: 20px; color: white;">¿Ya tienes una cuenta?</p>
            <a href="login.php" class="lgn-link">Iniciar Sesión</a>
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
<script>
    // Menú hamburguesa
    const hamburger = document.getElementById('hamburger');
    const mainNav = document.getElementById('mainNav');
    const menuOverlay = document.createElement('div');
    
    // Crear overlay
    menuOverlay.className = 'menu-overlay';
    document.body.appendChild(menuOverlay);
    
    // Toggle menú
    hamburger.addEventListener('click', () => {
        hamburger.classList.toggle('active');
        mainNav.classList.toggle('active');
        menuOverlay.classList.toggle('active');
        document.body.style.overflow = mainNav.classList.contains('active') ? 'hidden' : '';
    });
    
    // Cerrar menú al hacer clic en overlay o enlaces
    menuOverlay.addEventListener('click', closeMenu);
    
    // Cerrar menú al hacer clic en enlaces (opcional)
    document.querySelectorAll('.main-nav a').forEach(link => {
        link.addEventListener('click', closeMenu);
    });
    
    function closeMenu() {
        hamburger.classList.remove('active');
        mainNav.classList.remove('active');
        menuOverlay.classList.remove('active');
        document.body.style.overflow = '';
    }
    
    // Cerrar menú al redimensionar a pantalla grande
    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) {
            closeMenu();
        }
    });
</script>
</body>

</html>