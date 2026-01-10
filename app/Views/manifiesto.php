<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RNDC - Manifiesto de Carga</title>
    <link rel="stylesheet" href="/RNDC/public/css/forms.css">
</head>
<body>
    <header>
        <img src="/RNDC/public/assets/images/colombia-potencia.webp" alt="Colombia Potencia de la Vida" class="logo-left">
        <div class="header-center">
            <h1>Manifiesto de Carga</h1>
        </div>
        <div class="header-actions">
            <a href="index.php?c=dashboard&a=index" class="btn-back">← Volver al Dashboard</a>
            <button class="btn-logout" onclick="logout()">Cerrar Sesión</button>
        </div>
        <img src="/RNDC/public/assets/images/transporte.webp" alt="Ministerio de Transporte" class="logo-right">
    </header>

    <div class="main-content">
        <form id="manifiestoForm" class="form-container">
            <!-- TITULAR DEL MANIFIESTO -->
            <div class="form-section">
                <h2 class="section-title">Titular del Manifiesto</h2>
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label>Nombre Empresa</label>
                        <input type="text" value="TRANSPORTES QUIROGA S.A.S" readonly>
                    </div>
                    <div class="form-group">
                        <label>NIT Empresa</label>
                        <input type="text" value="8020099265" readonly>
                    </div>
                    <div class="form-group">
                        <label>Usuario</label>
                        <input type="text" value="TRANSQUIROGA@0144" readonly>
                    </div>
                </div>
            </div>

            <!-- INFORMACIÓN DEL VIAJE -->
            <div class="form-section">
                <h2 class="section-title">Información del Viaje</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Consecutivo Manifiesto *</label>
                        <input type="text" name="consecutivo" required>
                    </div>
                    <div class="form-group">
                        <label>Tipo Manifiesto *</label>
                        <select name="tipoManifiesto" required>
                            <option value="">Seleccione...</option>
                            <option value="normal">Normal</option>
                            <option value="consolidado">Consolidado</option>
                            <option value="transbordo">Transbordo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Fecha Expedición *</label>
                        <input type="date" name="fechaExpedicion" required>
                    </div>
                    <div class="form-group">
                        <label>Viajes día</label>
                        <input type="number" name="viajesDia" value="1" min="1">
                    </div>
                    <div class="form-group">
                        <label>Municipio Origen *</label>
                        <input type="text" name="municipioOrigen" required>
                    </div>
                    <div class="form-group">
                        <label>Municipio Destino *</label>
                        <input type="text" name="municipioDestino" required>
                    </div>
                    <div class="form-group full-width">
                        <label>Vía a Utilizar *</label>
                        <input type="text" name="viaUtilizar" required placeholder="Ej: Ruta Nacional 50">
                    </div>
                </div>
            </div>

            <!-- VEHÍCULO -->
            <div class="form-section">
                <h2 class="section-title">Información del Vehículo</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Placa Vehículo *</label>
                        <input type="text" name="placaVehiculo" required placeholder="Ej: ABC123">
                    </div>
                    <div class="form-group">
                        <label>Configuración Vehículo *</label>
                        <select name="configuracionVehiculo" required>
                            <option value="">Seleccione...</option>
                            <option value="C2">C2 - Camión de 2 ejes</option>
                            <option value="C3">C3 - Camión de 3 ejes</option>
                            <option value="C4">C4 - Camión de 4 ejes</option>
                            <option value="2S1">2S1 - Tractocamión 2 ejes + Semiremolque 1 eje</option>
                            <option value="2S2">2S2 - Tractocamión 2 ejes + Semiremolque 2 ejes</option>
                            <option value="3S2">3S2 - Tractocamión 3 ejes + Semiremolque 2 ejes</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Peso Vacío (Kg) *</label>
                        <input type="number" name="pesoVacio" required>
                    </div>
                    <div class="form-group">
                        <label>Tenedor del Vehículo *</label>
                        <input type="text" name="tenedorVehiculo" required>
                    </div>
                    <div class="form-group">
                        <label>Identificación Tenedor *</label>
                        <input type="text" name="identTenedor" required>
                    </div>
                    <div class="form-group">
                        <label>Póliza SOAT *</label>
                        <input type="text" name="polizaSOAT" required>
                    </div>
                    <div class="form-group">
                        <label>Vencimiento SOAT *</label>
                        <input type="date" name="vencimientoSOAT" required>
                    </div>
                    <div class="form-group">
                        <label>Aseguradora SOAT *</label>
                        <input type="text" name="aseguradoraSOAT" required>
                    </div>
                </div>

                <!-- REMOLQUE (Opcional) -->
                <h3 class="subsection-title">Remolque (Opcional)</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Placa Remolque</label>
                        <input type="text" name="placaRemolque" placeholder="Ej: REM123">
                    </div>
                    <div class="form-group">
                        <label>Configuración Remolque</label>
                        <select name="configuracionRemolque">
                            <option value="">Seleccione...</option>
                            <option value="R1">R1 - 1 eje</option>
                            <option value="R2">R2 - 2 ejes</option>
                            <option value="R3">R3 - 3 ejes</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Peso Vacío Remolque (Kg)</label>
                        <input type="number" name="pesoVacioRemolque">
                    </div>
                </div>
            </div>

            <!-- CONDUCTOR 1 -->
            <div class="form-section">
                <h2 class="section-title">Conductor Número 1</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Tipo Identificación *</label>
                        <select name="conductor1TipoId" required>
                            <option value="CC">Cédula Ciudadanía</option>
                            <option value="CE">Cédula Extranjería</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Número Identificación *</label>
                        <input type="text" name="conductor1NumId" required>
                    </div>
                    <div class="form-group full-width">
                        <label>Nombre Completo *</label>
                        <input type="text" name="conductor1Nombre" required>
                    </div>
                    <div class="form-group">
                        <label>Municipio *</label>
                        <input type="text" name="conductor1Municipio" required>
                    </div>
                    <div class="form-group">
                        <label>Teléfono *</label>
                        <input type="tel" name="conductor1Telefono" required>
                    </div>
                    <div class="form-group">
                        <label>Categoría Licencia *</label>
                        <select name="conductor1Categoria" required>
                            <option value="">Seleccione...</option>
                            <option value="C1">C1</option>
                            <option value="C2">C2</option>
                            <option value="C3">C3</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Vencimiento Licencia *</label>
                        <input type="date" name="conductor1VencLic" required>
                    </div>
                </div>
            </div>

            <!-- CONDUCTOR 2 (Opcional) -->
            <div class="form-section">
                <h2 class="section-title">Conductor Número 2 (Opcional)</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Tipo Identificación</label>
                        <select name="conductor2TipoId">
                            <option value="">Seleccione...</option>
                            <option value="CC">Cédula Ciudadanía</option>
                            <option value="CE">Cédula Extranjería</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Número Identificación</label>
                        <input type="text" name="conductor2NumId">
                    </div>
                    <div class="form-group full-width">
                        <label>Nombre Completo</label>
                        <input type="text" name="conductor2Nombre">
                    </div>
                    <div class="form-group">
                        <label>Categoría Licencia</label>
                        <select name="conductor2Categoria">
                            <option value="">Seleccione...</option>
                            <option value="C1">C1</option>
                            <option value="C2">C2</option>
                            <option value="C3">C3</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Vencimiento Licencia</label>
                        <input type="date" name="conductor2VencLic">
                    </div>
                </div>
            </div>

            <!-- VALOR DEL VIAJE -->
            <div class="form-section">
                <h2 class="section-title">Valor del Viaje</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Valor a Pagar por el Viaje *</label>
                        <input type="number" name="valorViaje" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label>Retención en la Fuente *</label>
                        <input type="number" name="retencionFuente" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label>Retención ICA (%*mil)</label>
                        <input type="number" name="retencionICA" step="0.01">
                    </div>
                    <div class="form-group">
                        <label>Neto a Pagar *</label>
                        <input type="number" name="netoPagar" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label>Valor Anticipo</label>
                        <input type="number" name="valorAnticipo" step="0.01">
                    </div>
                    <div class="form-group">
                        <label>Saldo por Pagar</label>
                        <input type="number" name="saldoPagar" step="0.01" readonly>
                    </div>
                    <div class="form-group">
                        <label>Lugar del Pago *</label>
                        <input type="text" name="lugarPago" required>
                    </div>
                    <div class="form-group">
                        <label>Fecha Pago *</label>
                        <input type="date" name="fechaPago" required>
                    </div>
                    <div class="form-group full-width">
                        <label>Responsable del Pago</label>
                        <input type="text" name="responsablePago">
                    </div>
                </div>
            </div>

            <!-- REMESAS ASOCIADAS -->
            <div class="form-section">
                <h2 class="section-title">Remesas Asociadas</h2>
                <div class="remesas-container">
                    <div class="form-group">
                        <label>Consecutivo Remesa</label>
                        <input type="text" id="remesaInput" placeholder="Ingrese consecutivo de remesa">
                        <button type="button" class="btn-add" onclick="addRemesa()">Agregar Remesa</button>
                    </div>
                    <div id="remesasList" class="remesas-list">
                        <!-- Las remesas agregadas aparecerán aquí -->
                    </div>
                </div>
            </div>

            <!-- RECOMENDACIONES -->
            <div class="form-section">
                <h2 class="section-title">Recomendaciones y Observaciones</h2>
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label>Recomendaciones</label>
                        <textarea name="recomendaciones" rows="4" placeholder="Ingrese recomendaciones para el viaje..."></textarea>
                    </div>
                </div>
            </div>

            <!-- BOTONES -->
            <div class="form-actions">
                <button type="button" class="btn-secondary" onclick="resetForm()">Limpiar Formulario</button>
                <button type="submit" class="btn-primary">Guardar Manifiesto</button>
            </div>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Ministerio de Transporte - Todos los derechos reservados</p>
    </footer>

    <script src="/RNDC/public/js/manifiesto.js"></script>
</body>
</html>