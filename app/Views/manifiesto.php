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
                        <input type="text" value="TRANSPORTES QUIROGA S.A.S">
                    </div>
                    <div class="form-group">
                        <label>NIT Empresa</label>
                        <input type="text" value="8020099265" >
                    </div>
                    <div class="form-group">
                        <label>Usuario</label>
                        <input type="text" value="TRANSQUIROGA@0144" >
                    </div>
                </div>
            </div>

           <!-- INFORMACIÓN PRELIMINAR -->
<div class="form-section">
    <h2 class="section-title">Información Preliminar</h2>

    <div class="form-grid">

        <div class="form-group">
            <label>Información de Viaje</label>
            <input type="text" name="informacionViaje">
        </div>

        <div class="form-group">
            <label>Radicado Viaje Consolidado</label>
            <input type="text" name="radicadoViajeConsolidado">
        </div>

        <div class="form-group">
            <label>Manifiesto anterior para Transbordo o Reemplazo</label>
            <input type="text" name="manifiestoAnterior">
        </div>

        <div class="form-group">
            <label>Consecutivo *</label>
            <input type="text" name="consecutivo" required>
        </div>

    </div>
</div>

<!-- CARACTERÍSTICAS GENERALES DEL MANIFIESTO -->
<div class="form-section">
    <h2 class="section-title">Características Generales del Manifiesto</h2>

    <div class="form-grid">

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
            <label>&nbsp;</label>
            <input type="text" name="codigoMunicipioOrigen">
        </div>

        <div class="form-group">
            <label>Municipio Destino *</label>
            <input type="text" name="municipioDestino" required>
        </div>

        <div class="form-group">
            <label>&nbsp;</label>
            <input type="text" name="codigoMunicipioDestino">
        </div>

        <div class="form-group">
            <label>Municipio Intermedio</label>
            <input type="text" name="municipioIntermedio">
        </div>

        <div class="form-group">
            <label>&nbsp;</label>
            <input type="text" name="codigoMunicipioIntermedio">
        </div>

        <div class="form-group full-width">
            <label>Vía a Utilizar *</label>
            <select name="viaUtilizar" required>
                <option value="">Seleccione...</option>
                <option value="ruta_nacional">Ruta Nacional</option>
                <option value="ruta_departamental">Ruta Departamental</option>
            </select>
        </div>

        <div class="form-group">
            <label>Municipio Origen Vacío 1</label>
            <input type="text" name="municipioOrigenVacio1">
        </div>

        <div class="form-group">
            <label>&nbsp;</label>
            <input type="text" name="codigoMunicipioOrigenVacio1">
        </div>

        <div class="form-group">
            <label>Municipio Destino Vacío 1</label>
            <input type="text" name="municipioDestinoVacio1">
        </div>

        <div class="form-group">
            <label>&nbsp;</label>
            <input type="text" name="codigoMunicipioDestinoVacio1">
        </div>

        <div class="form-group">
            <label>Municipio Origen Vacío 2</label>
            <input type="text" name="municipioOrigenVacio2">
        </div>

        <div class="form-group">
            <label>&nbsp;</label>
            <input type="text" name="codigoMunicipioOrigenVacio2">
        </div>

        <div class="form-group">
            <label>Municipio Destino Vacío 2</label>
            <input type="text" name="municipioDestinoVacio2">
        </div>

        <div class="form-group">
            <label>&nbsp;</label>
            <input type="text" name="codigoMunicipioDestinoVacio2">
        </div>

    </div>
</div>

