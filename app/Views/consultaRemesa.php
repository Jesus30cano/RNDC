<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RNDC - Consultar Remesas</title>
    <link rel="stylesheet" href="/RNDC/public/css/consulta.css">
</head>
<body>
    <header>
        <img src="/RNDC/public/assets/images/colombia-potencia.webp" alt="Colombia Potencia de la Vida" class="logo-left">
        <div class="header-center">
            <h1>Consultar Remesas</h1>
        </div>
        <div class="header-actions">
            <a href="index.php?c=dashboard&a=index" class="btn-back">← Volver al Dashboard</a>
            <button class="btn-logout" onclick="logout()">Cerrar Sesión</button>
        </div>
        <img src="/RNDC/public/assets/images/transporte.webp" alt="Ministerio de Transporte" class="logo-right">
    </header>

    <div class="main-content">
        <!-- FILTROS DE BÚSQUEDA -->
        <div class="search-section">
            <h2 class="section-title">Filtros de Búsqueda</h2>
            <form id="searchForm" class="search-form">
                <div class="search-grid">
                    <div class="form-group">
                        <label>Consecutivo Remesa</label>
                        <input type="text" name="consecutivo" placeholder="Ej: REM-2024-001">
                    </div>
                    <div class="form-group">
                        <label>Fecha Desde</label>
                        <input type="date" name="fechaDesde">
                    </div>
                    <div class="form-group">
                        <label>Fecha Hasta</label>
                        <input type="date" name="fechaHasta">
                    </div>
                    <div class="form-group">
                        <label>Propietario (Nombre)</label>
                        <input type="text" name="propietarioNombre" placeholder="Nombre del propietario">
                    </div>
                    <div class="form-group">
                        <label>Propietario (Identificación)</label>
                        <input type="text" name="propietarioId" placeholder="Número de identificación">
                    </div>
                    <div class="form-group">
                        <label>NIT Empresa</label>
                        <input type="text" name="empresaNit" placeholder="NIT de la empresa">
                    </div>
                    <div class="form-group">
                        <label>Tipo de Operación</label>
                        <select name="tipoOperacion">
                            <option value="">Todas</option>
                            <option value="URBANO">Urbano</option>
                            <option value="INTERMUNICIPAL">Intermunicipal</option>
                            <option value="INTERNACIONAL">Internacional</option>
                        </select>
                    </div>
                </div>
                <div class="search-actions">
                    <button type="button" class="btn-secondary" onclick="clearFilters()">Limpiar</button>
                    <button type="submit" class="btn-primary">Buscar</button>
                </div>
            </form>
        </div>

        <!-- RESULTADOS -->
        <div class="results-section">
            <h2 class="section-title">Resultados de Búsqueda</h2>
            <div class="results-info">
                <span id="resultsCount">0 remesas encontradas</span>
                <button class="btn-export" onclick="exportResults()">📥 Exportar a Excel</button>
            </div>
            
            <div class="table-container">
                <table id="resultsTable">
                    <thead>
                        <tr>
                            <th>Consecutivo</th>
                            <th>Fecha</th>
                            <th>Propietario</th>
                            <th>Empresa</th>
                            <th>Origen</th>
                            <th>Destino</th>
                            <th>Tipo Operación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="resultsBody">
                        <!-- Los resultados aparecerán aquí -->
                    </tbody>
                </table>
                
                <div id="noResults" class="no-results" style="display: none;">
                    <p>📋 No se encontraron remesas con los criterios de búsqueda</p>
                </div>
            </div>

            <!-- PAGINACIÓN -->
            <div class="pagination" id="pagination">
                <!-- La paginación se generará dinámicamente -->
            </div>
        </div>
    </div>

    <!-- MODAL DE DETALLE -->
    <div id="detailModal" class="modal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeModal()">&times;</span>
            <h2>Detalle de la Remesa</h2>
            <div id="modalContent">
                <!-- El contenido del modal se cargará aquí -->
            </div>
            <div class="modal-actions">
                <button class="btn-print" onclick="printManifiesto()">🖨️ Imprimir</button>
                <button class="btn-secondary" onclick="closeModal()">Cerrar</button>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Ministerio de Transporte - Todos los derechos reservados</p>
    </footer>

    <script src="/RNDC/public/js/consulta.js"></script>
</body>
</html>