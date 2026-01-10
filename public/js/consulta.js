// ============================================
// consulta.js
// ============================================
let currentPage = 1;
const resultsPerPage = 10;
let allResults = [];

// Datos de ejemplo
const manifestosEjemplo = [
    { id: 1, consecutivo: 'MF-2024-001', fecha: '2024-01-15', placa: 'ABC123', conductor: 'Juan Pérez', cedulaConductor: '1234567890', origen: 'Bogotá', destino: 'Medellín', estado: 'cumplido' },
    { id: 2, consecutivo: 'MF-2024-002', fecha: '2024-01-16', placa: 'DEF456', conductor: 'María García', cedulaConductor: '9876543210', origen: 'Cali', destino: 'Barranquilla', estado: 'activo' },
    { id: 3, consecutivo: 'MF-2024-003', fecha: '2024-01-17', placa: 'GHI789', conductor: 'Carlos López', cedulaConductor: '5551234567', origen: 'Bogotá', destino: 'Cartagena', estado: 'activo' },
    { id: 4, consecutivo: 'MF-2024-004', fecha: '2024-01-18', placa: 'JKL012', conductor: 'Ana Martínez', cedulaConductor: '7778889990', origen: 'Medellín', destino: 'Pereira', estado: 'anulado' },
    { id: 5, consecutivo: 'MF-2024-005', fecha: '2024-01-19', placa: 'MNO345', conductor: 'Pedro Rodríguez', cedulaConductor: '1112223334', origen: 'Bucaramanga', destino: 'Bogotá', estado: 'cumplido' }
];

document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.getElementById('searchForm');
    
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            performSearch();
        });
    }
    
    // Cargar todos los manifiestos al inicio
    allResults = manifestosEjemplo;
    displayResults();
});

