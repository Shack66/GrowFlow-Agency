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

        .mensajes-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }

        .mensajes-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #4a90e2;
        }

        .mensajes-title {
            font-size: 28px;
            color: white;
        }

        .filtros {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .btn-filtro {
            padding: 8px 16px;
            background: #f0f0f0;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-filtro.active {
            background: #4a90e2;
            color: white;
            border-color: #4a90e2;
        }

        .btn-filtro:hover {
            background: #e0e0e0;
        }

        .btn-filtro.active:hover {
            background: #3a80d2;
        }

        .mensajes-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .mensajes-table th,
        .mensajes-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .mensajes-table th {
            background: var(--azul);
            color: white;
            font-weight: 600;
        }

        .mensajes-table tr:hover {
            background: #f9f9f9;
        }

        .estado-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .estado-pendiente {
            background: #ffeaa7;
            color: #d35400;
        }

        .estado-leido {
            background: #55efc4;
            color: #00b894;
        }

        .acciones {
            display: flex;
            gap: 10px;
        }

        .btn-accion {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s;
        }

        .btn-leido {
            background: #4a90e2;
            color: white;
        }

        .btn-leido:hover {
            background: #3a80d2;
        }

        .btn-pendiente {
            background: #fdcb6e;
            color: #333;
        }

        .btn-pendiente:hover {
            background: #fdc14a;
        }

        .sin-mensajes {
            text-align: center;
            padding: 50px;
            color: #666;
            font-size: 18px;
        }

        .mensaje-detalle {
            background: #f8f9fa;
            border-left: 4px solid #4a90e2;
            padding: 15px;
            margin: 10px 0;
            border-radius: 4px;
        }

        .info-item {
            margin-bottom: 8px;
        }

        .info-label {
            font-weight: 600;
            color: #555;
            display: inline-block;
            width: 120px;
        }

        .info-value {
            color: #333;
        }

        .mensaje-texto {
            white-space: pre-wrap;
            background: white;
            padding: 15px;
            border-radius: 4px;
            border: 1px solid #eee;
            margin-top: 10px;
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
                <button class="btn-filtro" data-estado="completed">Leídos</button>
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