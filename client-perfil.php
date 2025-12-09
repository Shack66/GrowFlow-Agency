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
    
    if (!empty($name) && !empty($apellido) && !empty($email)) {
        // Verificar si el email ya existe en otro usuario
        $sql_check = "SELECT user_id FROM users WHERE email = ? AND user_id != ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("si", $email, $user_id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        
        if ($result_check->num_rows == 0) {
            // Actualizar datos del usuario
            $sql = "UPDATE users SET name = ?, apellido = ?, email = ? WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $name, $apellido, $email, $user_id);
            
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

    <!-- SECCIÓN PERFIL -->
    <section class="perfil">
        <div class="perfil-contenido">
            <!-- Header del Perfil -->
            <div class="perfil-header">
                <div class="perfil-avatar">
                    <img src="imags/perfil-generico.jpeg" alt="<?php echo htmlspecialchars($_SESSION['name']); ?>">
                </div>
                <div class="perfil-info">
                    <h2><?php echo htmlspecialchars($_SESSION['name'] . ' ' . $_SESSION['apellido']); ?></h2>
                    <p class="perfil-email"><?php echo htmlspecialchars($_SESSION['email']); ?></p>
                </div>
            </div>

            <!-- Contenido del Perfil -->
            <div class="perfil-body">
                <div class="formulario-perfil">
                    <form id="formPerfil" method="POST" action="actualizar-perfil.php">
                        <input type="hidden" name="action" value="update_profile">
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="apellido">Apellido</label>
                                <input type="text" id="apellido" name="apellido" value="<?php echo htmlspecialchars($user['apellido']); ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>

                        <div class="form-buttons">
                            <button type="submit" class="btn-guardar">Guardar Cambios</button>
                            <button type="button" class="btn-cancelar" onclick="resetForm()">Cancelar</button>
                        </div>
                    </form>
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
        // Guardar cambios del perfil
        document.getElementById('formPerfil').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!confirm('¿Guardar cambios en tu perfil?')) {
                return;
            }
            
            const btnGuardar = this.querySelector('.btn-guardar');
            const originalText = btnGuardar.textContent;
            btnGuardar.textContent = 'Guardando...';
            btnGuardar.disabled = true;
            
            const formData = new FormData(this);
            
            fetch('actualizar-perfil.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(text => {
                console.log('Respuesta:', text);
                
                try {
                    const data = JSON.parse(text);
                    
                    if (data.success) {
                        alert('✅ ' + data.message);
                        
                        if (data.data) {
                            document.querySelector('.perfil-info h2').textContent = 
                                data.data.nombre + ' ' + data.data.apellido;
                            document.querySelector('.perfil-email').textContent = data.data.email;
                            
                            document.getElementById('nombre').value = data.data.nombre;
                            document.getElementById('apellido').value = data.data.apellido;
                            document.getElementById('email').value = data.data.email;
                        }
                    } else {
                        alert('❌ ' + (data.message || 'Error al guardar cambios'));
                    }
                } catch (error) {
                    console.error('Error parseando JSON:', text);
                    alert('❌ Error del servidor. Revisa la consola para más detalles.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('❌ Error de conexión. Por favor, intenta de nuevo.');
            })
            .finally(() => {
                btnGuardar.textContent = originalText;
                btnGuardar.disabled = false;
            });
        });

        // Función para resetear el formulario
        function resetForm() {
            if (confirm('¿Descartar los cambios y restaurar los valores originales?')) {
                location.reload();
            }
        }

        // Código para foto de perfil (opcional)
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
                
                avatarImg.style.cursor = 'pointer';
                avatarImg.title = 'Haz clic para cambiar la foto de perfil';
            }
        });

        // Validación en tiempo real
        document.querySelectorAll('#formPerfil input').forEach(input => {
            input.addEventListener('blur', function() {
                if (this.required && this.value.trim() === '') {
                    this.style.borderColor = '#f44336';
                } else {
                    this.style.borderColor = '';
                }
            });
            
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