function performSearch() {
    const formData = new FormData(document.getElementById('searchForm'));
    const filters = Object.fromEntries(formData);
    
    // Filtrar resultados
    allResults = manifestosEjemplo.filter(manifiesto => {
        let matches = true;
        
        if (filters.consecutivo && !manifiesto.consecutivo.toLowerCase().includes(filters.consecutivo.toLowerCase())) {
            matches = false;
        }
        if (filters.placa && !manifiesto.placa.toLowerCase().includes(filters.placa.toLowerCase())) {
            matches = false;
        }
        if (filters.cedulaConductor && !manifiesto.cedulaConductor.includes(filters.cedulaConductor)) {
            matches = false;
        }
        if (filters.municipioOrigen && !manifiesto.origen.toLowerCase().includes(filters.municipioOrigen.toLowerCase())) {
            matches = false;
        }
        if (filters.municipioDestino && !manifiesto.destino.toLowerCase().includes(filters.municipioDestino.toLowerCase())) {
            matches = false;
        }
        if (filters.estado && manifiesto.estado !== filters.estado) {
            matches = false;
        }
        if (filters.fechaDesde && manifiesto.fecha < filters.fechaDesde) {
            matches = false;
        }
        if (filters.fechaHasta && manifiesto.fecha > filters.fechaHasta) {
            matches = false;
        }
        
        return matches;
    });
    
    currentPage = 1;
    displayResults();
}

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
            <td>${manifiesto.consecutivo}</td>
            <td>${manifiesto.fecha}</td>
            <td>${manifiesto.placa}</td>
            <td>${manifiesto.conductor}</td>
            <td>${manifiesto.origen}</td>
            <td>${manifiesto.destino}</td>
            <td><span class="status-badge status-${manifiesto.estado}">${manifiesto.estado.toUpperCase()}</span></td>
            <td><button class="btn-view" onclick="viewDetails(${manifiesto.id})">Ver Detalle</button></td>
        </tr>
    `).join('');
    
    resultsCount.textContent = `${allResults.length} manifiesto${allResults.length !== 1 ? 's' : ''} encontrado${allResults.length !== 1 ? 's' : ''}`;
    
    // Generar paginación
    generatePagination();
}

function generatePagination() {
    const totalPages = Math.ceil(allResults.length / resultsPerPage);
    const pagination = document.getElementById('pagination');
    
    if (totalPages <= 1) {
        pagination.innerHTML = '';
        return;
    }
    
    let html = `
        <button onclick="changePage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>Anterior</button>
    `;
    
    for (let i = 1; i <= totalPages; i++) {
        html += `<button class="${i === currentPage ? 'active' : ''}" onclick="changePage(${i})">${i}</button>`;
    }
    
    html += `
        <button onclick="changePage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}>Siguiente</button>
    `;
    
    pagination.innerHTML = html;
}

function changePage(page) {
    const totalPages = Math.ceil(allResults.length / resultsPerPage);
    if (page < 1 || page > totalPages) return;
    
    currentPage = page;
    displayResults();
}

function viewDetails(id) {
    const manifiesto = manifestosEjemplo.find(m => m.id === id);
    
    if (!manifiesto) return;
    
    const modalContent = document.getElementById('modalContent');
    modalContent.innerHTML = `
        <div class="detail-section">
            <h3>Información del Manifiesto</h3>
            <div class="detail-grid">
                <div class="detail-item">
                    <strong>Consecutivo:</strong>
                    <span>${manifiesto.consecutivo}</span>
                </div>
                <div class="detail-item">
                    <strong>Fecha Expedición:</strong>
                    <span>${manifiesto.fecha}</span>
                </div>
                <div class="detail-item">
                    <strong>Estado:</strong>
                    <span class="status-badge status-${manifiesto.estado}">${manifiesto.estado.toUpperCase()}</span>
                </div>
            </div>
        </div>
        
        <div class="detail-section">
            <h3>Vehículo y Ruta</h3>
            <div class="detail-grid">
                <div class="detail-item">
                    <strong>Placa:</strong>
                    <span>${manifiesto.placa}</span>
                </div>
                <div class="detail-item">
                    <strong>Origen:</strong>
                    <span>${manifiesto.origen}</span>
                </div>
                <div class="detail-item">
                    <strong>Destino:</strong>
                    <span>${manifiesto.destino}</span>
                </div>
            </div>
        </div>
        
        <div class="detail-section">
            <h3>Conductor</h3>
            <div class="detail-grid">
                <div class="detail-item">
                    <strong>Nombre:</strong>
                    <span>${manifiesto.conductor}</span>
                </div>
                <div class="detail-item">
                    <strong>Cédula:</strong>
                    <span>${manifiesto.cedulaConductor}</span>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('detailModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('detailModal').style.display = 'none';
}

function printManifiesto() {
    window.print();
}

function exportResults() {
    if (allResults.length === 0) {
        alert('No hay resultados para exportar');
        return;
    }
    
    // Convertir a CSV
    let csv = 'Consecutivo,Fecha,Placa,Conductor,Cédula,Origen,Destino,Estado\n';
    allResults.forEach(m => {
        csv += `${m.consecutivo},${m.fecha},${m.placa},${m.conductor},${m.cedulaConductor},${m.origen},${m.destino},${m.estado}\n`;
    });
    
    // Descargar archivo
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `manifiestos_${new Date().toISOString().split('T')[0]}.csv`;
    a.click();
    window.URL.revokeObjectURL(url);
}

function clearFilters() {
    document.getElementById('searchForm').reset();
    allResults = manifestosEjemplo;
    currentPage = 1;
    displayResults();
}

function logout() {
    if (confirm('¿Está seguro que desea cerrar sesión?')) {
        window.location.href = 'index.php?c=login&a=logout';
    }
}

// Cerrar modal al hacer clic fuera de él
window.onclick = function(event) {
    const modal = document.getElementById('detailModal');
    if (event.target === modal) {
        closeModal();
    }
}