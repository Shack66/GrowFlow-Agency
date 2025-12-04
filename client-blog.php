<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Growflow Agency - Blog</title>
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

    <!-- CONTENIDO PRINCIPAL -->
    <main class="blog-contenedor">
        <h2 class="blog-titulo">Blog</h2>

        <div class="blog-grid">

            <!-- COLUMNA IZQUIERDA -->
            <div class="blog-col-izq">

                <div class="blog-card-horizontal">
                    <img src="imags/noticias/noticia1.jpg" alt="Noticia 1" class="blog-img-peq">
                    <div class="blog-texto">
                        <h3>Teléfonos convertidos en magos publicitarios</h3>
                        <p>
                            Tabletas, smartphones y relojes inteligentes redefinen la publicidad gracias a la IA. Avanzan las preferencias de los usuarios y mejoran la efectividad del impacto.
                            <br>
                            <a href="https://elpais.com/extra/publicidad/2024-01-25/telefonos-convertidos-en-magos-publicitarios.html" target="_blank" class="blog-link">
                                Leer más...
                            </a>
                        </p>
                    </div>
                </div>

                <div class="blog-card-horizontal">
                    <img src="imags/noticias/noticia2.webp" alt="Noticia 2" class="blog-img-grande">
                    <div class="blog-texto">
                        <h3>Emocionar a las personas y convencer a los algoritmos: Tendencias del Marketing y los negocios para el 2026</h3>
                        <a href="https://www.puromarketing.com/88/216417/emocionar-personas-convencer-algoritmos-tendencias-marketing-negocios-para-2026" target="_blank" class="blog-link">
                            Leer más...
                        </a>
                    </div>
                </div>

            </div>

            <!-- COLUMNA DERECHA -->
            <div class="blog-col-der">

                <div class="blog-card-vertical">
                    <img src="imags/noticias/noticia3.png" alt="Noticia 3" class="blog-img-peq">
                    <div class="blog-texto">
                        <h3>Meta recurrirá la sentencia que le condena a pagar 479 M€ a la prensa española</h3>
                        <p>
                            Meta no esta de acuerdo con la sentencia dictada por el Juzgado de lo Mercantil número 15 de Madrid, que condena a la tecnológica a pagar 479 millones de euros a 87 editoras de prensa digital española.
                            <br>
                            <a href="https://dircomfidencial.com/medios/meta-recurrira-la-sentencia-que-le-condena-a-pagar-479-me-a-la-prensa-espanola-20251120-1059/" target="_blank" class="blog-link">
                                Leer más...
                            </a>
                        </p>
                    </div>
                </div>

                <div class="blog-card-vertical">
                    <img src="imags/noticias/noticia4.webp" alt="Noticia 4" class="blog-img-peq">
                    <div class="blog-texto">
                        <h3>Coca-Cola revoluciona su marketing en la era de la IA</h3>
                        <p>
                            El vicepresidente global de estrategia creativa y contenido de Coca-Cola, Islam ElDessouky, explica el nuevo rumbo publicitario que está adoptando compañía.
                            <br>
                            <a href="https://www.marketingdirecto.com/anunciantes-general/coca-cola-revoluciona-marketing-inteligencia-artificial" target="_blank" class="blog-link">
                                Leer más...
                            </a>
                        </p>
                    </div>
                </div>

            </div>

        </div>

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