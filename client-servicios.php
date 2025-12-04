<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrowFlow Agency - Servicios</title>
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

    <!-- SECCIÓN SERVICIOS -->
    <section class="servicios">
        <h2 class="servicios-titulo">Servicios</h2>
        
        <div class="servicios-grid">
            <!-- Servicio 1: Planes de Marketing -->
            <div class="servicio-card" onclick="toggleServicio('servicio-1')">
                <div class="servicio-icono">
                    <div class="icono-bg">
                        <img src="imags/servicios/planes-de-marketing.png" alt="Marketing" class="icono-img">
                    </div>
                </div>
                <div class="servicio-contenido">
                    <h3>Planes de Marketing</h3>
                    <p>Estrategias personalizadas para impulsar tu marca y alcanzar tus metas comerciales.</p>
                    <button class="btn-ver-mas" onclick="event.stopPropagation(); mostrarFormulario('Planes de Marketing', 'marketing')">
                        Contratar Servicio
                    </button>
                </div>
            </div>

            <!-- Servicio 2: Publicidad en Redes -->
            <div class="servicio-card" onclick="toggleServicio('servicio-2')">
                <div class="servicio-icono">
                    <div class="icono-bg">
                        <img src="imags/servicios/publicidad-en-redes.png" alt="Redes Sociales" class="icono-img">
                    </div>
                </div>
                <div class="servicio-contenido">
                    <h3>Publicidad en Redes</h3>
                    <p>Campañas efectivas en redes sociales para conectar con tu audiencia ideal.</p>
                    <button class="btn-ver-mas" onclick="event.stopPropagation(); mostrarFormulario('Publicidad en Redes', 'redes')">
                        Contratar Servicio
                    </button>
                </div>
            </div>

            <!-- Servicio 3: Diseño Gráfico -->
            <div class="servicio-card" onclick="toggleServicio('servicio-3')">
                <div class="servicio-icono">
                    <div class="icono-bg">
                        <img src="imags/servicios/diseño-gráfico.png" alt="Diseño Gráfico" class="icono-img">
                    </div>
                </div>
                <div class="servicio-contenido">
                    <h3>Diseño Gráfico</h3>
                    <p>Diseños creativos que comunican la identidad visual de tu marca.</p>
                    <button class="btn-ver-mas" onclick="event.stopPropagation(); mostrarFormulario('Diseño Gráfico', 'diseno')">
                        Contratar Servicio
                    </button>
                </div>
            </div>

            <!-- Servicio 4: Estrategia Digital -->
            <div class="servicio-card" onclick="toggleServicio('servicio-4')">
                <div class="servicio-icono">
                    <div class="icono-bg">
                        <img src="imags/servicios/estrategia-digital.png" alt="Estrategia Digital" class="icono-img">
                    </div>
                </div>
                <div class="servicio-contenido">
                    <h3>Estrategia Digital</h3>
                    <p>Consultoría especializada para optimizar tu presencia digital completa.</p>
                    <button class="btn-ver-mas" onclick="event.stopPropagation(); mostrarFormulario('Estrategia Digital', 'estrategia')">
                        Contratar Servicio
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- MODAL FORMULARIO DE CONTRATACIÓN -->
    <div class="modal-overlay" id="modal-formulario" onclick="cerrarFormulario(event)">
        <div class="modal-contenido" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h2>Contratar: <span id="servicio-nombre"></span></h2>
                <button class="modal-cerrar" onclick="cerrarFormulario()">&times;</button>
            </div>
            
            <form class="formulario-contratacion" id="form-contratacion">
                <!-- Campo oculto para enviar el nombre del servicio -->
                <input type="hidden" name="service_name" id="input-service-name">

                <!-- Las preguntas se cargarán dinámicamente aquí -->
                <div id="preguntas-dinamicas"></div>

                <!-- Sección de Agendar Reunión -->
                <div class="agendar-section">
                    <h3 class="agendar-titulo">Agendar Reunión con Consultor <span class="badge-opcional">(Opcional)</span></h3>
                    <p class="agendar-descripcion">Si deseas, puedes agendar una reunión para discutir tu proyecto en detalle</p>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="fecha-reunion">Fecha de la reunión</label>
                            <input type="date" id="fecha-reunion" name="fecha_reunion" min="">
                        </div>

                        <div class="form-group">
                            <label for="hora-reunion">Hora de la reunión</label>
                            <select id="hora-reunion" name="hora_reunion">
                                <option value="">Selecciona una hora</option>
                                <option value="09:00">09:00 AM</option>
                                <option value="10:00">10:00 AM</option>
                                <option value="11:00">11:00 AM</option>
                                <option value="12:00">12:00 PM</option>
                                <option value="14:00">02:00 PM</option>
                                <option value="15:00">03:00 PM</option>
                                <option value="16:00">04:00 PM</option>
                                <option value="17:00">05:00 PM</option>
                            </select>
                        </div>
                    </div>

                    <div class="reunion-confirmada" id="reunion-confirmada" style="display: none;">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <circle cx="10" cy="10" r="9" fill="#00C853"/>
                            <path d="M6 10L9 13L14 7" stroke="white" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <span>Reunión agendada exitosamente</span>
                    </div>
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn-enviar" id="btn-enviar">Enviar Solicitud</button>
                </div>
            </form>
        </div>
    </div>

        <!-- SECCIÓN DE SERVICIOS SOLICITADOS -->
    <section class="mis-servicios">
        <h2 class="mis-servicios-titulo">Mis Servicios Solicitados</h2>
        
        <div class="servicios-solicitados-container" id="servicios-solicitados">
            <!-- Los servicios se cargarán dinámicamente aquí -->
            <div class="cargando-servicios">
                <p>Cargando tus servicios...</p>
            </div>
        </div>
    </section>

    <!-- Modal para ver detalles del servicio -->
    <div class="modal-overlay modal-detalles" id="modal-detalles" onclick="cerrarModalDetalles(event)">
        <div class="modal-contenido modal-detalles-contenido" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h2>Detalles del Servicio</h2>
                <button class="modal-cerrar" onclick="cerrarModalDetalles()">&times;</button>
            </div>
            
            <div class="detalles-servicio" id="detalles-contenido">
                <!-- Los detalles se cargarán aquí -->
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer>
        <p>© 2025 - GrowFlow Agency. Todos los derechos reservados.</p>
        <div class="footer-links">
            <a href="client-form-contacto.php">Formulario de contacto</a>
            <a href="client-preguntas-frecuentes.php">Preguntas frecuentes</a>
        </div>
    </footer>

    <script>
        const preguntasBase = [
            { label: "¿Cuál es tu objetivo principal?", type: "select", options: ["Aumentar ventas", "Generar leads", "Mejorar reconocimiento de marca", "Lanzar nuevo producto", "Otro"] },
            { label: "¿Cuál es tu presupuesto mensual aproximado?", type: "select", options: ["Menos de $500", "$500 - $1,500", "$1,500 - $3,000", "$3,000 - $5,000", "Más de $5,000"] },
            { label: "¿Cuánto tiempo llevas en el mercado?", type: "select", options: ["Menos de 6 meses", "6 meses - 1 año", "1 - 3 años", "3 - 5 años", "Más de 5 años"] },
            { label: "Describe tu necesidad específica para este servicio", type: "textarea" }
        ];

        const preguntasServicios = {
            marketing: preguntasBase,
            redes: preguntasBase,
            diseno: preguntasBase,
            estrategia: preguntasBase
        };

        let reunionAgendada = false;
        let servicioActual = '';

        document.addEventListener('DOMContentLoaded', function() {
            const hoy = new Date().toISOString().split('T')[0];
            document.getElementById('fecha-reunion').setAttribute('min', hoy);
        });

        function mostrarFormulario(nombreServicio, tipoServicio) {
            servicioActual = tipoServicio;
            document.getElementById('servicio-nombre').textContent = nombreServicio;
            document.getElementById('input-service-name').value = nombreServicio;

            const contenedor = document.getElementById('preguntas-dinamicas');
            contenedor.innerHTML = '';

            preguntasServicios[tipoServicio].forEach((pregunta, index) => {
                const formGroup = document.createElement('div');
                formGroup.className = 'form-group';

                const label = document.createElement('label');
                label.textContent = pregunta.label;
                label.setAttribute('for', `pregunta-${index}`);
                formGroup.appendChild(label);

                if (pregunta.type === 'select') {
                    const select = document.createElement('select');
                    select.id = `pregunta-${index}`;
                    select.name = `pregunta-${index}`;
                    select.required = true;

                    const defaultOption = document.createElement('option');
                    defaultOption.value = '';
                    defaultOption.textContent = 'Selecciona una opción';
                    select.appendChild(defaultOption);

                    pregunta.options.forEach(opt => {
                        const option = document.createElement('option');
                        option.value = opt;
                        option.textContent = opt;
                        select.appendChild(option);
                    });

                    formGroup.appendChild(select);
                } else if (pregunta.type === 'textarea') {
                    const textarea = document.createElement('textarea');
                    textarea.id = `pregunta-${index}`;
                    textarea.name = `pregunta-${index}`;
                    textarea.rows = 4;
                    textarea.required = true;
                    textarea.placeholder = 'Escribe tu respuesta aquí...';
                    formGroup.appendChild(textarea);
                }

                contenedor.appendChild(formGroup);
            });

            reunionAgendada = false;
            document.getElementById('reunion-confirmada').style.display = 'none';
            document.getElementById('btn-enviar').disabled = false;
            document.getElementById('fecha-reunion').value = '';
            document.getElementById('hora-reunion').value = '';

            document.getElementById('modal-formulario').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        document.getElementById('fecha-reunion').addEventListener('change', verificarReunion);
        document.getElementById('hora-reunion').addEventListener('change', verificarReunion);

        function verificarReunion() {
            const fecha = document.getElementById('fecha-reunion').value;
            const hora = document.getElementById('hora-reunion').value;

            if (fecha && hora) {
                reunionAgendada = true;
                document.getElementById('reunion-confirmada').style.display = 'flex';
            } else {
                reunionAgendada = false;
                document.getElementById('reunion-confirmada').style.display = 'none';
            }
        }

        function cerrarFormulario(event) {
            if (!event || event.target.classList.contains('modal-overlay') || event.target.classList.contains('modal-cerrar')) {
                document.getElementById('modal-formulario').classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        }

        document.getElementById('form-contratacion').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('request_service.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                cerrarFormulario();
                this.reset();
            })
            .catch(error => {
                console.error(error);
                alert('Error al enviar la solicitud');
            });
        });

        function toggleServicio(id) {
            // Función vacía para compatibilidad
        }

        
    </script>

