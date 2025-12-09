<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrowFlow Agency - Servicios</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilos específicos para tarjetas de cliente */
        .servicio-solicitado-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border-left: 5px solid var(--azul);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .servicio-solicitado-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.12);
        }

        .servicio-solicitado-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .servicio-solicitado-info h3 {
            margin: 0 0 10px 0;
            color: var(--negro);
            font-size: 1.3rem;
        }

        .servicio-fecha {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #666;
            font-size: 0.9rem;
            margin-top: 5px;
        }

        .servicio-fecha svg {
            opacity: 0.7;
        }

        .estado-servicio {
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            flex-shrink: 0;
        }

        .estado-pendiente { 
            background: #D1ECF1; 
            color: #0C5460; 
            border: 1px solid #BEE5EB; 
        }
        
        .estado-proceso { 
            background: #FFF3CD; 
            color: #856404; 
            border: 1px solid #FFEAA7; 
        }
        
        .estado-completado { 
            background: #D4EDDA; 
            color: #155724; 
            border: 1px solid #C3E6CB; 
        }
        
        .estado-rechazado { 
            background: #F8D7DA; 
            color: #721C24; 
            border: 1px solid #F5C6CB; 
        }

        .servicio-desc {
            margin-top: 15px;
            color: #555;
            line-height: 1.5;
        }

        .servicio-desc p {
            margin: 0;
        }

        .servicio-acciones {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .btn-ver-detalles {
            width: 100%;
            padding: 12px 20px;
            background: var(--azul);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-ver-detalles:hover {
            background: var(--azul-oscuro);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 119, 255, 0.3);
        }

        .mis-servicios {
            padding: 40px 5%;
            background-color: #f8f9fa;
        }

        .servicios-solicitados-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .sin-servicios {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .sin-servicios p {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 20px;
        }

        .btn-solicitar-primero {
            background: var(--azul);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-solicitar-primero:hover {
            background: var(--azul-oscuro);
        }

        .cargando-servicios {
            text-align: center;
            padding: 40px;
            color: #666;
        }

        .error-carga {
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 12px;
            color: #721C24;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .servicio-solicitado-header {
                flex-direction: column;
                gap: 10px;
            }
            
            .estado-servicio {
                align-self: flex-start;
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

    <!-- Overlay para móvil -->
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

            <!-- Servicio 1 -->
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

            <!-- Servicio 2 -->
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

            <!-- Servicio 3 -->
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

            <!-- Servicio 4 -->
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

    <!-- MODAL FORMULARIO -->
    <div class="modal-overlay" id="modal-formulario" onclick="cerrarFormulario(event)">
        <div class="modal-contenido" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h2>Contratar: <span id="servicio-nombre"></span></h2>
                <button class="modal-cerrar" onclick="cerrarFormulario()">&times;</button>
            </div>
            
            <form class="formulario-contratacion" id="form-contratacion">
                <input type="hidden" name="service_name" id="input-service-name">
                <input type="hidden" name="description" id="input-service-description">

                <div id="preguntas-dinamicas"></div>

                <div class="agendar-section">
                    <h3 class="agendar-titulo">Agendar Reunión con Consultor <span class="badge-opcional">(Opcional)</span></h3>
                    <p class="agendar-descripcion">Si deseas, puedes agendar una reunión para discutir tu proyecto en detalle</p>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="fecha-reunion">Fecha de la reunión</label>
                            <input type="date" id="fecha-reunion" name="fecha_reunion">
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
            <div class="cargando-servicios">
                <p>Cargando tus servicios...</p>
            </div>
        </div>
    </section>

    <!-- MODAL DETALLES -->
    <div class="modal-overlay modal-detalles" id="modal-detalles" onclick="cerrarModalDetalles(event)">
        <div class="modal-contenido modal-detalles-contenido" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h2>Detalles del Servicio</h2>
                <button class="modal-cerrar" onclick="cerrarModalDetalles()">&times;</button>
            </div>
            <div class="detalles-servicio" id="detalles-contenido"></div>
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

    <!-- SCRIPTS -->
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

        document.addEventListener('DOMContentLoaded', function() {
            const hoy = new Date().toISOString().split('T')[0];
            document.getElementById('fecha-reunion').setAttribute('min', hoy);
        });

        function mostrarFormulario(nombre, tipo) {
            document.getElementById('servicio-nombre').textContent = nombre;
            document.getElementById('input-service-name').value = nombre;

            // Descripciones de cada servicio
            const descripciones = {
                'Planes de Marketing': 'Estrategias personalizadas para impulsar tu marca y alcanzar tus metas comerciales.',
                'Publicidad en Redes': 'Campañas efectivas en redes sociales para conectar con tu audiencia ideal.',
                'Diseño Gráfico': 'Diseños creativos que comunican la identidad visual de tu marca.',
                'Estrategia Digital': 'Consultoría especializada para optimizar tu presencia digital completa.'
            };

            // Establecer descripción
            document.getElementById('input-service-description').value = descripciones[nombre] || 'Servicio solicitado';

            const contenedor = document.getElementById('preguntas-dinamicas');
            contenedor.innerHTML = '';

            preguntasServicios[tipo].forEach((p, i) => {
                const div = document.createElement('div');
                div.className = 'form-group';

                const label = document.createElement('label');
                label.textContent = p.label;
                label.setAttribute('for', `preg-${i}`);
                div.appendChild(label);

                if (p.type === 'select') {
                    const sel = document.createElement('select');
                    sel.id = `preg-${i}`;
                    sel.name = `preg-${i}`;
                    sel.required = true;

                    const opt = document.createElement('option');
                    opt.value = '';
                    opt.textContent = 'Selecciona una opción';
                    sel.appendChild(opt);

                    p.options.forEach(o => {
                        const op = document.createElement('option');
                        op.value = o;
                        op.textContent = o;
                        sel.appendChild(op);
                    });

                    div.appendChild(sel);
                } else {
                    const txt = document.createElement('textarea');
                    txt.id = `preg-${i}`;
                    txt.name = `preg-${i}`;
                    txt.rows = 4;
                    txt.required = true;
                    txt.placeholder = 'Escribe tu respuesta aquí...';
                    div.appendChild(txt);
                }

                contenedor.appendChild(div);
            });

            document.getElementById('modal-formulario').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function cerrarFormulario(event) {
            if (!event || event.target.classList.contains('modal-overlay') || event.target.classList.contains('modal-cerrar')) {
                document.getElementById('modal-formulario').classList.remove('active');
                document.body.style.overflow = '';
            }
        }

        document.getElementById('form-contratacion').addEventListener('submit', function(e) {
            e.preventDefault();
            const fd = new FormData(this);

            fetch('request_service.php', {
                method: 'POST',
                body: fd
            })
            .then(r => r.text())
            .then(t => {
                alert(t);
                cerrarFormulario();
                cargarServiciosSolicitados();
            })
            .catch(() => alert('Error al enviar la solicitud'));
        });
    </script>

    <script>
        // Función para cargar los servicios solicitados
        function cargarServiciosSolicitados() {
            const contenedor = document.getElementById('servicios-solicitados');
            
            fetch('obtener_servicios.php')
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        contenedor.innerHTML = `<div class="error-carga"><p>${data.mensaje || 'Error al cargar servicios'}</p></div>`;
                        return;
                    }

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
                        
                        const estado = servicio.estado?.toLowerCase();
                        if (estado === 'in_progress' || estado === 'review') {
                            estadoClase = 'estado-proceso';
                        } else if (estado === 'completed' || estado === 'approved' || estado === 'accepted') {
                            estadoClase = 'estado-completado';
                        } else if (estado === 'rejected' || estado === 'cancelled') {
                            estadoClase = 'estado-rechazado';
                        }

                        // Formatear fecha
                        const fecha = servicio.fecha_formateada || 'Fecha no disponible';

                        // Serializar servicio para el botón
                        const servicioJSON = JSON.stringify(servicio).replace(/"/g, '&quot;');

                        html += `
                            <div class="servicio-solicitado-card">
                                <div class="servicio-solicitado-header">
                                    <div class="servicio-solicitado-info">
                                        <h3>${servicio.nombre_servicio}</h3>
                                        <div class="servicio-fecha">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm1 8.5V4a1 1 0 1 0-2 0v4.5a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L9 8.086z"/>
                                            </svg>
                                            Solicitado: ${fecha}
                                        </div>
                                    </div>
                                    <div class="estado-servicio ${estadoClase}">${estadoTexto}</div>
                                </div>
                                
                                <div class="servicio-desc">
                                    <p>${servicio.descripcion || 'Sin descripción adicional'}</p>
                                </div>
                                
                                <div class="servicio-acciones">
                                    <button class="btn-ver-detalles" onclick='mostrarDetallesServicio(${servicioJSON})'>
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                            <path d="M8 4.5a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 .5-.5z"/>
                                        </svg>
                                        Ver Detalles Completos
                                    </button>
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

        // Función para mostrar detalles en modal
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
                    console.log("Error al formatear fecha:", e);
                }
            }

            // Determinar estado y color
            let estadoColor = '#856404';
            let estadoBg = '#FFF3CD';
            
            const estado = servicio.estado?.toLowerCase();
            if (estado === 'in_progress' || estado === 'review') {
                estadoColor = '#856404';
                estadoBg = '#FFF3CD';
            } else if (estado === 'completed' || estado === 'approved' || estado === 'accepted') {
                estadoColor = '#155724';
                estadoBg = '#D4EDDA';
            } else if (estado === 'rejected' || estado === 'cancelled') {
                estadoColor = '#721C24';
                estadoBg = '#F8D7DA';
            } else if (estado === 'pending') {
                estadoColor = '#0C5460';
                estadoBg = '#D1ECF1';
            }

            let html = `
                <div class="modal-seccion">
                    <h3>Información General</h3>
                    <div class="detalle-item">
                        <strong>Servicio:</strong> 
                        <span>${servicio.nombre_servicio}</span>
                    </div>
                    <div class="detalle-item">
                        <strong>ID de solicitud:</strong> 
                        <span>${servicio.id}</span>
                    </div>
                    <div class="detalle-item">
                        <strong>Fecha de solicitud:</strong> 
                        <span>${fechaFormateada}</span>
                    </div>
                    <div class="detalle-item">
                        <strong>Estado:</strong> 
                        <span class="estado-badge-modal" style="background: ${estadoBg}; color: ${estadoColor};">
                            ${servicio.estado_texto}
                        </span>
                    </div>
                </div>
            `;

            // Sección de respuestas del formulario
            if (servicio.respuestas && servicio.respuestas.length > 0) {
                html += `
                    <div class="modal-seccion">
                        <h3>Respuestas del Formulario</h3>
                        <div class="formulario-respuestas-modal">
                `;
                
                servicio.respuestas.forEach((respuesta, index) => {
                    let pregunta = respuesta.pregunta || `Pregunta ${index + 1}`;
                    let respuestaTexto = respuesta.respuesta || 'Sin respuesta';
                    
                    html += `
                        <div class="form-group-filled-modal">
                            <label class="form-label-filled-modal">${pregunta}</label>
                            <div class="form-input-filled-modal">${respuestaTexto}</div>
                        </div>
                    `;
                });
                
                html += `
                        </div>
                    </div>
                `;
            }

            // Sección de reunión
            html += '<div class="modal-seccion">';
            html += '<h3>Información de Reunión</h3>';
            
            if (servicio.tiene_reunion && servicio.reunion_completa) {
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
                            <div class="reunion-fecha-modal">${servicio.reunion_completa}</div>
                        </div>
                    </div>
                `;
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

        function cerrarModalDetalles(event) {
            if (!event || event.target.classList.contains('modal-overlay') || event.target.classList.contains('modal-cerrar')) {
                document.getElementById('modal-detalles').classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        }

        // Cargar servicios al iniciar
        document.addEventListener('DOMContentLoaded', function() {
            cargarServiciosSolicitados();
            // Recargar servicios cada 30 segundos
            setInterval(cargarServiciosSolicitados, 30000);
        });
    </script>

</body>
</html>