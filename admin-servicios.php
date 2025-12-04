<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrowFlow Agency - Servicios</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- METANAVEGACIÓN -->
    <div class="meta-nav">
        <a href="logout.php">Cerrar Sesión</a>
    </div>

    <!-- HEADER -->
    <header>
        <div class="logo">
            <img src="../imags/logo.png" alt="Logo" class="logo-img">
            <h1>GrowFlow Agency</h1>
        </div>


        <nav class="main-nav">
            <a href="admin-index.php">Inicio</a>
            <a href="admin-blog.php">Blog</a>
            <a href="admin-servicios.php">Servicios</a>
            <a href="admin-nosotros.php">Sobre Nosotros</a>
            <a href="admin-preguntas-frecuentes.php">Preguntas Frecuentes</a>
            <a href="admin-perfil.php">Perfil</a>
        </nav>
    </header>

    <!-- SECCIÓN SERVICIOS -->
    <section class="servicios">
        <h2 class="servicios-titulo">Servicios</h2>
        
        <div class="servicios-grid">
            <!-- Servicio 1: Planes de Marketing -->
            <div class="servicio-card" onclick="toggleServicio('servicio-1')">
                <div class="servicio-icono">
                    <div class="icono-bg">
                        <img src="../imags/servicios/planes-de-marketing.png" alt="Marketing" class="icono-img">
                    </div>
                </div>
                <div class="servicio-contenido">
                    <h3>Planes de Marketing</h3>
                    <p>Estrategias personalizadas para impulsar tu marca y alcanzar tus metas comerciales.</p>
                </div>
            </div>

            <!-- Servicio 2: Publicidad en Redes -->
            <div class="servicio-card" onclick="toggleServicio('servicio-2')">
                <div class="servicio-icono">
                    <div class="icono-bg">
                        <img src="../imags/servicios/publicidad-en-redes.png" alt="Redes Sociales" class="icono-img">
                    </div>
                </div>
                <div class="servicio-contenido">
                    <h3>Publicidad en Redes</h3>
                    <p>Campañas efectivas en redes sociales para conectar con tu audiencia ideal.</p>
                </div>
            </div>

            <!-- Servicio 3: Diseño Gráfico -->
            <div class="servicio-card" onclick="toggleServicio('servicio-3')">
                <div class="servicio-icono">
                    <div class="icono-bg">
                        <img src="../imags/servicios/diseño-gráfico.png" alt="Diseño Gráfico" class="icono-img">
                    </div>
                </div>
                <div class="servicio-contenido">
                    <h3>Diseño Gráfico</h3>
                    <p>Diseños creativos que comunican la identidad visual de tu marca.</p>
                </div>
            </div>

            <!-- Servicio 4: Estrategia Digital -->
            <div class="servicio-card" onclick="toggleServicio('servicio-4')">
                <div class="servicio-icono">
                    <div class="icono-bg">
                        <img src="../imags/servicios/estrategia-digital.png" alt="Estrategia Digital" class="icono-img">
                    </div>
                </div>
                <div class="servicio-contenido">
                    <h3>Estrategia Digital</h3>
                    <p>Consultoría especializada para optimizar tu presencia digital completa.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <p>© 2025 - GrowFlow Agency. Todos los derechos reservados.</p>
        <div class="footer-links">
            <a href="admin-form-contacto.php">Formulario de contacto</a>
            <a href="admin-preguntas-frecuentes.php">Preguntas frecuentes</a>
        </div>
    </footer>

</body>
</html>
