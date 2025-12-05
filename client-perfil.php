<?php
require_once 'auth.php';
requiereRol('client');
require_once 'db.php';

// Procesar actualización de perfil si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'update_profile') {
    $user_id = $_SESSION['user_id'];
    $name = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    
    if (!empty($name) && !empty($apellido) && !empty($email)) {
        // Verificar si el email ya existe en otro usuario
        $sql_check = "SELECT user_id FROM users WHERE email = ? AND user_id != ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("si", $email, $user_id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        
        if ($result_check->num_rows == 0) {
            // Actualizar datos del usuario
            $sql = "UPDATE users SET name = ?, apellido = ?, email = ?, phone = ? WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $name, $apellido, $email, $telefono, $user_id);
            
            if ($stmt->execute()) {
                // Actualizar datos en la sesión
                $_SESSION['name'] = $name;
                $_SESSION['apellido'] = $apellido;
                $_SESSION['email'] = $email;
                
                $success_msg = "Perfil actualizado correctamente";
            } else {
                $error_msg = "Error al actualizar el perfil: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error_msg = "Este email ya está registrado por otro usuario";
        }
        $stmt_check->close();
    } else {
        $error_msg = "Por favor, completa todos los campos obligatorios";
    }
}

// Procesar cambio de contraseña si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'change_password') {
    $user_id = $_SESSION['user_id'];
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if (!empty($current_password) && !empty($new_password) && !empty($confirm_password)) {
        if ($new_password === $confirm_password) {
            // Obtener la contraseña actual del usuario
            $sql = "SELECT password FROM users WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();
            
            // Verificar la contraseña actual
            if (password_verify($current_password, $user['password'])) {
                // Hashear la nueva contraseña
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                
                // Actualizar la contraseña
                $sql_update = "UPDATE users SET password = ? WHERE user_id = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("si", $hashed_password, $user_id);
                
                if ($stmt_update->execute()) {
                    $success_msg = "Contraseña cambiada correctamente";
                } else {
                    $error_msg = "Error al cambiar la contraseña";
                }
                $stmt_update->close();
            } else {
                $error_msg = "La contraseña actual es incorrecta";
            }
        } else {
            $error_msg = "Las contraseñas nuevas no coinciden";
        }
    } else {
        $error_msg = "Por favor, completa todos los campos de contraseña";
    }
}

