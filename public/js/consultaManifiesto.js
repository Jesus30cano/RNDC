// ============================================
// consultaManifiesto.js - Consulta de Manifiestos
// ============================================
let currentPage = 1;
const resultsPerPage = 10;
let allResults = [];

document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.getElementById('searchForm');
    
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            performSearch();
        });
    }
    
    // Cargar todos los manifiestos al inicio
    loadAllManifiestos();
});

/**
 * Cargar todos los manifiestos desde el servidor
 */
function loadAllManifiestos() {
    showLoading(true);
    
    fetch('/RNDC/index.php?c=consultaManifiesto&a=buscar', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            allResults = data.manifiestos || [];
            currentPage = 1;
            displayResults();
        } else {
            showError(data.message || 'Error al cargar los manifiestos');
            allResults = [];
            displayResults();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showError('Error de conexión al servidor');
        allResults = [];
        displayResults();
    })
    .finally(() => {
        showLoading(false);
    });
}

/**
 * Realizar búsqueda con filtros
 */
function performSearch() {
    const formData = new FormData(document.getElementById('searchForm'));
    const filters = {};
    
    // Construir objeto de filtros solo con valores no vacíos
    for (let [key, value] of formData.entries()) {
        if (value && value.trim() !== '') {
            filters[key] = value.trim();
        }
    }
    
    showLoading(true);
    
    fetch('/RNDC/index.php?c=consultaManifiesto&a=buscar', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(filters)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            allResults = data.manifiestos || [];
            currentPage = 1;
            displayResults();
        } else {
            showError(data.message || 'Error en la búsqueda');
            allResults = [];
            displayResults();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showError('Error de conexión al servidor');
        allResults = [];
        displayResults();
    })
    .finally(() => {
        showLoading(false);
    });
}

/**
 * Mostrar resultados en la tabla
 */
function displayResults() {
    const resultsBody = document.getElementById('resultsBody');
    const resultsCount = document.getElementById('resultsCount');
    const noResults = document.getElementById('noResults');
    
    if (allResults.length === 0) {
        resultsBody.innerHTML = '';
        noResults.style.display = 'block';
        resultsCount.textContent = '0 manifiestos encontrados';
        document.getElementById('pagination').innerHTML = '';
        return;
    }
    
    noResults.style.display = 'none';
    
    // Paginar resultados
    const start = (currentPage - 1) * resultsPerPage;
    const end = start + resultsPerPage;
    const paginatedResults = allResults.slice(start, end);
    
    // Mostrar resultados
    resultsBody.innerHTML = paginatedResults.map(manifiesto => `
        <tr>
            <td>${escapeHtml(manifiesto.consecutivo || 'N/A')}</td>
            <td>${formatDate(manifiesto.fecha_expedicion)}</td>
            <td>${escapeHtml(manifiesto.placa_vehiculo || 'N/A')}</td>
            <td>${escapeHtml(manifiesto.conductor_nombre || 'N/A')}</td>
            <td>${escapeHtml(manifiesto.municipio_origen || 'N/A')}</td>
            <td>${escapeHtml(manifiesto.municipio_destino || 'N/A')}</td>
            <td>${escapeHtml(manifiesto.tipo_manifiesto || 'N/A')}</td>
            <td>
                <button class="btn-view" onclick="viewDetails(${manifiesto.id_manifiesto})">
                    Ver Detalle
                </button>
            </td>
        </tr>
    `).join('');
    
    resultsCount.textContent = `${allResults.length} manifiesto${allResults.length !== 1 ? 's' : ''} encontrado${allResults.length !== 1 ? 's' : ''}`;
    
    // Generar paginación
    generatePagination();
}

/**
 * Generar controles de paginación
 */