<script>
// Función para cargar los servicios solicitados
function cargarServiciosSolicitados() {
    const contenedor = document.getElementById('servicios-solicitados');
    
    fetch('obtener_servicios.php')
        .then(response => response.json())
        .then(data => {
            // Verificar si hay error en la respuesta
            if (data.error) {
                contenedor.innerHTML = `<div class="error-carga"><p>${data.mensaje || 'Error al cargar servicios'}</p></div>`;
                return;
            }
            
            // Asegurar que data.data existe
            const servicios = data.data || [];
            
            if (servicios.length === 0) {
                contenedor.innerHTML = `
                    <div class="sin-servicios">
                        <p>No has solicitado ningún servicio aún.</p>
                        <p>¡Explora nuestros servicios y comienza tu proyecto!</p>
                        <button class="btn-solicitar-primero" onclick="document.querySelector('.servicios').scrollIntoView({behavior: 'smooth'})">
                            Ver Servicios Disponibles
                        </button>
                    </div>
                `;
                return;
            }
            
            let html = '';
            servicios.forEach(servicio => {
                // Determinar clase del estado
                let estadoClase = 'estado-pendiente';
                let estadoTexto = servicio.estado_texto || 'Pendiente';
                
                // Asignar clase CSS según estado
                const estado = servicio.estado?.toLowerCase();
                if (estado === 'in_progress' || estado === 'review') {
                    estadoClase = 'estado-proceso';
                } else if (estado === 'completed' || estado === 'approved') {
                    estadoClase = 'estado-completado';
                } else if (estado === 'rejected' || estado === 'cancelled') {
                    estadoClase = 'estado-rechazado';
                }
                
                // Generar HTML para respuestas
                let respuestasHTML = '';
                if (servicio.respuestas && servicio.respuestas.length > 0) {
                    respuestasHTML = '<div class="detalles-respuestas"><h4>Información proporcionada:</h4>';
                    servicio.respuestas.forEach((respuesta, index) => {
                        // Manejar diferentes formatos de respuestas
                        let pregunta = respuesta.pregunta || `Pregunta ${index + 1}`;
                        let respuestaTexto = respuesta.respuesta || respuesta || 'Sin respuesta';
                        
                        respuestasHTML += `
                            <div class="respuesta-item">
                                <div class="respuesta-pregunta">${pregunta}</div>
                                <div class="respuesta-respuesta">${respuestaTexto}</div>
                            </div>
                        `;
                    });
                    respuestasHTML += '</div>';
                }
                
                // Generar HTML para reunión - MANEJO DE VALORES VÁLIDOS/INVÁLIDOS
                let reunionHTML = '';
                if (servicio.tiene_reunion && servicio.reunion_completa) {
                    // Caso: Tiene reunión válida agendada
                    reunionHTML = `
                        <div class="reunion-info con-reunion">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="#2E7D32">
                                <circle cx="10" cy="10" r="9" stroke="#2E7D32" stroke-width="1" fill="none"/>
                                <path d="M10 5V10L13 13" stroke="#2E7D32" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            <div>
                                <strong>Reunión agendada:</strong>
                                <span class="reunion-fecha">${servicio.reunion_completa}</span>
                            </div>
                        </div>
                    `;
                } else if (servicio.tiene_reunion && servicio.fecha_reunion_formateada && servicio.hora_reunion_formateada) {
                    // Caso: Tiene reunión pero sin formato completo
                    reunionHTML = `
                        <div class="reunion-info con-reunion">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="#2E7D32">
                                <circle cx="10" cy="10" r="9" stroke="#2E7D32" stroke-width="1" fill="none"/>
                                <path d="M10 5V10L13 13" stroke="#2E7D32" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            <div>
                                <strong>Reunión agendada:</strong>
                                <span class="reunion-fecha">${servicio.fecha_reunion_formateada} a las ${servicio.hora_reunion_formateada}</span>
                            </div>
                        </div>
                    `;
                } else {
                    // Caso: NO tiene reunión agendada (valores null, vacíos o 0000-00-00/00:00:00)
                    reunionHTML = `
                        <div class="reunion-info sin-reunion">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="#666">
                                <circle cx="10" cy="10" r="9" stroke="#666" stroke-width="1" fill="none"/>
                                <path d="M6 6L14 14M14 6L6 14" stroke="#666" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            <div>
                                <strong>Reunión:</strong>
                                <span class="reunion-estado">No se agendó reunión para este servicio</span>
                            </div>
                        </div>
                    `;
                }
                
                html += `
                    <div class="servicio-solicitado-card" onclick="mostrarDetallesServicio(${JSON.stringify(servicio).replace(/"/g, '&quot;')})">
                        <div class="servicio-solicitado-header">
                            <div class="servicio-solicitado-info">
                                <h3>${servicio.nombre_servicio}</h3>
                                <div class="servicio-fecha">Solicitado: ${servicio.fecha_formateada}</div>
                            </div>
                            <div class="estado-servicio ${estadoClase}">${estadoTexto}</div>
                        </div>
                        <div class="servicio-detalles">
                            <p>${servicio.descripcion}</p>
                            ${respuestasHTML}
                            ${reunionHTML}
                        </div>
                    </div>
                `;
            });
            
            contenedor.innerHTML = html;
        })
        .catch(error => {
            console.error('Error:', error);
            contenedor.innerHTML = '<div class="error-carga"><p>Error al cargar los servicios. Intenta más tarde.</p></div>';
        });
}