<!-- TITULAR DEL MANIFIESTO -->
<div class="form-section">
    <h2 class="section-title">Titular Manifiesto</h2>

    <div class="form-grid">

        <div class="form-group">
            <label>Tipo Identificación *</label>
            <select name="tipoIdentificacion" required>
                <option value="">Seleccione...</option>
                <option value="cc">Cédula</option>
                <option value="nit">NIT</option>
            </select>
        </div>

        <div class="form-group">
            <label>Número Identificación *</label>
            <input type="text" name="numeroIdentificacion" required>
        </div>

        <div class="form-group">
            <label>Sede *</label>
            <select name="sede" required>
                <option value="">Seleccione...</option>
            </select>
        </div>

        <div class="form-group">
            <label>Nombre *</label>
            <input type="text" name="nombreTitular" required>
        </div>

        <div class="form-group">
            <label>Dirección *</label>
            <input type="text" name="direccionTitular" required>
        </div>

        <div class="form-group">
            <label>Municipio *</label>
            <input type="text" name="municipioTitular" required>
        </div>

        <div class="form-group">
            <label>Teléfono</label>
            <input type="text" name="telefonoTitular">
        </div>

    </div>
</div>

<!-- VEHÍCULO -->
<div class="form-section">
    <h2 class="section-title">Vehículo</h2>

    <div class="form-grid">

        <!-- Vehículo principal -->
        <div class="form-group">
            <label>Placa Vehículo *</label>
            <input type="text" name="placaVehiculo" required>
        </div>

        <div class="form-group">
            <label>Configuración *</label>
            <input type="text" name="configuracionVehiculo" required>
        </div>

        <div class="form-group">
            <label>Peso Vacío</label>
            <input type="number" name="pesoVacioVehiculo" step="0.01">
        </div>

        <div class="form-group full-width">
            <label>Tenedor del Vehículo *</label>
            <input type="text" name="tenedorVehiculo" required>
        </div>

        <div class="form-group">
            <label>Identificación *</label>
            <input type="text" name="identificacionTenedor" required>
        </div>

        <!-- SOAT -->
        <div class="form-group">
            <label>Póliza SOAT *</label>
            <input type="text" name="polizaSoat" required>
        </div>

        <div class="form-group">
            <label>Vencimiento *</label>
            <input type="date" name="vencimientoSoat" required>
        </div>

        <div class="form-group full-width">
            <label>Aseguradora *</label>
            <input type="text" name="aseguradoraSoat" required>
        </div>

        <!-- Remolque -->
        <div class="form-group">
            <label>Placa Remolque 1</label>
            <input type="text" name="placaRemolque1">
        </div>

        <div class="form-group">
            <label>Configuración</label>
            <input type="text" name="configuracionRemolque1">
        </div>

        <div class="form-group">
            <label>Peso Vacío</label>
            <input type="number" name="pesoVacioRemolque1" step="0.01">
        </div>

        <!-- Configuración resultante -->
        <div class="form-group">
            <label>Configuración Resultante</label>
            <input type="text" name="configuracionResultante">
        </div>

        <div class="form-group">
            <label>&nbsp;</label>
            <input type="text" name="codigoConfiguracionResultante">
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
                    <div class="form-group">
                        <label> Licencia *</label>
                        <input type="text" name="conductor1Licencia" required>
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
                    <div class="form-group">
                        <label> Licencia *</label>
                        <input type="text" name="conductor2Licencia" required>
                    </div>
                </div>
            </div>

<!-- VALOR DEL VIAJE -->
<div class="form-section">
    <h2 class="section-title">VALOR DEL VIAJE</h2>

    <div class="form-grid">

        <div class="form-group">
            <label>Valor a pagar por el Viaje</label>
            <input type="number" name="valorViaje">
        </div>

        <div class="form-group">
            <label>Valor Trayecto Vacío 1</label>
            <input type="number" name="trayectoVacio1">
        </div>

        <div class="form-group">
            <label>Valor Trayecto Vacío 2</label>
            <input type="number" name="trayectoVacio2">
        </div>

        <div class="form-group">
            <label>Retención en la Fuente</label>
            <input type="number" name="retencionFuente">
        </div>

        <div class="form-group">
            <label>Lugar del Pago</label>
            <input type="text" name="lugarPago">
        </div>

        <div class="form-group">
            <label>Fecha Pago</label>
            <input type="date" name="fechaPago">
        </div>

        <div class="form-group">
            <label>Retención ICA (%*mil)</label>
            <input type="number" name="retencionICA">
            <input type="number" name="retencionICAValor">
        </div>

        <div class="form-group">
            <label>Neto a Pagar</label>
            <input type="number" name="netoPagar">
        </div>

        <div class="form-group">
            <label>Responsable del Pago</label>
            <input type="text" name="responsablePago">
        </div>

        <div class="form-group">
            <label>Cargue</label>
            <select name="cargue">
                <option value="">Seleccione</option>
                <option value="si">Sí</option>
                <option value="no">No</option>
            </select>
        </div>

        <div class="form-group">
            <label>Descargue</label>
            <select name="descargue">
                <option value="">Seleccione</option>
                <option value="si">Sí</option>
                <option value="no">No</option>
            </select>
        </div>

        <div class="form-group">
            <label>Valor Anticipo</label>
            <input type="number" name="valorAnticipo">
        </div>

        <div class="form-group">
            <label>Saldo x Pagar</label>
            <input type="number" name="saldoPagar">
        </div>

        <div class="form-group full-width">
            <label>Recomendaciones</label>
            <textarea name="recomendaciones"></textarea>
        </div>

    </div>