function generatePagination() {
    const totalPages = Math.ceil(allResults.length / resultsPerPage);
    const pagination = document.getElementById('pagination');
    
    if (totalPages <= 1) {
        pagination.innerHTML = '';
        return;
    }
    
    let html = `
        <button onclick="changePage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>
            Anterior
        </button>
    `;
    
    // Mostrar hasta 5 páginas
    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, startPage + 4);
    
    if (endPage - startPage < 4) {
        startPage = Math.max(1, endPage - 4);
    }
    
    if (startPage > 1) {
        html += `<button onclick="changePage(1)">1</button>`;
        if (startPage > 2) {
            html += `<span>...</span>`;
        }
    }
    
    for (let i = startPage; i <= endPage; i++) {
        html += `<button class="${i === currentPage ? 'active' : ''}" onclick="changePage(${i})">${i}</button>`;
    }
    
    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            html += `<span>...</span>`;
        }
        html += `<button onclick="changePage(${totalPages})">${totalPages}</button>`;
    }
    
    html += `
        <button onclick="changePage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}>
            Siguiente
        </button>
    `;
    
    pagination.innerHTML = html;
}

/**
 * Cambiar de página
 */
function changePage(page) {
    const totalPages = Math.ceil(allResults.length / resultsPerPage);
    if (page < 1 || page > totalPages) return;
    
    currentPage = page;
    displayResults();
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

/**
 * Ver detalles de un manifiesto
 */
function viewDetails(idManifiesto) {
    showLoading(true);
    
    fetch('/RNDC/index.php?c=consultaManifiesto&a=detalle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id_manifiesto: idManifiesto })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.manifiesto) {
            displayDetailModal(data.manifiesto);
        } else {
            showError(data.message || 'Error al cargar el detalle');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showError('Error de conexión al servidor');
    })
    .finally(() => {
        showLoading(false);
    });
}

/**
 * Mostrar modal con detalles
 */
