

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes de Contacto - GrowFlow Agency</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .mensajes-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .mensajes-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #3498db;
        }
        
        .mensajes-stats {
            display: flex;
            gap: 20px;
        }
        
        .stat-box {
            background: #f8f9fa;
            padding: 10px 20px;
            border-radius: 8px;
            border-left: 4px solid #3498db;
        }
        
        .mensajes-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
        }
        
        .mensaje-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-left: 5px solid #3498db;
            transition: transform 0.3s ease;
        }
        
        .mensaje-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
        }
        
        .mensaje-card.unread {
            border-left-color: #e74c3c;
            background: #fff5f5;
        }
        
        .mensaje-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 15px;
        }
        
        .mensaje-info h3 {
            margin: 0;
            color: #2c3e50;
        }
        
        .mensaje-meta {
            color: #7f8c8d;
            font-size: 14px;
            margin-top: 5px;
        }
        
        .mensaje-subject {
            color: #3498db;
            font-weight: bold;
            margin: 10px 0;
        }
        
        .mensaje-body {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            white-space: pre-wrap;
        }
        
        .mensaje-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        
        .btn-marcar {
            background: #3498db;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .btn-marcar:hover {
            background: #2980b9;
        }
        
        .btn-eliminar {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .btn-eliminar:hover {
            background: #c0392b;
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .status-leido {
            background: #d4edda;
            color: #155724;
        }
        
        .status-noleido {
            background: #f8d7da;
            color: #721c24;
        }
        
        .no-mensajes {
            text-align: center;
            padding: 40px;
            background: #f8f9fa;
            border-radius: 10px;
            color: #7f8c8d;
        }
        
        .filtros {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .btn-filtro {
            padding: 8px 15px;
            background: #ecf0f1;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        
        .btn-filtro.active {
            background: #3498db;
            color: white;
        }
    </style>
</head>
<body>

    <!-- Metanavegación -->
    <div class="meta-nav">
        <a href="admin-perfil.php">Mi Perfil</a>
        <a href="logout.php">Cerrar Sesión</a>
    </div>

    <!-- HEADER -->
    <header>
        <div class="logo">
            <img src="../imags/logo.png" alt="Logo" class="logo-img">
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
            <a href="admin-index.php">Inicio</a>
            <a href="admin-blog.php">Blog</a>
            <a href="admin-servicios.php">Servicios</a>
            <a href="admin-nosotros.php">Sobre Nosotros</a>
            <a href="admin-preguntas-frecuentes.php">Preguntas Frecuentes</a>
            <a href="admin-mensajes.php" class="active">Mensajes</a>
            <a href="admin-perfil.php">Perfil</a>
            <a href="logout.php" class="btn-logout">Cerrar Sesión</a>
        </nav>
    </header>

    <script>
        // Script para menú hamburguesa
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
        });
    </script>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="mensajes-container">
        <div class="mensajes-header">
            <h1>Mensajes de Contacto</h1>
            <div class="mensajes-stats">
                <div class="stat-box">
                    <strong>Total: </strong><?php echo $result->num_rows; ?>
                </div>
                <?php if ($unread_count > 0): ?>
                <div class="stat-box" style="border-left-color: #e74c3c;">
                    <strong>No leídos: </strong><?php echo $unread_count; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($result->num_rows > 0): ?>
        
        <div class="mensajes-grid">
            <?php while($mensaje = $result->fetch_assoc()): 
                $is_unread = isset($mensaje['read_status']) && $mensaje['read_status'] == 0;
            ?>
            <div class="mensaje-card <?php echo $is_unread ? 'unread' : ''; ?>" id="mensaje-<?php echo $mensaje['id']; ?>">
                <div class="mensaje-header">
                    <div class="mensaje-info">
                        <h3><?php echo htmlspecialchars($mensaje['name']); ?></h3>
                        <div class="mensaje-meta">
                            <strong>Email:</strong> <?php echo htmlspecialchars($mensaje['email']); ?>
                            <span style="margin: 0 10px">•</span>
                            <strong>Fecha:</strong> <?php echo date('d/m/Y H:i', strtotime($mensaje['created_at'])); ?>
                        </div>
                    </div>
                    <div class="mensaje-status">
                        <?php if (isset($mensaje['read_status'])): ?>
                            <span class="status-badge <?php echo $mensaje['read_status'] == 0 ? 'status-noleido' : 'status-leido'; ?>">
                                <?php echo $mensaje['read_status'] == 0 ? 'No leído' : 'Leído'; ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="mensaje-subject">
                    Asunto: <?php echo htmlspecialchars($mensaje['subject']); ?>
                </div>
                
                <div class="mensaje-body">
                    <?php echo nl2br(htmlspecialchars($mensaje['message'])); ?>
                </div>
                
                <div class="mensaje-actions">
                    <?php if (isset($mensaje['read_status']) && $mensaje['read_status'] == 0): ?>
                    <button class="btn-marcar" onclick="marcarComoLeido(<?php echo $mensaje['id']; ?>)">
                        Marcar como leído
                    </button>
                    <?php endif; ?>
                    <button class="btn-eliminar" onclick="eliminarMensaje(<?php echo $mensaje['id']; ?>)">
                        Eliminar
                    </button>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        
        <?php else: ?>
        <div class="no-mensajes">
            <h3>No hay mensajes recibidos</h3>
            <p>Todavía no has recibido mensajes a través del formulario de contacto.</p>
        </div>
        <?php endif; ?>
    </main>

    <!-- FOOTER -->
    <footer>
        <p>© 2025 - GrowFlow Agency. Todos los derechos reservados.</p>
        <div class="footer-links">
            <a href="admin-form-contacto.php">Formulario de contacto</a>
            <a href="admin-preguntas-frecuentes.php">Preguntas frecuentes</a>
        </div>
    </footer>

    <script>
        // Función para marcar mensaje como leído
        function marcarComoLeido(id) {
            fetch('marcar_leido.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + id
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const mensajeCard = document.getElementById('mensaje-' + id);
                    mensajeCard.classList.remove('unread');
                    
                    // Actualizar el badge de estado
                    const statusBadge = mensajeCard.querySelector('.status-badge');
                    if (statusBadge) {
                        statusBadge.textContent = 'Leído';
                        statusBadge.className = 'status-badge status-leido';
                    }
                    
                    // Ocultar el botón de marcar como leído
                    const btnMarcar = mensajeCard.querySelector('.btn-marcar');
                    if (btnMarcar) {
                        btnMarcar.style.display = 'none';
                    }
                    
                    // Actualizar contador de no leídos si existe
                    const unreadCounter = document.querySelector('.unread-counter');
                    if (unreadCounter) {
                        let current = parseInt(unreadCounter.textContent);
                        if (current > 0) {
                            unreadCounter.textContent = current - 1;
                        }
                    }
                } else {
                    alert('Error al marcar como leído: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al marcar como leído');
            });
        }

        // Función para eliminar mensaje
        function eliminarMensaje(id) {
            if (!confirm('¿Estás seguro de que quieres eliminar este mensaje? Esta acción no se puede deshacer.')) {
                return;
            }
            
            fetch('eliminar_mensaje.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + id
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const mensajeCard = document.getElementById('mensaje-' + id);
                    mensajeCard.style.opacity = '0.5';
                    setTimeout(() => {
                        mensajeCard.remove();
                        
                        // Si no quedan mensajes, mostrar mensaje de "no hay mensajes"
                        const mensajesGrid = document.querySelector('.mensajes-grid');
                        if (mensajesGrid && mensajesGrid.children.length === 0) {
                            mensajesGrid.innerHTML = `
                                <div class="no-mensajes">
                                    <h3>No hay mensajes recibidos</h3>
                                    <p>Todavía no has recibido mensajes a través del formulario de contacto.</p>
                                </div>
                            `;
                        }
                    }, 300);
                } else {
                    alert('Error al eliminar mensaje: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al eliminar mensaje');
            });
        }

        // Función para filtrar mensajes
        function filtrarMensajes(filtro) {
            const mensajes = document.querySelectorAll('.mensaje-card');
            mensajes.forEach(mensaje => {
                switch(filtro) {
                    case 'todos':
                        mensaje.style.display = 'block';
                        break;
                    case 'noleidos':
                        if (mensaje.classList.contains('unread')) {
                            mensaje.style.display = 'block';
                        } else {
                            mensaje.style.display = 'none';
                        }
                        break;
                    case 'leidos':
                        if (!mensaje.classList.contains('unread')) {
                            mensaje.style.display = 'block';
                        } else {
                            mensaje.style.display = 'none';
                        }
                        break;
                }
            });
            
            // Actualizar botones de filtro activos
            document.querySelectorAll('.btn-filtro').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
        }
    </script>

</body>
</html>

<?php
$conn->close();
?>