// Función para mostrar detalles en modal (actualizada para manejar valores null/ceros)
function mostrarDetallesServicio(servicio) {
    const modal = document.getElementById('modal-detalles');
    const contenido = document.getElementById('detalles-contenido');
    
    // Formatear fecha de solicitud
    let fechaFormateada = servicio.fecha_formateada;
    if (servicio.fecha_solicitud && servicio.fecha_solicitud !== '0000-00-00 00:00:00') {
        try {
            const fecha = new Date(servicio.fecha_solicitud);
            fechaFormateada = fecha.toLocaleDateString('es-ES', {
                weekday: 'long',
                day: '2-digit',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        } catch (e) {
            // Usar la fecha formateada del backend si hay error
            console.log("Error al formatear fecha:", e);
        }
    }
    
    // Determinar estado y color
    let estadoColor = '#856404';
    let estadoBg = '#FFF3CD';
    
    const estado = servicio.estado?.toLowerCase();
    if (estado === 'in_progress' || estado === 'review') {
        estadoColor = '#0C5460';
        estadoBg = '#D1ECF1';
    } else if (estado === 'completed' || estado === 'approved') {
        estadoColor = '#155724';
        estadoBg = '#D4EDDA';
    } else if (estado === 'rejected' || estado === 'cancelled') {
        estadoColor = '#721C24';
        estadoBg = '#F8D7DA';
    }
    
    let html = `
        <div class="detalle-item">
            <strong>Servicio:</strong> ${servicio.nombre_servicio}
        </div>
        <div class="detalle-item">
            <strong>ID de solicitud:</strong> ${servicio.id}
        </div>
        <div class="detalle-item">
            <strong>Fecha de solicitud:</strong> ${fechaFormateada}
        </div>
        <div class="detalle-item">
            <strong>Estado:</strong> 
            <span style="background: ${estadoBg}; color: ${estadoColor}; padding: 4px 12px; border-radius: 20px; font-weight: 600; font-size: 0.9rem;">
                ${servicio.estado_texto}
            </span>
        </div>
    `;
    
    if (servicio.descripcion && servicio.descripcion !== 'Sin descripción disponible') {
        html += `
            <div class="detalle-item">
                <strong>Descripción:</strong> ${servicio.descripcion}
            </div>
        `;
    }
    
    if (servicio.respuestas && servicio.respuestas.length > 0) {
        html += '<div class="detalle-item"><strong>Información proporcionada:</strong></div>';
        servicio.respuestas.forEach((respuesta, index) => {
            let pregunta = respuesta.pregunta || `Pregunta ${index + 1}`;
            let respuestaTexto = respuesta.respuesta || respuesta || 'Sin respuesta';
            
            html += `
                <div class="detalle-respuesta">
                    <div class="detalle-pregunta">${pregunta}</div>
                    <div class="detalle-respuesta-texto">${respuestaTexto}</div>
                </div>
            `;
        });
    }
    
    // MOSTRAR INFORMACIÓN DE REUNIÓN - MANEJO DE VALORES VACÍOS/CEROS/NULL
    if (servicio.tiene_reunion && servicio.reunion_completa) {
        // Tiene reunión válida agendada
        html += `
            <div class="detalle-item">
                <strong>Reunión agendada:</strong> 
                <span style="color: #2E7D32; font-weight: 500;">
                    ${servicio.reunion_completa}
                </span>
            </div>
        `;
    } else if (servicio.tiene_reunion && servicio.fecha_reunion_formateada && servicio.hora_reunion_formateada) {
        // Tiene reunión pero sin formato completo
        html += `
            <div class="detalle-item">
                <strong>Reunión agendada:</strong> 
                <span style="color: #2E7D32; font-weight: 500;">
                    ${servicio.fecha_reunion_formateada} a las ${servicio.hora_reunion_formateada}
                </span>
            </div>
        `;
    } else {
        // NO tiene reunión válida agendada
        let motivo = '';
        
        // Verificar valores específicos para dar mensaje más específico
        if (servicio.fecha_reunion_raw) {
            if (servicio.fecha_reunion_raw === '0000-00-00' || 
                servicio.fecha_reunion_raw === '0000-00-00 00:00:00' ||
                servicio.fecha_reunion_raw.includes('0000-00-00')) {
                motivo = ' (fecha no seleccionada)';
            } else if (servicio.fecha_reunion_raw === '00:00:00') {
                motivo = ' (formato incorrecto)';
            }
        } else if (servicio.hora_reunion_raw) {
            if (servicio.hora_reunion_raw === '00:00:00' || 
                servicio.hora_reunion_raw === '00:00') {
                motivo = ' (hora no seleccionada)';
            }
        } else if (!servicio.fecha_reunion_raw && !servicio.hora_reunion_raw) {
            motivo = ' (no se solicitó reunión)';
        }
        
        html += `
            <div class="detalle-item">
                <strong>Reunión:</strong> 
                <span style="color: #666; font-style: italic;">
                    No se agendó reunión${motivo}
                </span>
            </div>
        `;
    }
        
    contenido.innerHTML = html;
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

// Función para cerrar modal de detalles
function cerrarModalDetalles(event) {
    if (!event || event.target.classList.contains('modal-overlay') || event.target.classList.contains('modal-cerrar')) {
        document.getElementById('modal-detalles').classList.remove('active');
        document.body.style.overflow = 'auto';
    }
}

// Cargar servicios cuando la página se carga
document.addEventListener('DOMContentLoaded', function() {
    cargarServiciosSolicitados();
    
    // Recargar servicios cada 30 segundos para actualizar estados
    setInterval(cargarServiciosSolicitados, 30000);
});
</script>
</body>
</html>
