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
        <form id="manifiestoForm" class="form-container"  >
            <!-- Campos ocultos para IDs de sesión -->
            <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $_SESSION['user_name'] ?? ''; ?>">

            <!-- TITULAR DEL MANIFIESTO -->
            <div class="form-section">
                <h2 class="section-title">Titular del Manifiesto</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nombre Empresa</label>
                        <select id="nombreEmpresa" name="nombreEmpresa" required>
                            <option value="">Seleccione...</option>
                            <option value="TRANSPORTES QUIROGA S.A.S">TRANSPORTES QUIROGA S.A.S</option>
                            <option value="ALIMENTOS DEL VALLE S.A.">ALIMENTOS DEL VALLE S.A.</option>
                            <option value="INDUSTRIAS QUÍMICAS LTDA">INDUSTRIAS QUÍMICAS LTDA</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>NIT Empresa</label>
                        <input type="text" id="nitEmpresa" name="nitEmpresa" readonly>
                    </div>
                    <div class="form-group">
                        <label>Usuario</label>
                        <input type="text" id="usuario" name="usuario" value="<?php echo $_SESSION['user_name'] ?? 'Usuario'; ?>" readonly>
                    </div>
                </div>
            </div>

            <!-- INFORMACIÓN PRELIMINAR -->
            <div class="form-section">
                <h2 class="section-title">Información Preliminar</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Información de Viaje</label>
                        <input type="text" id="informacionViaje" name="informacionViaje">
                    </div>
                    <div class="form-group">
                        <label>Radicado Viaje Consolidado</label>
                        <input type="text" id="radicadoViajeConsolidado" name="radicadoViajeConsolidado">
                    </div>
                    <div class="form-group">
                        <label>Manifiesto anterior para Transbordo o Reemplazo</label>
                        <input type="text" id="manifiestoAnterior" name="manifiestoAnterior">
                    </div>
                    <div class="form-group">
                        <label>Consecutivo * (Se genera automáticamente)</label>
                        <input type="text" id="consecutivo" name="consecutivo" readonly placeholder="Se generará automáticamente">
                    </div>
                </div>
            </div>

            <!-- CARACTERÍSTICAS GENERALES DEL MANIFIESTO -->
            <div class="form-section">
                <h2 class="section-title">Características Generales del Manifiesto</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Tipo Manifiesto *</label>
                        <select id="tipoManifiesto" name="tipoManifiesto" required>
                            <option value="">Seleccione...</option>
                            <option value="normal">Normal</option>
                            <option value="consolidado">Consolidado</option>
                            <option value="transbordo">Transbordo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Fecha Expedición *</label>
                        <input type="date" id="fechaExpedicion" name="fechaExpedicion" required>
                    </div>
                    <div class="form-group">
                        <label>Viajes día</label>
                        <input type="number" id="viajesDia" name="viajesDia" value="1" min="1">
                    </div>
                    <div class="form-group">
                        <label>Municipio Origen *</label>
                        
                        <select id="municipioOrigen" name="municipioOrigen" required>
                            <option value="">Seleccione...</option>
                            <option value="Bogotá D.C.">Bogotá D.C.</option>
                            <option value="Medellín">Medellín</option>
                            <option value="Cali">Cali</option>
                            <option value="Barranquilla">Barranquilla</option>
                            <option value="Cartagena">Cartagena</option>
                            <option value="Bucaramanga">Bucaramanga</option>
                            <option value="Pereira">Pereira</option>
                            <option value="Santa Marta">Santa Marta</option>
                            <option value="Manizales">Manizales</option>
                            <option value="Ibagué">Ibagué</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Código Municipio Origen</label>
                        <input type="text" id="codigoMunicipioOrigen" name="codigoMunicipioOrigen">
                    </div>
                    <div class="form-group">
                        <label>Municipio Destino *</label>
                        <select id="municipioDestino" name="municipioDestino" required>
                            <option value="">Seleccione...</option>
                            <option value="Bogotá D.C.">Bogotá D.C.</option>
                            <option value="Medellín">Medellín</option>
                            <option value="Cali">Cali</option>
                            <option value="Barranquilla">Barranquilla</option>
                            <option value="Cartagena">Cartagena</option>
                            <option value="Bucaramanga">Bucaramanga</option>
                            <option value="Pereira">Pereira</option>
                            <option value="Santa Marta">Santa Marta</option>
                            <option value="Manizales">Manizales</option>
                            <option value="Ibagué">Ibagué</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Código Municipio Destino</label>
                        <input type="text" id="codigoMunicipioDestino" name="codigoMunicipioDestino">
                    </div>
                    <div class="form-group">
                        <label>Municipio Intermedio</label>
                        <input type="text" id="municipioIntermedio" name="municipioIntermedio">
                    </div>
                    <div class="form-group">
                        <label>Código Municipio Intermedio</label>
                        <input type="text" id="codigoMunicipioIntermedio" name="codigoMunicipioIntermedio">
                    </div>
                    <div class="form-group full-width">
                        <label>Vía a Utilizar *</label>
                        <select id="viaUtilizar" name="viaUtilizar" required>
                            <option value="">Seleccione...</option>
                            <option value="ruta_nacional">Ruta Nacional</option>
                            <option value="ruta_departamental">Ruta Departamental</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- TITULAR MANIFIESTO -->
            <div class="form-section">
                <h2 class="section-title">Titular Manifiesto</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Tipo Identificación *</label>
                        <select id="tipoIdentificacion" name="tipoIdentificacion" required>
                            <option value="">Seleccione...</option>
                            <option value="1">Cédula</option>
                            <option value="2">NIT</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Número Identificación *</label>
                        <input type="text" id="numeroIdentificacion" name="numeroIdentificacion" required >
                    </div>
                    <div class="form-group">
                        <label>Sede *</label>
                        <input type="text" id="sede" name="sede" required>
                    </div>
                    <div class="form-group">
                        <label>Nombre *</label>
                        <input type="text" id="nombreTitular" name="nombreTitular" required>
                    </div>
                    <div class="form-group">
                        <label>Dirección *</label>
                        <input type="text" id="direccionTitular" name="direccionTitular" required>
                    </div>
                    <div class="form-group">
                        <label>Municipio *</label>
                        <input type="text" id="municipioTitular" name="municipioTitular" required>
                    </div>
                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="text" id="telefonoTitular" name="telefonoTitular">
                    </div>
                </div>
            </div>

            <!-- VEHÍCULO -->
            <div class="form-section">
                <h2 class="section-title">Vehículo</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Placa Vehículo *</label>
                        <input type="text" id="placaVehiculo" name="placaVehiculo" required>
                    </div>
                    <div class="form-group">
                        <label>Configuración *</label>
                        <input type="text" id="configuracionVehiculo" name="configuracionVehiculo" required>
                    </div>
                    <div class="form-group">
                        <label>Peso Vacío</label>
                        <input type="number" id="pesoVacioVehiculo" name="pesoVacioVehiculo" step="0.01">
                    </div>
                    <div class="form-group full-width">
                        <label>Tenedor del Vehículo *</label>
                        <input type="text" id="tenedorVehiculo" name="tenedorVehiculo" required>
                    </div>
                    <div class="form-group">
                        <label>Identificación *</label>
                        <input type="text" id="identificacionTenedor" name="identificacionTenedor" required>
                    </div>
                    <div class="form-group">
                        <label>Póliza SOAT *</label>
                        <input type="text" id="polizaSoat" name="polizaSoat" required>
                    </div>
                    <div class="form-group">
                        <label>Vencimiento *</label>
                        <input type="date" id="vencimientoSoat" name="vencimientoSoat" required>
                    </div>
                    <div class="form-group full-width">
                        <label>Aseguradora *</label>
                        <input type="text" id="aseguradoraSoat" name="aseguradoraSoat" required>
                    </div>
                    <div class="form-group">
                        <label>Placa Remolque 1</label>
                        <input type="text" id="placaRemolque1" name="placaRemolque1">
                    </div>
                    <div class="form-group">
                        <label>Configuración</label>
                        <input type="text" id="configuracionRemolque1" name="configuracionRemolque1">
                    </div>
                    <div class="form-group">
                        <label>Peso Vacío</label>
                        <input type="number" id="pesoVacioRemolque1" name="pesoVacioRemolque1" step="0.01">
                    </div>
                    <div class="form-group">
                        <label>Configuración Resultante</label>
                        <input type="text" id="configuracionResultante" name="configuracionResultante">
                    </div>
                    <div class="form-group">
                        <label>Código Configuración</label>
                        <input type="text" id="codigoConfiguracionResultante" name="codigoConfiguracionResultante">
                    </div>
                </div>
            </div>

            <!-- CONDUCTOR 1 -->
            <div class="form-section">
                <h2 class="section-title">Conductor Número 1</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Tipo Identificación *</label>
                        <select id="conductor1TipoId" name="conductor1TipoId" required>
                            <option value="CC">Cédula Ciudadanía</option>
                            <option value="CE">Cédula Extranjería</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Número Identificación *</label>
                        <input type="text" id="conductor1NumId" name="conductor1NumId" required>
                    </div>
                    <div class="form-group full-width">
                        <label>Nombre Completo *</label>
                        <input type="text" id="conductor1Nombre" name="conductor1Nombre" required>
                    </div>
                    <div class="form-group">
                        <label>Municipio *</label>
                        
                        <select id="conductor1Municipio"" name="conductor1Municipio" required>
                            <option value="">Seleccione...</option>
                            <option value="Bogotá D.C.">Bogotá D.C.</option>
                            <option value="Medellín">Medellín</option>
                            <option value="Cali">Cali</option>
                            <option value="Barranquilla">Barranquilla</option>
                            <option value="Cartagena">Cartagena</option>
                            <option value="Bucaramanga">Bucaramanga</option>
                            <option value="Pereira">Pereira</option>
                            <option value="Santa Marta">Santa Marta</option>
                            <option value="Manizales">Manizales</option>
                            <option value="Ibagué">Ibagué</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Teléfono *</label>
                        <input type="tel" id="conductor1Telefono" name="conductor1Telefono" required>
                    </div>
                    <div class="form-group">
                        <label>Categoría Licencia *</label>
                        <select id="conductor1Categoria" name="conductor1Categoria" required>
                            <option value="">Seleccione...</option>
                            <option value="C1">C1</option>
                            <option value="C2">C2</option>
                            <option value="C3">C3</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Vencimiento Licencia *</label>
                        <input type="date" id="conductor1VencLic" name="conductor1VencLic" required>
                    </div>
                    <div class="form-group">
                        <label>Número Licencia *</label>
                        <input type="text" id="conductor1Licencia" name="conductor1Licencia" required>
                    </div>
                </div>
            </div>

            <!-- CONDUCTOR 2 (Opcional) -->
            <div class="form-section">
                <h2 class="section-title">Conductor Número 2 (Opcional)</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Tipo Identificación</label>
                        <select id="conductor2TipoId" name="conductor2TipoId">
                            <option value="">Seleccione...</option>
                            <option value="CC">Cédula Ciudadanía</option>
                            <option value="CE">Cédula Extranjería</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Número Identificación</label>
                        <input type="text" id="conductor2NumId" name="conductor2NumId">
                    </div>
                    <div class="form-group full-width">
                        <label>Nombre Completo</label>
                        <input type="text" id="conductor2Nombre" name="conductor2Nombre">
                    </div>
                    <div class="form-group">
                        <label>Categoría Licencia</label>
                        <select id="conductor2Categoria" name="conductor2Categoria">
                            <option value="">Seleccione...</option>
                            <option value="C1">C1</option>
                            <option value="C2">C2</option>
                            <option value="C3">C3</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Vencimiento Licencia</label>
                        <input type="date" id="conductor2VencLic" name="conductor2VencLic">
                    </div>
                    <div class="form-group">
                        <label>Número Licencia</label>
                        <input type="text" id="conductor2Licencia" name="conductor2Licencia">
                    </div>
                </div>
            </div>

            <!-- VALOR DEL VIAJE -->
            <div class="form-section">
                <h2 class="section-title">VALOR DEL VIAJE</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Valor a pagar por el Viaje</label>
                        <input type="number" id="valorViaje" name="valorViaje" step="0.01">
                    </div>
                    <div class="form-group">
                        <label>Valor Trayecto Vacío 1</label>
                        <input type="number" id="trayectoVacio1" name="trayectoVacio1" step="0.01">
                    </div>
                    <div class="form-group">
                        <label>Valor Trayecto Vacío 2</label>
                        <input type="number" id="trayectoVacio2" name="trayectoVacio2" step="0.01">
                    </div>
                    <div class="form-group">
                        <label>Retención en la Fuente</label>
                        <input type="number" id="retencionFuente" name="retencionFuente" step="0.01" readonly>
                    </div>
                    <div class="form-group">
                        <label>Lugar del Pago</label>
                        <input type="text" id="lugarPago" name="lugarPago">
                    </div>
                    <div class="form-group">
                        <label>Fecha Pago</label>
                        <input type="date" id="fechaPago" name="fechaPago">
                    </div>
                    <div class="form-group">
                        <label>Retención ICA (%*mil)</label>
                        <input type="number" id="retencionICA" name="retencionICA" step="0.01">
                        <input type="number" id="retencionICAValor" name="retencionICAValor" step="0.01" placeholder="Valor">
                    </div>
                    <div class="form-group">
                        <label>Neto a Pagar</label>
                        <input type="number" id="netoPagar" name="netoPagar" step="0.01">
                    </div>
                    <div class="form-group">
                        <label>Responsable del Pago</label>
                        <input type="text" id="responsablePago" name="responsablePago">
                    </div>
                    <div class="form-group">
                        <label>Cargue</label>
                        <select id="cargue" name="cargue">
                            <option value="">Seleccione</option>
                            <option value="si">Sí</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Descargue</label>
                        <select id="descargue" name="descargue">
                            <option value="">Seleccione</option>
                            <option value="si">Sí</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Valor Anticipo</label>
                        <input type="number" id="valorAnticipo" name="valorAnticipo" step="0.01">
                    </div>
                    <div class="form-group">
                        <label>Saldo x Pagar</label>
                        <input type="number" id="saldoPagar" name="saldoPagar" step="0.01" readonly>
                    </div>
                    <div class="form-group full-width">
                        <label>Recomendaciones</label>
                        <textarea id="recomendaciones" name="recomendaciones" rows="3"></textarea>
                    </div>
                </div>
            </div>

            <!-- DATOS DE CONTROL -->
            <div class="form-section">
                <h2 class="section-title">DATOS DE CONTROL</h2>
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label>La firma de aceptación de éste manifiesto por parte del titular del manifiesto será electrónica</label>
                        <select id="firmaElectronica" name="firmaElectronica">
                            <option value="si">SI</option>
                            <option value="no">NO</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Empresa de Monitoreo para éste manifiesto</label>
                        <input type="text" id="empresaMonitoreo" name="empresaMonitoreo">
                    </div>
                </div>
            </div>

            <!-- REMESAS -->
            <div class="form-section">
                <h2 class="section-title">REMESAS</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label>CONSULTAR REMESAS</label>
                        <select id="consultarRemesas" name="consultarRemesas">
                            <option value="">Seleccione para cargar...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Remesa deseada:</label>
                        <input type="text" id="remesaDeseada" name="remesaDeseada" placeholder="Ingrese consecutivo">
                    </div>
                    <div class="form-group">
                        <button type="button" onclick="addRemesa()" class="btn-primary">ADICIONAR</button>
                    </div>
                    <div class="form-group full-width">
                        <table id="remesasTable" border="1" width="100%">
                            <thead>
                                <tr>
                                    <th>Consecutivo Remesa</th>
                                    <th>Cargue</th>
                                    <th>Descargue</th>
                                    <th>Cod. Mercancía</th>
                                    <th>Mercancía</th>
                                    <th>Cantidad</th>
                                    <th>Unid. Medida</th>
                                    <th>Horas Pacto Cargue</th>
                                    <th>Minutos Pacto Cargue</th>
                                    <th>Horas Pacto Descargue</th>
                                    <th>Minutos Pacto Descargue</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="12" align="center">
                                        No hay Registros para mostrar
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <label>Cantidad Remesas</label>
                        <input type="number" id="cantidadRemesas" name="cantidadRemesas" readonly>
                    </div>
                    <div class="form-group">
                        <label>Kilogramos</label>
                        <input type="number" id="kilogramos" name="kilogramos" step="0.01">
                    </div>
                    <div class="form-group">
                        <label>Galones</label>
                        <input type="number" id="galones" name="galones" step="0.01">
                    </div>
                    <div class="form-group">
                        <label>Tiempo Total Cargue Pactado</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="number" id="horasCargue" name="horasCargue" placeholder="Horas" readonly>
                            <input type="number" id="minutosCargue" name="minutosCargue" placeholder="Minutos" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Tiempo Total Descargue Pactado</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="number" id="horasDescargue" name="horasDescargue" placeholder="Horas" readonly>
                            <input type="number" id="minutosDescargue" name="minutosDescargue" placeholder="Minutos" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BOTONES -->
            <div class="form-actions">
                <button type="button" class="btn-secondary" onclick="resetForm()">Limpiar Formulario</button>
                <button type="submit" class="btn-primary">Guardar Manifiesto</button>
            </div>
            <div class="form-group full-width">
                <p style="font-size: 0.9em; color: #666; margin-top: 20px;">
                    El presente Registro debe ser llenado sin excepción en su totalidad. La omisión de cualquier información dará lugar a las sanciones previstas en la normatividad correspondiente. La Empresa de Transporte debe detallar, con la precisión requerida en este formulario, los valores pactados.
                </p>
            </div>
        </form>
    </div>

    <footer>
        <p>&copy; 2026 Ministerio de Transporte - Todos los derechos reservados</p>
    </footer>

    <script src="/RNDC/public/js/manifiesto.js"></script>
</body>
</html>