function displayDetailModal(m) {
    const modalContent = document.getElementById('modalContent');
    
    modalContent.innerHTML = `
        <div class="detail-section">
            <h3>Información General del Manifiesto</h3>
            <div class="detail-grid">
                <div class="detail-item">
                    <strong>Consecutivo:</strong>
                    <span>${escapeHtml(m.consecutivo || 'N/A')}</span>
                </div>
                <div class="detail-item">
                    <strong>Fecha Expedición:</strong>
                    <span>${formatDate(m.fecha_expedicion)}</span>
                </div>
                <div class="detail-item">
                    <strong>Tipo Manifiesto:</strong>
                    <span>${escapeHtml(m.tipo_manifiesto || 'N/A')}</span>
                </div>
                <div class="detail-item">
                    <strong>Viajes por Día:</strong>
                    <span>${m.viajes_dia || 'N/A'}</span>
                </div>
            </div>
        </div>

        <div class="detail-section">
            <h3>Empresa</h3>
            <div class="detail-grid">
                <div class="detail-item">
                    <strong>Razón Social:</strong>
                    <span>${escapeHtml(m.empresa_razon_social || 'N/A')}</span>
                </div>
                <div class="detail-item">
                    <strong>NIT:</strong>
                    <span>${escapeHtml(m.empresa_nit || 'N/A')}</span>
                </div>
            </div>
        </div>
        
        <div class="detail-section">
            <h3>Ruta</h3>
            <div class="detail-grid">
                <div class="detail-item">
                    <strong>Municipio Origen:</strong>
                    <span>${escapeHtml(m.municipio_origen_nombre || 'N/A')}</span>
                </div>
                <div class="detail-item">
                    <strong>Municipio Destino:</strong>
                    <span>${escapeHtml(m.municipio_destino_nombre || 'N/A')}</span>
                </div>
                ${m.municipio_intermedio_nombre ? `
                <div class="detail-item">
                    <strong>Municipio Intermedio:</strong>
                    <span>${escapeHtml(m.municipio_intermedio_nombre)}</span>
                </div>
                ` : ''}
                ${m.via_utilizada ? `
                <div class="detail-item">
                    <strong>Vía Utilizada:</strong>
                    <span>${escapeHtml(m.via_utilizada)}</span>
                </div>
                ` : ''}
            </div>
        </div>

        <div class="detail-section">
            <h3>Titular del Manifiesto</h3>
            <div class="detail-grid">
                <div class="detail-item">
                    <strong>Nombre:</strong>
                    <span>${escapeHtml(m.titular_nombre || 'N/A')}</span>
                </div>
                <div class="detail-item">
                    <strong>Identificación:</strong>
                    <span>${escapeHtml(m.titular_tipo_identificacion_nombre || '')} ${escapeHtml(m.titular_numero_identificacion || 'N/A')}</span>
                </div>
                ${m.titular_telefono ? `
                <div class="detail-item">
                    <strong>Teléfono:</strong>
                    <span>${escapeHtml(m.titular_telefono)}</span>
                </div>
                ` : ''}
            </div>
        </div>
        
        ${m.vehiculos && m.vehiculos.length > 0 ? `
        <div class="detail-section">
            <h3>Vehículos</h3>
            ${m.vehiculos.map(v => `
                <div class="detail-grid" style="margin-bottom: 15px; padding: 10px; background: #f9f9f9; border-radius: 5px;">
                    <div class="detail-item">
                        <strong>Placa:</strong>
                        <span>${escapeHtml(v.placa || 'N/A')}</span>
                    </div>
                    <div class="detail-item">
                        <strong>Configuración:</strong>
                        <span>${escapeHtml(v.configuracion || 'N/A')}</span>
                    </div>
                    ${v.remolque_placa ? `
                    <div class="detail-item">
                        <strong>Remolque:</strong>
                        <span>${escapeHtml(v.remolque_placa)}</span>
                    </div>
                    ` : ''}
                    <div class="detail-item">
                        <strong>Tenedor:</strong>
                        <span>${escapeHtml(v.tenedor_nombre || 'N/A')}</span>
                    </div>
                </div>
            `).join('')}
        </div>
        ` : ''}
        
        ${m.conductores && m.conductores.length > 0 ? `
        <div class="detail-section">
            <h3>Conductores</h3>
            ${m.conductores.map(c => `
                <div class="detail-grid" style="margin-bottom: 15px; padding: 10px; background: #f9f9f9; border-radius: 5px;">
                    <div class="detail-item">
                        <strong>${c.orden === 1 ? 'Conductor Principal' : 'Segundo Conductor'}:</strong>
                        <span>${escapeHtml(c.nombre || 'N/A')}</span>
                    </div>
                    <div class="detail-item">
                        <strong>Identificación:</strong>
                        <span>${escapeHtml(c.tipo_identificacion || '')} ${escapeHtml(c.numero_identificacion || 'N/A')}</span>
                    </div>
                    <div class="detail-item">
                        <strong>Licencia:</strong>
                        <span>Cat. ${escapeHtml(c.categoria_licencia || 'N/A')} - ${escapeHtml(c.numero_licencia || 'N/A')}</span>
                    </div>
                    <div class="detail-item">
                        <strong>Vencimiento Licencia:</strong>
                        <span>${formatDate(c.vencimiento_licencia)}</span>
                    </div>
                </div>
            `).join('')}
        </div>
        ` : ''}
        
        ${m.remesas && m.remesas.length > 0 ? `
        <div class="detail-section">
            <h3>Remesas Asociadas (${m.cantidad_remesas || m.remesas.length})</h3>
            <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                <thead>
                    <tr style="background: #f0f0f0;">
                        <th style="padding: 8px; border: 1px solid #ddd;">Consecutivo</th>
                        <th style="padding: 8px; border: 1px solid #ddd;">Propietario</th>
                        <th style="padding: 8px; border: 1px solid #ddd;">Cargue</th>
                        <th style="padding: 8px; border: 1px solid #ddd;">Descargue</th>
                    </tr>
                </thead>
                <tbody>
                    ${m.remesas.map(r => `
                        <tr>
                            <td style="padding: 8px; border: 1px solid #ddd;">${escapeHtml(r.consecutivo || 'N/A')}</td>
                            <td style="padding: 8px; border: 1px solid #ddd;">${escapeHtml(r.propietario_nombre || 'N/A')}</td>
                            <td style="padding: 8px; border: 1px solid #ddd;">${escapeHtml(r.municipios_cargue || 'N/A')}</td>
                            <td style="padding: 8px; border: 1px solid #ddd;">${escapeHtml(r.municipios_descargue || 'N/A')}</td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        </div>
        ` : ''}
        
        ${m.valores ? `
        <div class="detail-section">
            <h3>Información de Valores</h3>
            <div class="detail-grid">
                <div class="detail-item">
                    <strong>Valor del Viaje:</strong>
                    <span>${formatCurrency(m.valores.valor_viaje)}</span>
                </div>
                <div class="detail-item">
                    <strong>Retención Fuente:</strong>
                    <span>${formatCurrency(m.valores.retencion_fuente)}</span>
                </div>
                <div class="detail-item">
                    <strong>Anticipo:</strong>
                    <span>${formatCurrency(m.valores.anticipo)}</span>
                </div>
                <div class="detail-item">
                    <strong>Neto a Pagar:</strong>
                    <span>${formatCurrency(m.valores.neto_pagar)}</span>
                </div>
            </div>
        </div>
        ` : ''}
        
        <div class="detail-section">
            <h3>Resumen de Carga</h3>
            <div class="detail-grid">
                <div class="detail-item">
                    <strong>Kilogramos Total:</strong>
                    <span>${formatNumber(m.kilogramos_total)} kg</span>
                </div>
                <div class="detail-item">
                    <strong>Galones Total:</strong>
                    <span>${formatNumber(m.galones_total)} gal</span>
                </div>
            </div>
        </div>
        
        ${m.recomendaciones ? `
        <div class="detail-section">
            <h3>Recomendaciones</h3>
            <p>${escapeHtml(m.recomendaciones)}</p>
        </div>
        ` : ''}
    `;
    
    document.getElementById('detailModal').style.display = 'block';
}

/**
 * Cerrar modal
 */
function closeModal() {
    document.getElementById('detailModal').style.display = 'none';
}

/**
 * Imprimir manifiesto
 */
function printManifiesto() {
    window.print();
}

/**
 * Exportar resultados a CSV
 */


/**
 * Limpiar filtros
 */
function clearFilters() {
    document.getElementById('searchForm').reset();
    loadAllManifiestos();
}

/**
 * Cerrar sesión
 */
function logout() {
    if (confirm('¿Está seguro que desea cerrar sesión?')) {
        window.location.href = '/RNDC/index.php?c=login&a=logout';
    }
}

// ============================================
// FUNCIONES AUXILIARES
// ============================================

/**
 * Mostrar/ocultar indicador de carga
 */
function showLoading(show) {
    let loader = document.getElementById('loadingOverlay');
    
    if (!loader) {
        loader = document.createElement('div');
        loader.id = 'loadingOverlay';
        loader.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        `;
        loader.innerHTML = '<div style="background: white; padding: 20px; border-radius: 8px; font-size: 18px;">Cargando...</div>';
        document.body.appendChild(loader);
    }
    
    loader.style.display = show ? 'flex' : 'none';
}

/**
 * Mostrar mensaje de error
 */
function showError(message) {
    alert('Error: ' + message);
}

/**
 * Escapar HTML para prevenir XSS
 */
function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

/**
 * Formatear fecha
 */
function formatDate(dateStr) {
    if (!dateStr) return 'N/A';
    const date = new Date(dateStr);
    if (isNaN(date.getTime())) return dateStr;
    return date.toLocaleDateString('es-CO');
}

/**
 * Formatear número
 */
function formatNumber(num) {
    if (num == null || num === '') return 'N/A';
    return parseFloat(num).toLocaleString('es-CO', { maximumFractionDigits: 2 });
}

/**
 * Formatear moneda
 */
function formatCurrency(num) {
    if (num == null || num === '') return 'N/A';
    return '$' + parseFloat(num).toLocaleString('es-CO', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

// Cerrar modal al hacer clic fuera de él
window.onclick = function(event) {
    const modal = document.getElementById('detailModal');
    if (event.target === modal) {
        closeModal();
    }
};