<?php
require_once 'auth.php';
requiereRol('admin');
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - GrowFlow Agency</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <!-- Metanavegación -->
    <div class="meta-nav">
        <a href="logout.php">Cerrar Sesión</a>
    </div>

    <!-- HEADER -->
    <header>
        <div class="logo">
            <img src="../imags/logo.png" alt="Logo" class="logo-img">
            <h1>GrowFlow Agency</h1>
        </div>

        <!-- Botón hamburguesa (agregado para consistencia) -->
        <button class="hamburger" id="hamburger" aria-label="Menú">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>

        <!-- Navegación -->
        <nav class="main-nav" id="mainNav">
            <a href="admin-index.php">Inicio</a>
            <a href="admin-servicios.php">Servicios</a>
            <a href="admin-perfil.php">Perfil</a>
            <a href="logout.php" class="btn-logout">Cerrar Sesión</a>
        </nav>
    </header>

    <!-- Script para menú hamburguesa (agregado) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.getElementById('hamburger');
            const mainNav = document.getElementById('mainNav');
            const menuOverlay = document.createElement('div');
            
            // Crear overlay
            menuOverlay.className = 'menu-overlay';
            document.body.appendChild(menuOverlay);
            
            // Toggle menú
            hamburger.addEventListener('click', function(e) {
                e.stopPropagation();
                hamburger.classList.toggle('active');
                mainNav.classList.toggle('active');
                menuOverlay.classList.toggle('active');
                document.body.style.overflow = mainNav.classList.contains('active') ? 'hidden' : '';
            });
            
            // Cerrar menú al hacer clic en overlay
            menuOverlay.addEventListener('click', function() {
                hamburger.classList.remove('active');
                mainNav.classList.remove('active');
                menuOverlay.classList.remove('active');
                document.body.style.overflow = '';
            });
            
            // Cerrar menú al hacer clic en enlaces
            document.querySelectorAll('.main-nav a').forEach(link => {
                link.addEventListener('click', function() {
                    hamburger.classList.remove('active');
                    mainNav.classList.remove('active');
                    menuOverlay.classList.remove('active');
                    document.body.style.overflow = '';
                });
            });
            
            // Cerrar menú al redimensionar a pantalla grande
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    hamburger.classList.remove('active');
                    mainNav.classList.remove('active');
                    menuOverlay.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
            
            // Cerrar menú con tecla Escape
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

    <!-- SECCIÓN PERFIL -->
    <section class="perfil">
        <div class="perfil-contenido">
            <!-- Header del Perfil -->
            <div class="perfil-header">
                <div class="perfil-avatar">
                    <!-- Aquí puedes usar una imagen dinámica si la tienes en la base de datos -->
                    <img src="../imags/nosotros/samuel.jpg" alt="<?php echo htmlspecialchars($_SESSION['name']); ?>">
                </div>
                <div class="perfil-info">
                    <h2><?php echo htmlspecialchars($_SESSION['name'] . ' ' . $_SESSION['apellido']); ?></h2>
                    <p class="perfil-email"><?php echo htmlspecialchars($_SESSION['email']); ?></p>
                    <div class="perfil-stats">
                    </div>
                </div>
            </div>

            <!-- Pestañas de Navegación -->
            <div class="perfil-tabs">
                <button class="tab-btn active" onclick="openTab('informacion')">Información Personal</button>
                <button class="tab-btn" onclick="openTab('servicios')">Servicios</button>
                <button class="tab-btn" onclick="openTab('configuracion')">Configuración</button>
            </div>

            <!-- Contenido de las Pestañas -->
            <div class="tab-content">
                <!-- Pestaña Información Personal -->
                <div id="informacion" class="tab-pane active">
                    <div class="formulario-perfil">
                        <form id="formPerfil" method="POST" action="actualizar-perfil.php">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($_SESSION['name']); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="apellido">Apellido</label>
                                    <input type="text" id="apellido" name="apellido" value="<?php echo htmlspecialchars($_SESSION['apellido']); ?>">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>">
                                </div>
                            </div>

                            <div class="form-buttons">
                                <button type="submit" class="btn-guardar">Guardar Cambios</button>
                                <button type="button" class="btn-cancelar" onclick="resetForm()">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Pestaña Proyecto -->
                <div id="servicios" class="tab-pane">
                    <div class="proyectos-grid">
                        <div class="proyecto-card">
                            <div class="proyecto-header">
                                <h3>Ecommerce Fashion</h3>
                                <span class="proyecto-status completado">Completado</span>
                            </div>
                            <p class="proyecto-desc">Estrategia de marketing completa para tienda online de moda.</p>
                            <div class="proyecto-metrics">
                                <div class="metric">
                                    <span class="metric-value">+45%</span>
                                    <span class="metric-label">Ventas</span>
                                </div>
                                <div class="metric">
                                    <span class="metric-value">+120%</span>
                                    <span class="metric-label">Tráfico</span>
                                </div>
                            </div>
                            <div class="proyecto-actions">
                                <button class="btn-ver">Ver Detalles</button>
                            </div>
                        </div>

                        <div class="proyecto-card">
                            <div class="proyecto-header">
                                <h3>Tech Startup</h3>
                                <span class="proyecto-status en-progreso">En Progreso</span>
                            </div>
                            <p class="proyecto-desc">Campaña de lanzamiento para aplicación móvil innovadora.</p>
                            <div class="proyecto-metrics">
                                <div class="metric">
                                    <span class="metric-value">+80%</span>
                                    <span class="metric-label">Leads</span>
                                </div>
                                <div class="metric">
                                    <span class="metric-value">+200%</span>
                                    <span class="metric-label">Engagement</span>
                                </div>
                            </div>
                            <div class="proyecto-actions">
                                <button class="btn-ver">Ver Detalles</button>
                            </div>
                        </div>

                        <div class="proyecto-card">
                            <div class="proyecto-header">
                                <h3>Restaurant Gourmet</h3>
                                <span class="proyecto-status planeado">Planeado</span>
                            </div>
                            <p class="proyecto-desc">Estrategia de redes sociales y posicionamiento local.</p>
                            <div class="proyecto-metrics">
                                <div class="metric">
                                    <span class="metric-value">-</span>
                                    <span class="metric-label">Por iniciar</span>
                                </div>
                                <div class="metric">
                                    <span class="metric-value">-</span>
                                    <span class="metric-label">Por iniciar</span>
                                </div>
                            </div>
                            <div class="proyecto-actions">
                                <button class="btn-ver">Ver Detalles</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pestaña Configuración -->
                <div id="configuracion" class="tab-pane">
                    <div class="config-card danger-zone">
                        <h3>Zona de Peligro</h3>
                        <p>Estas acciones no se pueden deshacer</p>
                        <button class="btn-eliminar" onclick="confirmarEliminar()">Eliminar Cuenta</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <p>© 2025 - GrowFlow Agency. Todos los derechos reservados.</p>
        <div class="footer-links">
            <a href="client-form-contacto.php">Formulario de contacto</a>
            <a href="client-preguntas-frecuentes.php">Preguntas frecuentes</a>
        </div>
    </footer>

    <script>
        // Sistema de pestañas
        function openTab(tabName) {
            // Ocultar todos los paneles
            const paneles = document.querySelectorAll('.tab-pane');
            paneles.forEach(panel => panel.classList.remove('active'));

            // Remover active de todos los botones
            const botones = document.querySelectorAll('.tab-btn');
            botones.forEach(btn => btn.classList.remove('active'));

            // Mostrar el panel seleccionado
            document.getElementById(tabName).classList.add('active');

            // Activar el botón clickeado
            event.currentTarget.classList.add('active');
        }

        // Guardar cambios del perfil
        document.getElementById('formPerfil').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Aquí puedes agregar la lógica para enviar los datos al servidor
            const formData = new FormData(this);
            
            fetch('actualizar-perfil.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Cambios guardados exitosamente');
                    // Actualizar datos en la sesión si es necesario
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al guardar cambios');
            });
        });

        // Función para resetear el formulario
        function resetForm() {
            document.getElementById('formPerfil').reset();
        }

        // Cambiar contraseña
        document.getElementById('formPassword').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (newPassword !== confirmPassword) {
                alert('Las contraseñas no coinciden');
                return;
            }
            
            alert('Funcionalidad de cambiar contraseña en desarrollo');
        });

        // Confirmar eliminación de cuenta
        function confirmarEliminar() {
            if (confirm('¿Estás seguro de que quieres eliminar tu cuenta? Esta acción no se puede deshacer.')) {
                alert('Funcionalidad de eliminar cuenta en desarrollo');
                // Aquí iría la lógica para eliminar la cuenta
            }
        }

        // Cambiar foto de perfil
        document.addEventListener('DOMContentLoaded', function() {
            const avatarImg = document.querySelector('.perfil-avatar img');
            avatarImg.addEventListener('click', function() {
                const input = document.createElement('input');
                input.type = 'file';
                input.accept = 'image/*';
                input.onchange = function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        // Aquí puedes subir la imagen al servidor
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            avatarImg.src = event.target.result;
                        };
                        reader.readAsDataURL(file);
                        alert('Foto de perfil actualizada (funcionalidad completa en desarrollo)');
                    }
                };
                input.click();
            });
        });
    </script>

</body>

</html>