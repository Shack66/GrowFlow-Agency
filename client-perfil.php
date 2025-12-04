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
            <a href="logout.php" class="client-btn-logout">Cerrar Sesión</a>
        </nav>
    </header>

    <!-- Overlay para móvil (se crea dinámicamente) -->

    <script>
        // Script para menú hamburguesa cliente
        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.getElementById('clientHamburger');
            const mainNav = document.getElementById('clientMainNav');
            const menuOverlay = document.createElement('div');
            
            // Crear overlay
            menuOverlay.className = 'client-menu-overlay';
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
            document.querySelectorAll('.client-main-nav a').forEach(link => {
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
                    <img src="imags/nosotros/samuel.jpg" alt="Samuel Arosemena">
                </div>
                <div class="perfil-info">
                    <h2>Samuel Arosemena</h2>
                    <p class="perfil-email">samuel.arosemena@growflow.com</p>
                    <div class="perfil-stats">
                        <div class="stat">
                            <span class="stat-num">12</span>
                            <span class="stat-label">Proyectos</span>
                        </div>
                        <div class="stat">
                            <span class="stat-num">3</span>
                            <span class="stat-label">Años</span>
                        </div>
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
                        <div class="form-row">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" id="nombre" value="Samuel Arosemena">
                            </div>
                            <div class="form-group">
                                <label for="nombre">Apellido</label>
                                <input type="text" id="nombre" value="Samuel Arosemena">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" value="samuel.arosemena@growflow.com">
                            </div>
                        </div>

                        <div class="form-buttons">
                            <button class="btn-guardar">Guardar Cambios</button>
                            <button class="btn-cancelar">Cancelar</button>
                        </div>
                    </div>
                </div>

                <!-- Pestaña Proyecto -->
                <div id="servicios" class="tab-pane">
                    <div class="proyectos-grid">
                        <div class="proyecto-card">
                            <div class="proyecto-header">
                                <h3>Publicidad en Redes</h3>
                                <span class="proyecto-status aprobado">Aprobado</span>
                            </div>
                            <p class="proyecto-desc">Campañas efectivas en redes sociales para conectar con tu audiencia ideal.</p>
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
                                <h3>Diseño Gráfico</h3>
                                <span class="proyecto-status pendiente">Pendiente</span>
                            </div>
                            <p class="proyecto-desc">Diseños creativos que comunican la identidad visual de tu marca.</p>
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
                                <h3>Planes de Marketing</h3>
                                <span class="proyecto-status rechazado">Rechazado</span>
                            </div>
                            <p class="proyecto-desc">Estrategias personalizadas para impulsar tu marca y alcanzar tus metas comerciales.</p>
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
                        <button class="btn-eliminar">Eliminar Cuenta</button>
                    </div>
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
        document.querySelector('.btn-guardar').addEventListener('click', function() {
            alert('Cambios guardados exitosamente');
        });

        // Cambiar foto de perfil (simulado)
        document.querySelector('.btn-cambiar-foto').addEventListener('click', function() {
            alert('Funcionalidad de cambiar foto en desarrollo');
        });
    </script>

</body>

</html>