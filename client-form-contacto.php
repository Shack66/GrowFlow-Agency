<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Growflow Agency - Contacto</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php
session_start();
require_once 'db.php';

// Activar reporte de errores (comentar en producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Procesar formulario si se envió
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            try {
                // Verificar si la conexión existe
                if (!$conn) {
                    throw new Exception("No hay conexión a la base de datos");
                }
                
                // Preparar consulta - sin created_at si la tabla lo genera automáticamente
                $stmt = $conn->prepare("INSERT INTO contact_forms (name, email, subject, message) VALUES (?, ?, ?, ?)");
                
                if (!$stmt) {
                    throw new Exception("Error al preparar consulta: " . $conn->error);
                }
                
                $stmt->bind_param("ssss", $name, $email, $subject, $message);
                
                if ($stmt->execute()) {
                    $stmt->close();
                    echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            alert('✓ Mensaje enviado correctamente. Gracias por escribirnos, " . htmlspecialchars($name) . ". Te responderemos pronto.');
                        });
                    </script>";
                } else {
                    throw new Exception("Error al ejecutar: " . $stmt->error);
                }
                
            } catch (Exception $e) {
                error_log("Error en contacto: " . $e->getMessage());
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        alert('Error: " . addslashes($e->getMessage()) . "');
                    });
                </script>";
            }
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    alert('El correo electrónico no tiene un formato válido.');
                });
            </script>";
        }
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                alert('Por favor, completa todos los campos del formulario.');
            });
        </script>";
    }
}
?>

<!-- Metanavegación -->
<div class="meta-nav">
    <a href="logout.php">Cerrar Sesión</a>
</div>

<!-- HEADER -->
<header class="client-header">
    <div class="client-logo">
        <img src="imags/logo.png" alt="Logo" class="client-logo-img">
        <h1>GrowFlow Agency</h1>
    </div>

    <!-- Botón hamburguesa -->
    <button class="client-hamburger" id="clientHamburger" aria-label="Menú">
        <span class="client-bar"></span>
        <span class="client-bar"></span>
        <span class="client-bar"></span>
    </button>

    <!-- Navegación -->
    <nav class="client-main-nav" id="clientMainNav">
        <a href="client-index.php">Inicio</a>
        <a href="client-blog.php">Blog</a>
        <a href="client-servicios.php">Servicios</a>
        <a href="client-nosotros.php">Sobre Nosotros</a>
        <a href="client-preguntas-frecuentes.php">Preguntas Frecuentes</a>
        <a href="client-perfil.php">Perfil</a>
    </nav>
</header>

<!-- Script para menú hamburguesa -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hamburger = document.getElementById('clientHamburger');
        const mainNav = document.getElementById('clientMainNav');
        const menuOverlay = document.createElement('div');
        
        menuOverlay.className = 'client-menu-overlay';
        document.body.appendChild(menuOverlay);
        
        hamburger.addEventListener('click', function(e) {
            e.stopPropagation();
            hamburger.classList.toggle('active');
            mainNav.classList.toggle('active');
            menuOverlay.classList.toggle('active');
            document.body.style.overflow = mainNav.classList.contains('active') ? 'hidden' : '';
        });
        
        menuOverlay.addEventListener('click', function() {
            hamburger.classList.remove('active');
            mainNav.classList.remove('active');
            menuOverlay.classList.remove('active');
            document.body.style.overflow = '';
        });
        
        document.querySelectorAll('.client-main-nav a').forEach(link => {
            link.addEventListener('click', function() {
                hamburger.classList.remove('active');
                mainNav.classList.remove('active');
                menuOverlay.classList.remove('active');
                document.body.style.overflow = '';
            });
        });
        
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                hamburger.classList.remove('active');
                mainNav.classList.remove('active');
                menuOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mainNav.classList.contains('active')) {
                hamburger.classList.remove('active');
                mainNav.classList.remove('active');
                menuOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    });
</script>

<!-- CONTENIDO PRINCIPAL -->
<main class="contacto-contenedor">

    <h2 class="contacto-titulo">Formulario de Contacto</h2>
    <p class="contacto-descripcion">
        ¿Tienes alguna duda o quieres trabajar con nosotros? Déjanos un mensaje y te responderemos lo antes posible.
    </p>

    <form class="contacto-formulario" method="POST" action="">

        <div class="contacto-grupo">
            <label for="nombre">Nombre completo</label>
            <input type="text" id="nombre" name="name" placeholder="Tu nombre" required>
        </div>

        <div class="contacto-grupo">
            <label for="correo">Correo electrónico</label>
            <input type="email" id="correo" name="email" placeholder="tucorreo@email.com" required>
        </div>

        <div class="contacto-grupo">
            <label for="asunto">Asunto</label>
            <input type="text" id="asunto" name="subject" placeholder="Motivo de tu mensaje" required>
        </div>

        <div class="contacto-grupo">
            <label for="mensaje">Mensaje</label>
            <textarea id="mensaje" name="message" rows="5" placeholder="Escribe tu mensaje aquí..." required></textarea>
        </div>

        <button type="submit" class="btn-enviar-contacto">Enviar mensaje</button>

    </form>

</main>

<!-- FOOTER -->
<footer>
    <p>© 2025 - GrowFlow Agency. Todos los derechos reservados.</p>
    <div class="footer-links">
        <a href="client-form-contacto.php">Formulario de contacto</a>
        <a href="client-preguntas-frecuentes.php">Preguntas frecuentes</a>
    </div>
</footer>

</body>
</html>