<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrowFlow Agency - Preguntas Frecuentes</title>
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

    <!-- SECCIÓN PREGUNTAS FRECUENTES -->
    <section class="preguntas-frecuentes">
        <div class="preguntas-contenido">
            <!-- Título principal -->
            <div class="preguntas-header">
                <h2>Preguntas Frecuentes</h2>
                <p class="preguntas-descripcion">
                    Encuentra respuestas a las dudas más comunes sobre nuestros servicios y procesos
                </p>
            </div>

            <!-- Grid de preguntas -->
            <div class="preguntas-grid">
                <!-- Pregunta 1 -->
                <div class="pregunta-card">
                    <div class="pregunta-icono">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="10" fill="var(--azul)"/>
                            <text x="12" y="16" text-anchor="middle" fill="white" font-size="12" font-weight="bold">1</text>
                        </svg>
                    </div>
                    <div class="pregunta-contenido">
                        <h3>¿Cómo inicio un proyecto con ustedes?</h3>
                        <p>Puedes contactarnos a través de nuestro formulario, agendar una consultoría gratuita o llamarnos directamente. Evaluaremos tus necesidades y te presentaremos una propuesta personalizada.</p>
                    </div>
                </div>

                <!-- Pregunta 2 -->
                <div class="pregunta-card">
                    <div class="pregunta-icono">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="10" fill="var(--azul)"/>
                            <text x="12" y="16" text-anchor="middle" fill="white" font-size="12" font-weight="bold">2</text>
                        </svg>
                    </div>
                    <div class="pregunta-contenido">
                        <h3>¿Cuánto tiempo toma ver resultados?</h3>
                        <p>Los tiempos varían según el servicio. Estrategias de redes sociales pueden mostrar resultados en 2-3 semanas, mientras que SEO puede tomar 3-6 meses. Te mantendremos informado del progreso constante.</p>
                    </div>
                </div>

                <!-- Pregunta 3 -->
                <div class="pregunta-card">
                    <div class="pregunta-icono">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="10" fill="var(--azul)"/>
                            <text x="12" y="16" text-anchor="middle" fill="white" font-size="12" font-weight="bold">3</text>
                        </svg>
                    </div>
                    <div class="pregunta-contenido">
                        <h3>¿Trabajan con presupuestos ajustados?</h3>
                        <p>Sí, ofrecemos planes escalables según tu presupuesto. Desde servicios básicos para startups hasta estrategias completas para empresas establecidas. Encontramos la solución ideal para ti.</p>
                    </div>
                </div>

                <!-- Pregunta 4 -->
                <div class="pregunta-card">
                    <div class="pregunta-icono">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="10" fill="var(--azul)"/>
                            <text x="12" y="16" text-anchor="middle" fill="white" font-size="12" font-weight="bold">4</text>
                        </svg>
                    </div>
                    <div class="pregunta-contenido">
                        <h3>¿Qué incluyen sus reportes de analytics?</h3>
                        <p>Nuestros reportes incluyen métricas clave, análisis de competencia, ROI, engagement, conversiones y recomendaciones específicas para optimizar tu estrategia continuamente.</p>
                    </div>
                </div>

                <!-- Pregunta 5 -->
                <div class="pregunta-card">
                    <div class="pregunta-icono">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="10" fill="var(--azul)"/>
                            <text x="12" y="16" text-anchor="middle" fill="white" font-size="12" font-weight="bold">5</text>
                        </svg>
                    </div>
                    <div class="pregunta-contenido">
                        <h3>¿Ofrecen servicios de emergencia?</h3>
                        <p>Sí, tenemos planes de respuesta rápida para crisis de reputación, lanzamientos urgentes o problemas técnicos. Contamos con un equipo disponible para situaciones críticas.</p>
                    </div>
                </div>

                <!-- Pregunta 6 -->
                <div class="pregunta-card">
                    <div class="pregunta-icono">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="10" fill="var(--azul)"/>
                            <text x="12" y="16" text-anchor="middle" fill="white" font-size="12" font-weight="bold">6</text>
                        </svg>
                    </div>
                    <div class="pregunta-contenido">
                        <h3>¿Pueden manejar redes sociales internacionales?</h3>
                        <p>Absolutamente. Contamos con especialistas en mercados globales y experiencia en campañas multilingües para llegar a audiencias en diferentes países y culturas.</p>
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