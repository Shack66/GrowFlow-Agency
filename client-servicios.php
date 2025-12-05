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
                } else if (estado === 'completed' || estado === 'approved' || estado === 'accepted') {
                    estadoClase = 'estado-completado';
                } else if (estado === 'rejected' || estado === 'cancelled') {
                    estadoClase = 'estado-rechazado';
                }
                
                // Generar HTML para las respuestas del formulario como campos llenos
                let respuestasHTML = '';
                if (servicio.respuestas && servicio.respuestas.length > 0) {
                    respuestasHTML = '<div class="formulario-respuestas"><h4>Información del Formulario:</h4>';
                    
                    servicio.respuestas.forEach((respuesta, index) => {
                        let pregunta = respuesta.pregunta || `Pregunta ${index + 1}`;
                        let respuestaTexto = respuesta.respuesta || 'Sin respuesta';
                        
                        respuestasHTML += `
                            <div class="form-group-filled">
                                <label class="form-label-filled">${pregunta}</label>
                                <div class="form-input-filled">${respuestaTexto}</div>
                            </div>
                        `;
                    });
                    
                    respuestasHTML += '</div>';
                }
                
                // Generar HTML para reunión
                let reunionHTML = '';
                if (servicio.tiene_reunion && servicio.reunion_completa) {
                    reunionHTML = `
                        <div class="reunion-info-card con-reunion">
                            <div class="reunion-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <circle cx="12" cy="12" r="10" stroke="#2E7D32" stroke-width="2" fill="none"/>
                                    <path d="M12 6V12L16 16" stroke="#2E7D32" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div class="reunion-content">
                                <div class="reunion-titulo">Reunión Agendada</div>
                                <div class="reunion-fecha">${servicio.reunion_completa}</div>
                            </div>
                        </div>
                    `;
                } else {
                    reunionHTML = `
                        <div class="reunion-info-card sin-reunion">
                            <div class="reunion-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <circle cx="12" cy="12" r="10" stroke="#999" stroke-width="2" fill="none"/>
                                    <path d="M8 8L16 16M16 8L8 16" stroke="#999" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div class="reunion-content">
                                <div class="reunion-titulo">Sin Reunión</div>
                                <div class="reunion-fecha">No se agendó reunión para este servicio</div>
                            </div>
                        </div>
                    `;
                }
                
                html += `
                    <div class="servicio-solicitado-card">
                        <div class="servicio-solicitado-header">
                            <div class="servicio-solicitado-info">
                                <h3>${servicio.nombre_servicio}</h3>
                                <div class="servicio-fecha">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                        <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm1 8.5V4a1 1 0 1 0-2 0v4.5a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L9 8.086z"/>
                                    </svg>
                                    Solicitado: ${servicio.fecha_formateada}
                                </div>
                            </div>
                            <div class="estado-servicio ${estadoClase}">${estadoTexto}</div>
                        </div>
                        
                        <div class="servicio-detalles">
                            ${respuestasHTML}
                            ${reunionHTML}
                        </div>
                        
                        <div class="servicio-acciones">
                            <button class="btn-ver-detalles" onclick="mostrarDetallesServicio(${JSON.stringify(servicio).replace(/"/g, '&quot;')})">
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
        estadoColor = '#0C5460';
        estadoBg = '#D1ECF1';
    } else if (estado === 'completed' || estado === 'approved' || estado === 'accepted') {
        estadoColor = '#155724';
        estadoBg = '#D4EDDA';
    } else if (estado === 'rejected' || estado === 'cancelled') {
        estadoColor = '#721C24';
        estadoBg = '#F8D7DA';
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
                        <circle cx="12" cy="12" r="10" stroke="#2E7D32" stroke-width="2" fill="none"/>
                        <path d="M12 6V12L16 16" stroke="#2E7D32" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <div>
                    <div class="reunion-titulo-modal">Reunión Confirmada</div>
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