// Obtener datos actualizados del usuario
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Actualizar datos de sesión
$_SESSION['name'] = $user['name'];
$_SESSION['apellido'] = $user['apellido'];
$_SESSION['email'] = $user['email'];
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
            <img src="imags/logo.png" alt="Logo" class="logo-img">
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
            <a href="client-index.php">Inicio</a>
            <a href="client-blog.php">Blog</a>
            <a href="client-servicios.php">Servicios</a>
            <a href="client-nosotros.php">Sobre Nosotros</a>
            <a href="client-preguntas-frecuentes.php">Preguntas Frecuentes</a>
            <a href="client-perfil.php">Perfil</a>
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
                    <img src="imags/perfil-generico.jpeg" alt="<?php echo htmlspecialchars($_SESSION['name']); ?>">
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
                                <h3>Publicidad en Redes</h3>
                                <span class="proyecto-status aprobado">Aprobado</span>
                            </div>
                            <p class="proyecto-desc">Campañas efectivas en redes sociales para conectar con tu audiencia ideal.</p>
                            
                            <div class="proyecto-actions">
                                <button class="btn-ver">Ver Detalles</button>
                            </div>
                        </div>

                        <div class="proyecto-card">
                            <div class="proyecto-header">
                                <h3>Planes de Marketing</h3>
                                <span class="proyecto-status pendiente">Pendiente</span>
                            </div>
                            <p class="proyecto-desc">Estrategias personalizadas para impulsar tu marca y alcanzar tus metas comerciales.</p>
                            
                            <div class="proyecto-actions">
                                <button class="btn-ver">Ver Detalles</button>
                            </div>
                        </div>

                        <div class="proyecto-card">
                            <div class="proyecto-header">
                                <h3>Estrategia Digital</h3>
                                <span class="proyecto-status rechazado">Rechazado</span>
                            </div>
                            <p class="proyecto-desc">Consultoría especializada para optimizar tu prescencia digital completa.</p>
                            
                            <div class="proyecto-actions">
                                <button class="btn-ver">Ver Detalles</button>
                            </div>
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

    // Guardar cambios del perfil CON MEJOR MANEJO DE ERRORES
    document.getElementById('formPerfil').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Mostrar confirmación
        if (!confirm('¿Guardar cambios en tu perfil?')) {
            return;
        }
        
        // Mostrar mensaje de carga
        const btnGuardar = this.querySelector('.btn-guardar');
        const originalText = btnGuardar.textContent;
        btnGuardar.textContent = 'Guardando...';
        btnGuardar.disabled = true;
        
        // Enviar datos
        const formData = new FormData(this);
        
        // Agregar el campo 'action' si no existe
        if (!formData.has('action')) {
            formData.append('action', 'update_profile');
        }
        
        console.log('Enviando datos:', Object.fromEntries(formData));
        
        fetch('actualizar-perfil.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            console.log('Respuesta recibida. Status:', response.status);
            
            // Primero obtener el texto para ver qué devuelve
            return response.text().then(text => {
                console.log('Texto de respuesta:', text);
                
                try {
                    // Intentar parsear como JSON
                    const data = JSON.parse(text);
                    return { ok: response.ok, data: data };
                } catch (error) {
                    console.error('No es JSON válido:', text);
                    // Si no es JSON, puede ser un error PHP
                    return { 
                        ok: false, 
                        data: { 
                            success: false, 
                            message: 'El servidor devolvió una respuesta inesperada' 
                        } 
                    };
                }
            });
        })
        .then(result => {
            console.log('Resultado procesado:', result);
            
            if (result.data.success) {
                alert('✅ ' + result.data.message);
                // Actualizar la información en la página
                if (result.data.data) {
                    document.querySelector('.perfil-info h2').textContent = 
                        result.data.data.nombre + ' ' + result.data.data.apellido;
                    document.querySelector('.perfil-email').textContent = result.data.data.email;
                    
                    // También actualizar valores en los campos
                    document.getElementById('nombre').value = result.data.data.nombre;
                    document.getElementById('apellido').value = result.data.data.apellido;
                    document.getElementById('email').value = result.data.data.email;
                }
            } else {
                alert('❌ ' + (result.data.message || 'Error al guardar cambios'));
            }
        })
        .catch(error => {
            console.error('Error en la petición:', error);
            
            // Verificar si el archivo existe
            fetch('actualizar-perfil.php')
                .then(res => {
                    if (res.ok) {
                        alert('🔌 Error de conexión con el servidor. Intenta recargar la página.');
                    } else {
                        alert('❌ El archivo "actualizar-perfil.php" no existe o tiene errores.');
                    }
                })
                .catch(() => {
                    alert('❌ No se puede acceder al servidor. Verifica tu conexión.');
                });
        })
        .finally(() => {
            // Restaurar botón
            btnGuardar.textContent = originalText;
            btnGuardar.disabled = false;
        });
    });

    // Función para resetear el formulario
    function resetForm() {
        // Cargar valores actuales desde la página (no desde PHP directamente)
        const nombreActual = document.querySelector('.perfil-info h2').textContent.split(' ')[0];
        const apellidoActual = document.querySelector('.perfil-info h2').textContent.split(' ')[1];
        const emailActual = document.querySelector('.perfil-email').textContent;
        
        document.getElementById('nombre').value = nombreActual;
        document.getElementById('apellido').value = apellidoActual || '';
        document.getElementById('email').value = emailActual;
        
        alert('Cambios cancelados. Valores restaurados.');
    }

    // Código para manejar la foto de perfil (opcional)
    document.addEventListener('DOMContentLoaded', function() {
        const avatarImg = document.querySelector('.perfil-avatar img');
        if (avatarImg) {
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
            
            // Agregar cursor pointer para indicar que es clickeable
            avatarImg.style.cursor = 'pointer';
            avatarImg.title = 'Haz clic para cambiar la foto de perfil';
        }
    });

    // Función para mostrar servicios (si quieres cargarlos dinámicamente)
    function cargarServicios() {
        // Esta función podría cargar los servicios reales del usuario
        console.log('Cargando servicios del usuario...');
        // Aquí iría un fetch a un endpoint que devuelva los servicios del usuario
    }

    // Cargar servicios cuando se abre la pestaña (opcional)
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (this.textContent.includes('Servicios')) {
                setTimeout(cargarServicios, 100);
            }
        });
    });

    // Agregar validación en tiempo real a los campos del formulario
    document.querySelectorAll('#formPerfil input').forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value.trim() === '') {
                this.style.borderColor = '#f44336';
            } else {
                this.style.borderColor = '';
            }
        });
        
        // Validación especial para email
        if (input.type === 'email') {
            input.addEventListener('input', function() {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (this.value && !emailRegex.test(this.value)) {
                    this.style.borderColor = '#f44336';
                } else {
                    this.style.borderColor = '';
                }
            });
        }
    });
    </script>

</body>

</html>