</div>

<!-- DATOS DE CONTROL -->
<div class="form-section">
    <h2 class="section-title">DATOS DE CONTROL</h2>

    <div class="form-grid">

        <div class="form-group full-width">
            <label>
                La firma de aceptación de éste manifiesto por parte del titular del manifiesto será electrónica
            </label>
            <select name="firmaElectronica">
                <option value="">SI / NO</option>
                <option value="si">SI</option>
                <option value="no">NO</option>
            </select>
        </div>

        <div class="form-group">
            <label>Empresa de Monitoreo para éste manifiesto</label>
            <select name="empresaMonitoreo">
                <option value="">Seleccione</option>
            </select>
        </div>

        <div class="form-group">
            <label>&nbsp;</label>
            <input type="text" name="empresaMonitoreoOtro">
        </div>

    </div>
</div>


<!-- REMESAS -->
<div class="form-section">
    <h2 class="section-title">REMESAS</h2>

    <div class="form-grid">

        <div class="form-group">
            <label>CONSULTAR REMESAS</label>
            <select name="consultarRemesas">
                <option value="">Seleccione</option>
            </select>
        </div>

        <div class="form-group">
            <label>Remesa deseada:</label>
            <input type="text" name="remesaDeseada">
        </div>

        <div class="form-group">
            <label>&nbsp;</label>
            <button type="button">ADICIONAR</button>
            <button type="button">ELIMINAR</button>
        </div>

        <div class="form-group full-width">
            <table border="1" width="100%">
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
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="11" align="center">
                            No hay Registros para mostrar
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="form-group">
            <label>Cantidad Remesas</label>
            <input type="number" name="cantidadRemesas">
        </div>

        <div class="form-group">
            <label>Kilogramos</label>
            <input type="number" name="kilogramos">
        </div>

        <div class="form-group">
            <label>Galones</label>
            <input type="number" name="galones">
        </div>

        <div class="form-group">
            <label>Tiempo Total Cargue Pactado</label>
            <label for="">Horas</label>
            <input type="number" name="horasCargue">
            <label for="">Minutos</label>
            <input type="number" name="minutosCargue">
        </div>

        <div class="form-group">
            <label>Tiempo Total Descargue Pactado</label>
            <label for="">Horas</label>
            <input type="number" name="horasDescargue">
            <label for="">Minutos</label>
            <input type="number" name="minutosDescargue">
        </div>

    </div>
</div>


            <!-- BOTONES -->
            <div class="form-actions">
                <button type="button" class="btn-secondary" onclick="resetForm()">Limpiar Formulario</button>
                <button type="submit" class="btn-primary">Guardar Manifiesto</button>
            </div>
            <div class="form-group full-width">
        El presente Registro debe ser llenado sin excepción en su totalidad. La omisión de cualquier información dará lugar a las sanciones previstas en la normatividad
correspondiente. La Empresa de Transporte debe detallar, con la precisión requerida en este formulario, los valores pactados
    </div>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Ministerio de Transporte - Todos los derechos reservados</p>
    </footer>

    <script src="/RNDC/public/js/manifiesto.js"></script>
</body>
</html>