<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrowFlow Agency</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Alineación mejorada para admin-actions */
        .admin-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-refresh {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            flex-shrink: 0;
        }

        .filtros {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .filtros select {
            height: 45px;
            padding: 10px 15px;
        }
    </style>
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

        <!-- Botón hamburguesa (agregado para consistencia) -->
        <button class="hamburger" id="hamburger" aria-label="Menú">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>
<<<<<<< Updated upstream

        <!-- Navegación -->
        <nav class="main-nav" id="mainNav">
=======
        
        <!-- Navegación -->
        <nav class="main-nav">
>>>>>>> Stashed changes
            <a href="admin-index.php">Inicio</a>
            <a href="admin-servicios.php">Servicios</a>
            <a href="admin-mensajes.php">Mensajes</a>
            <a href="admin-perfil.php">Perfil</a>
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

    <!-- CONTENIDO PRINCIPAL -->
    <main class="admin-container">
        <div class="admin-header">
            <h2 class="admin-title">Servicios Solicitados</h2>
            <div class="admin-actions">
                <button class="btn-refresh" onclick="cargarServicios()" title="Actualizar lista">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M15.65 4.35A8 8 0 1 0 17.4 10h-2.22a6 6 0 1 1-1-7.22L11 5h5V0l-2.35 2.35z"/>
                    </svg>
                </button>
                <div class="filtros">
                    <select id="filtro-estado" onchange="filtrarServicios()">
                        <option value="">Todos los estados</option>
                        <option value="pending">Pendientes</option>
                        <option value="accepted">Aceptados</option>
                        <option value="rejected">Rechazados</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- ESTADÍSTICAS -->
        <div class="admin-stats" id="estadisticas">
            <div class="stat-card">
                <h3>Total</h3>
                <p class="stat-number" id="total-servicios">0</p>
            </div>
            <div class="stat-card">
                <h3>Pendientes</h3>
                <p class="stat-number stat-pendiente" id="pendientes">0</p>
            </div>
            <div class="stat-card">
                <h3>Aceptados</h3>
                <p class="stat-number stat-aceptado" id="aceptados">0</p>
            </div>
            <div class="stat-card">
                <h3>Rechazados</h3>
                <p class="stat-number stat-rechazado" id="rechazados">0</p>
            </div>
        </div>

        <!-- LISTA DE SERVICIOS -->
        <div class="servicios-lista" id="servicios-lista">
            <div class="loading">
                <div class="spinner"></div>
                <p>Cargando servicios...</p>
            </div>
        </div>
    </main>

    <!-- MODAL DE CONFIRMACIÓN -->
    <div class="modal-overlay" id="modal-confirmacion">
        <div class="modal-contenido modal-sm">
            <div class="modal-header">
                <h3 id="confirmacion-titulo">Confirmar acción</h3>
                <button class="modal-cerrar" onclick="cerrarConfirmacion()">&times;</button>
            </div>
            
            <div class="modal-body">
                <p id="confirmacion-mensaje">¿Estás seguro?</p>
                <div class="form-group" id="notas-container" style="display: none;">
                    <label for="confirmacion-notas">Notas (opcional):</label>
                    <textarea id="confirmacion-notas" rows="3" placeholder="Agregar comentarios..."></textarea>
                </div>
            </div>
            
            <div class="modal-footer">
                <button class="btn-cancelar" onclick="cerrarConfirmacion()">Cancelar</button>
                <button class="btn-confirmar" id="btn-confirmar-accion">Confirmar</button>
            </div>
        </div>
    </div>

    <!-- MODAL DETALLES DEL SERVICIO -->
    <div class="modal-overlay" id="modal-detalles-admin">
        <div class="modal-contenido">
            <div class="modal-header">
                <h3>Detalles del Servicio</h3>
                <button class="modal-cerrar" onclick="cerrarDetallesAdmin()">&times;</button>
            </div>
            <div class="modal-body" id="detalles-admin-contenido">
                <!-- Se llenará dinámicamente -->
            </div>
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
    // Variables globales
    let todosServicios = [];
    let accionPendiente = null;

    // Función para cargar servicios
    function cargarServicios() {
        const contenedor = document.getElementById('servicios-lista');
        contenedor.innerHTML = `
            <div class="loading">
                <div class="spinner"></div>
                <p>Cargando servicios...</p>
            </div>
        `;

        console.log('Iniciando carga de servicios...');
        
        fetch('admin_obtener_servicios.php')
            .then(response => {
                console.log('Respuesta HTTP:', response.status, response.statusText);
                if (!response.ok) {
                    throw new Error(`Error HTTP: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Datos recibidos:', data);
                
                if (data.error) {
                    console.error('Error en datos:', data);
                    contenedor.innerHTML = `
                        <div class="error">
                            <p>${data.mensaje || 'Error al cargar servicios'}</p>
                            <p style="font-size: 12px; color: #666;">Detalles en consola</p>
                        </div>
                    `;
                    return;
                }

                if (!data.data) {
                    console.warn('No hay propiedad data en la respuesta');
                    contenedor.innerHTML = `
                        <div class="error">
                            <p>Formato de respuesta incorrecto</p>
                        </div>
                    `;
                    return;
                }

                todosServicios = data.data || [];
                console.log(`${todosServicios.length} servicios cargados`);
                
                actualizarEstadisticas(todosServicios);
                mostrarServicios(todosServicios);
            })
            .catch(error => {
                console.error('Error de fetch:', error);
                contenedor.innerHTML = `
                    <div class="error">
                        <p>Error de conexión. Intenta más tarde.</p>
                        <p style="font-size: 12px; color: #666;">${error.message}</p>
                    </div>
                `;
            });
    }

    // Actualizar estadísticas
    function actualizarEstadisticas(servicios) {
        const total = servicios.length;
        const pendientes = servicios.filter(s => s.status === 'pending').length;
        const aceptados = servicios.filter(s => s.status === 'approved' || s.status === 'accepted').length;
        const rechazados = servicios.filter(s => s.status === 'rejected').length;

        document.getElementById('total-servicios').textContent = total;
        document.getElementById('pendientes').textContent = pendientes;
        document.getElementById('aceptados').textContent = aceptados;
        document.getElementById('rechazados').textContent = rechazados;
    }

    // Mostrar detalles del servicio en modal
    function mostrarDetallesAdmin(servicio) {
        const modal = document.getElementById('modal-detalles-admin');
        const contenido = document.getElementById('detalles-admin-contenido');
        
        // Formatear fecha
        const fecha = servicio.created_at ? 
            new Date(servicio.created_at).toLocaleDateString('es-ES', {
                weekday: 'long',
                day: '2-digit',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            }) : 'Fecha no disponible';
        
        // Determinar estado
        const statusNormalizado = (servicio.status || 'pending').toLowerCase().trim();
        let estadoTexto = '';
        let estadoColor = '';
        let estadoBg = '';
        
        switch(statusNormalizado) {
            case 'pending':
                estadoTexto = 'PENDIENTE';
                estadoColor = '#0C5460';
                estadoBg = '#D1ECF1';
                break;
            case 'accepted':
            case 'approved':
                estadoTexto = 'ACEPTADO';
                estadoColor = '#155724';
                estadoBg = '#D4EDDA';
                break;
            case 'rejected':
                estadoTexto = 'RECHAZADO';
                estadoColor = '#721C24';
                estadoBg = '#F8D7DA';
                break;
            default:
                estadoTexto = 'PENDIENTE';
                estadoColor = '#856404';
                estadoBg = '#FFF3CD';
        }
        
        let html = `
            <div class="modal-seccion">
                <h3>Información General</h3>
                <div class="detalle-item">
                    <strong>Servicio:</strong> 
                    <span>${servicio.service_name}</span>
                </div>
                <div class="detalle-item">
                    <strong>ID de solicitud:</strong> 
                    <span>${servicio.request_id}</span>
                </div>
                <div class="detalle-item">
                    <strong>Cliente:</strong> 
                    <span>${servicio.user_name || 'Usuario desconocido'}</span>
                </div>
                <div class="detalle-item">
                    <strong>Email:</strong> 
                    <span>${servicio.user_email || 'Email no disponible'}</span>
                </div>
                <div class="detalle-item">
                    <strong>Fecha de solicitud:</strong> 
                    <span>${fecha}</span>
                </div>
                <div class="detalle-item">
                    <strong>Estado:</strong> 
                    <span class="estado-badge-modal" style="background: ${estadoBg}; color: ${estadoColor};">
                        ${estadoTexto}
                    </span>
                </div>
            </div>
        `;
        
        // Procesar y mostrar respuestas del formulario
        if (servicio.answers) {
            try {
                const answers = typeof servicio.answers === 'string' ? 
                    JSON.parse(servicio.answers) : servicio.answers;
                
                const preguntas_labels = {
                    'pregunta-0': '¿Cuál es tu objetivo principal?',
                    'pregunta-1': '¿Cuál es tu presupuesto mensual aproximado?',
                    'pregunta-2': '¿Cuánto tiempo llevas en el mercado?',
                    'pregunta-3': 'Describe tu necesidad específica para este servicio'
                };
                
                let respuestasHTML = '';
                for (let key in answers) {
                    if (key.startsWith('pregunta-')) {
                        const pregunta = preguntas_labels[key] || key;
                        const respuesta = answers[key] || 'Sin respuesta';
                        
                        respuestasHTML += `
                            <div class="form-group-filled-modal">
                                <label class="form-label-filled-modal">${pregunta}</label>
                                <div class="form-input-filled-modal">${respuesta}</div>
                            </div>
                        `;
                    }
                }
                
                if (respuestasHTML) {
                    html += `
                        <div class="modal-seccion">
                            <h3>Respuestas del Formulario</h3>
                            <div class="formulario-respuestas-modal">
                                ${respuestasHTML}
                            </div>
                        </div>
                    `;
                }
            } catch (e) {
                console.error('Error procesando respuestas:', e);
            }
        }
        
        // Sección de reunión
        html += '<div class="modal-seccion">';
        html += '<h3>Información de Reunión</h3>';
        
        if (servicio.meeting_date && servicio.meeting_date !== '0000-00-00' && 
            servicio.meeting_time && servicio.meeting_time !== '00:00:00') {
            try {
                const fechaReunion = new Date(servicio.meeting_date).toLocaleDateString('es-ES', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                });
                const horaReunion = servicio.meeting_time.substring(0, 5);
                
                html += `
                    <div class="reunion-info-modal con-reunion">
                        <div class="reunion-icon-modal">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="12" r="10" stroke="#005FCC" stroke-width="2" fill="none"/>
                                <path d="M12 6V12L16 16" stroke="#005FCC" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div>
                            <div class="reunion-titulo-modal">Reunión Solicitada</div>
                            <div class="reunion-fecha-modal">${fechaReunion} a las ${horaReunion}</div>
                        </div>
                    </div>
                `;
            } catch (e) {
                html += `
                    <div class="reunion-info-modal sin-reunion">
                        <div class="reunion-icon-modal">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="12" r="10" stroke="#999" stroke-width="2" fill="none"/>
                                <path d="M8 8L16 16M16 8L8 16" stroke="#999" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div>
                            <div class="reunion-titulo-modal">Sin Reunión Agendada</div>
                            <div class="reunion-fecha-modal">No se solicitó reunión para este servicio</div>
                        </div>
                    </div>
                `;
            }
        } else {
            html += `
                <div class="reunion-info-modal sin-reunion">
                    <div class="reunion-icon-modal">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="10" stroke="#999" stroke-width="2" fill="none"/>
                            <path d="M8 8L16 16M16 8L8 16" stroke="#999" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div>
                        <div class="reunion-titulo-modal">Sin Reunión Agendada</div>
                        <div class="reunion-fecha-modal">No se solicitó reunión para este servicio</div>
                    </div>
                </div>
            `;
        }
        
        html += '</div>';
        
        contenido.innerHTML = html;
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    // Cerrar modal de detalles
    function cerrarDetallesAdmin() {
        document.getElementById('modal-detalles-admin').classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    // Mostrar servicios en lista
    function mostrarServicios(servicios) {
        const contenedor = document.getElementById('servicios-lista');
        
        if (servicios.length === 0) {
            contenedor.innerHTML = `
                <div class="empty">
                    <p>No hay servicios solicitados</p>
                </div>
            `;
            return;
        }

        let html = '';
        servicios.forEach(servicio => {
            const statusNormalizado = (servicio.status || 'pending').toLowerCase().trim();
            
            let estadoClase = '';
            let estadoTexto = '';
            
            switch(statusNormalizado) {
                case 'pending':
                    estadoClase = 'estado-pendiente';
                    estadoTexto = 'PENDIENTE';
                    break;
                case 'accepted':
                case 'approved':
                    estadoClase = 'estado-aceptado';
                    estadoTexto = 'ACEPTADO';
                    break;
                case 'rejected':
                    estadoClase = 'estado-rechazado';
                    estadoTexto = 'RECHAZADO';
                    break;
                default:
                    estadoClase = 'estado-pendiente';
                    estadoTexto = 'PENDIENTE';
            }

            const fecha = servicio.created_at ? 
                new Date(servicio.created_at).toLocaleDateString('es-ES', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                }) : 'Fecha no disponible';

            let botonesHTML = '';
            if (statusNormalizado === 'pending') {
                botonesHTML = `
                    <div class="acciones-pendiente">
                        <button class="btn-aceptar" onclick="aceptarServicio(${servicio.request_id}, '${servicio.service_name.replace(/'/g, "\\'")}')">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                            </svg>
                            Aceptar
                        </button>
                        <button class="btn-rechazar" onclick="rechazarServicio(${servicio.request_id}, '${servicio.service_name.replace(/'/g, "\\'")}')">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                            </svg>
                            Rechazar
                        </button>
                    </div>
                `;
            } else {
                botonesHTML = `<span style="color: #666; font-style: italic; font-size: 0.9rem;">Estado: ${estadoTexto}</span>`;
            }

            // Serializar servicio para pasarlo a la función
            const servicioJSON = JSON.stringify(servicio).replace(/"/g, '&quot;');

            html += `
                <div class="servicio-card-admin">
                    <div class="servicio-header">
                        <div class="servicio-info">
                            <h3>${servicio.service_name}</h3>
                            <div class="servicio-meta">
                                <span class="servicio-user">${servicio.user_name || 'Usuario desconocido'}</span>
                                <span class="servicio-email">${servicio.user_email || 'Email no disponible'}</span>
                                <span class="servicio-fecha">${fecha}</span>
                            </div>
                        </div>
                        <div class="servicio-estado">
                            <span class="estado-badge ${estadoClase}">${estadoTexto}</span>
                        </div>
                    </div>
                    
                    <div class="servicio-desc">
                        <p>${servicio.description || 'Sin descripción'}</p>
                    </div>
                    
                    <div class="servicio-acciones" style="display: flex; justify-content: space-between; align-items: center;">
                        <button class="btn-ver-detalles" onclick='mostrarDetallesAdmin(${servicioJSON})' style="width: auto; padding: 10px 20px;">
                            Ver Detalles Completos
                        </button>
                        ${botonesHTML}
                    </div>
                </div>
            `;
        });

        contenedor.innerHTML = html;
        console.log(`${servicios.length} servicios mostrados en la lista`);
    }

    // Filtrar servicios
    function filtrarServicios() {
        const filtro = document.getElementById('filtro-estado').value;
        
        let serviciosFiltrados = todosServicios;
        if (filtro) {
            serviciosFiltrados = todosServicios.filter(s => s.status === filtro);
        }
        
        mostrarServicios(serviciosFiltrados);
        actualizarEstadisticas(serviciosFiltrados);
    }

    // Aceptar servicio
    function aceptarServicio(requestId, servicioNombre) {
        accionPendiente = {
            requestId: requestId,
            accion: 'aceptar',
            servicioNombre: servicioNombre
        };
        
        // Enviar la acción al servidor directamente
        enviarAccion(requestId, 'aceptar', '');

        // No mostrar modal de confirmación
        cerrarConfirmacion();
    }

    // Rechazar servicio
    function rechazarServicio(requestId, servicioNombre) {
        accionPendiente = {
            requestId: requestId,
            accion: 'rechazar',
            servicioNombre: servicioNombre
        };
        
        // Enviar la acción al servidor directamente
        enviarAccion(requestId, 'rechazar', '');

        // No mostrar modal de confirmación
        cerrarConfirmacion();
    }

    // Cerrar modal de confirmación
    function cerrarConfirmacion() {
        document.getElementById('modal-confirmacion').classList.remove('active');
        document.body.style.overflow = 'auto';
        accionPendiente = null;
    }

    // Enviar acción al servidor
    function enviarAccion(requestId, accion, notas) {
        console.log('Enviando acción:', { 
            requestId: requestId, 
            accion: accion, 
            notas: notas 
        });
        
        const formData = new FormData();
        formData.append('request_id', requestId);
        formData.append('accion', accion);
        formData.append('notas', notas);
        
        fetch('admin_actualizar_estado.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(text => {
            console.log('Texto completo de respuesta:', text);
            
            try {
                const data = JSON.parse(text);
                console.log('JSON parseado correctamente:', data);
                
                if (data.success) {
                    alert(data.mensaje);
                    cargarServicios();
                } else {
                    alert('Error: ' + (data.mensaje || 'Error desconocido'));
                    console.error('Error del servidor:', data);
                }
            } catch (e) {
                console.error('Error parseando JSON:', e);
                alert('El servidor devolvió una respuesta inesperada.');
            }
        })
        .catch(error => {
            console.error('Error de red:', error);
            alert('Error de conexión al servidor.');
        });
    }

    // Configurar botón de confirmación
    document.getElementById('btn-confirmar-accion').addEventListener('click', function() {
        if (!accionPendiente) return;
        
        const notas = document.getElementById('confirmacion-notas').value;
        enviarAccion(accionPendiente.requestId, accionPendiente.accion, notas);
        cerrarConfirmacion();
    });

    // Cerrar modales al hacer clic fuera
    document.getElementById('modal-confirmacion').addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-overlay')) {
            cerrarConfirmacion();
        }
    });

    document.getElementById('modal-detalles-admin').addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-overlay')) {
            cerrarDetallesAdmin();
        }
    });

    // Cargar servicios al iniciar
    document.addEventListener('DOMContentLoaded', function() {
        cargarServicios();
    });
    </script>

</body>
</html>