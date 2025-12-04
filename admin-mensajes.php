<?php
require_once 'auth.php';
requiereRol('admin');
require_once 'db.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes de Contacto - Panel Admin</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-image:
                radial-gradient(rgba(255, 255, 255, 0.08) 1px, transparent 1px),
                linear-gradient(135deg, var(--negro) 20%, var(--azul) 100%);
        }

        @media (max-width: 768px) {
            .mensajes-table {
                display: block;
                overflow-x: auto;
            }

            .acciones {
                flex-direction: column;
            }

            .mensajes-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
        }
    </style>
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

        <nav class="main-nav">
            <a href="admin-index.php">Inicio</a>
            <a href="admin-servicios.php">Servicios</a>
            <a href="admin-mensajes.php">Mensajes</a>
            <a href="admin-perfil.php">Perfil</a>
        </nav>
    </header>

    <!-- CONTENIDO PRINCIPAL -->
    <section class="mensajes-container">
        <div class="mensajes-header">
            <h2 class="mensajes-title">Mensajes de Contacto</h2>
            <div class="filtros">
                <button class="btn-filtro active" data-estado="todos">Todos</button>
                <button class="btn-filtro" data-estado="pending">Pendientes</button>
            </div>
        </div>

        <?php
        // Procesar cambio de estado
        if (isset($_GET['cambiar_estado'])) {
            $contact_id = intval($_GET['contact_id']);
            $nuevo_estado = $_GET['nuevo_estado'];

            if (in_array($nuevo_estado, ['pending', 'completed'])) {
                $stmt = $conn->prepare("UPDATE contact_forms SET status = ? WHERE contact_id = ?");
                $stmt->bind_param("si", $nuevo_estado, $contact_id);

                if ($stmt->execute()) {
                    echo "<script>alert('Estado actualizado correctamente');</script>";
                }
                $stmt->close();
            }
        }

        // Obtener mensajes
        $sql = "SELECT * FROM contact_forms ORDER BY sent_date DESC";
        $result = $conn->query($sql);
        ?>

        <?php if ($result->num_rows > 0): ?>
            <table class="mensajes-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Asunto</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="mensaje-fila" data-estado="<?php echo $row['status']; ?>">
                            <td><?php echo $row['contact_id']; ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($row['sent_date'])); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['subject']); ?></td>
                            <td>
                                <span class="estado-badge estado-<?php echo $row['status']; ?>">
                                    <?php echo $row['status'] == 'pending' ? 'Pendiente' : 'Leído'; ?>
                                </span>
                            </td>
                            <td class="acciones">
                                <button class="btn-accion btn-ver" onclick="verDetalle(<?php echo htmlspecialchars(json_encode($row)); ?>)">
                                    Ver
                                </button>
                                <?php if ($row['status'] == 'pending'): ?>
                                    <a href="?cambiar_estado=true&contact_id=<?php echo $row['contact_id']; ?>&nuevo_estado=completed"
                                        class="btn-accion btn-leido">
                                        Marcar como leído
                                    </a>
                                <?php else: ?>
                                    <a href="?cambiar_estado=true&contact_id=<?php echo $row['contact_id']; ?>&nuevo_estado=pending"
                                        class="btn-accion btn-pendiente">
                                        Marcar como pendiente
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="sin-mensajes">
                <p>No hay mensajes de contacto aún.</p>
            </div>
        <?php endif; ?>
    </section>

    <!-- Modal para ver detalle -->
    <div id="modalDetalle" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
        <div style="background: white; padding: 30px; border-radius: 8px; max-width: 600px; width: 90%; max-height: 80vh; overflow-y: auto;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="margin: 0;">Detalle del Mensaje</h3>
                <button onclick="cerrarDetalle()" style="background: none; border: none; font-size: 24px; cursor: pointer; color: #666;">×</button>
            </div>
            <div id="detalleContenido"></div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer>
        <p>© 2025 - GrowFlow Agency. Todos los derechos reservados.</p>
        <div class="footer-links">
            <a href="admin-mensajes.php">Mensajes</a>
        </div>
    </footer>

    <script>
        // Filtros
        document.querySelectorAll('.btn-filtro').forEach(btn => {
            btn.addEventListener('click', function() {
                // Quitar clase active a todos
                document.querySelectorAll('.btn-filtro').forEach(b => b.classList.remove('active'));
                // Agregar a este
                this.classList.add('active');

                const estado = this.dataset.estado;
                const filas = document.querySelectorAll('.mensaje-fila');

                filas.forEach(fila => {
                    if (estado === 'todos' || fila.dataset.estado === estado) {
                        fila.style.display = '';
                    } else {
                        fila.style.display = 'none';
                    }
                });
            });
        });

        // Función para ver detalle
        function verDetalle(mensaje) {
            const fecha = new Date(mensaje.sent_date);
            const fechaFormateada = fecha.toLocaleDateString('es-ES', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            const contenido = `
                <div class="mensaje-detalle">
                    <div class="info-item">
                        <span class="info-label">ID:</span>
                        <span class="info-value">${mensaje.contact_id}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Fecha:</span>
                        <span class="info-value">${fechaFormateada}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Nombre:</span>
                        <span class="info-value">${mensaje.name}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email:</span>
                        <span class="info-value">${mensaje.email}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Asunto:</span>
                        <span class="info-value">${mensaje.subject}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Estado:</span>
                        <span class="info-value estado-badge estado-${mensaje.status}">
                            ${mensaje.status === 'pending' ? 'Pendiente' : 'Leído'}
                        </span>
                    </div>
                </div>
                <div class="mensaje-texto">
                    <strong>Mensaje:</strong><br>
                    ${mensaje.message.replace(/\n/g, '<br>')}
                </div>
            `;

            document.getElementById('detalleContenido').innerHTML = contenido;
            document.getElementById('modalDetalle').style.display = 'flex';
        }

        // Función para cerrar detalle
        function cerrarDetalle() {
            document.getElementById('modalDetalle').style.display = 'none';
        }

        // Cerrar modal al hacer clic fuera
        document.getElementById('modalDetalle').addEventListener('click', function(e) {
            if (e.target === this) {
                cerrarDetalle();
            }
        });

        // Cerrar con tecla Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                cerrarDetalle();
            }
        });
    </script>

</body>

</html>

<?php $conn->close(); ?>