<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrowFlow Agency - Nosotros</title>
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

    <!-- SECCIÓN NOSOTROS -->
    <section class="nosotros">
        <div class="nosotros-contenido">
            <!-- Información principal -->
            <div class="nosotros-intro">
                <h2 style = "text-align: center;">Sobre Nosotros</h2>
                <p style="text-align: justify;">
                    En <strong>GrowFlow Agency</strong> somos un equipo apasionado de expertos en marketing digital 
                    comprometidos con impulsar el crecimiento de tu negocio. Combinamos creatividad, estrategia 
                    y análisis de datos para entregar resultados tangibles que superan las expectativas.
                </p>
                <p style="text-align: justify;">
                    Nuestra filosofía se basa en la transparencia, la innovación constante y la construcción 
                    de relaciones a largo plazo con cada uno de nuestros clientes. Creemos que el éxito 
                    digital no es un destino, sino un viaje continuo de crecimiento y adaptación.
                </p>
            </div>

            <!-- Grid del equipo -->
            <div class="equipo-grid">
                <h3>Nuestro Equipo</h3>
                <p class="equipo-descripcion">
                    Conoce al talentoso equipo detrás de cada estrategia exitosa
                </p>

                <div class="equipo-cards">
                    <!-- Integrante 1 -->
                    <div class="integrante-card">
                        <div class="integrante-imagen">
                            <img src="imags/nosotros/octavio.jpg" alt="Octavio Ramos">
                        </div>
                        <div class="integrante-info">
                            <h4>Octavio Ramos</h4>
                            <p>Especialista en Estrategia Digital</p>
                        </div>
                    </div>

                    <!-- Integrante 2 -->
                    <div class="integrante-card">
                        <div class="integrante-imagen">
                            <img src="imags/nosotros/paola.jpg" alt="Paola Ran">
                        </div>
                        <div class="integrante-info">
                            <h4>Paola Ran</h4>
                            <p>Directora de Diseño y Creatividad</p>
                        </div>
                    </div>

                    <!-- Integrante 3 -->
                    <div class="integrante-card">
                        <div class="integrante-imagen">
                            <img src="imags/nosotros/samuel.jpg" alt="Samuel Arosemena">
                        </div>
                        <div class="integrante-info">
                            <h4>Samuel Arosemena</h4>
                            <p>Gerente de Marketing y Analytics</p>
                        </div>
                    </div>

                    <!-- Integrante 4 -->
                    <div class="integrante-card">
                        <div class="integrante-imagen">
                            <img src="imags/nosotros/alexis.jpg" alt="Alexis Miranda">
                        </div>
                        <div class="integrante-info">
                            <h4>Alexis Miranda</h4>
                            <p>Especialista en Publicidad Digital</p>
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

</body>
</html>