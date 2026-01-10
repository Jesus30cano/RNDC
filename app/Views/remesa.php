<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RNDC - Remesa Terrestre de Carga</title>
    <link rel="stylesheet" href="/RNDC/public/css/forms.css">
</head>
<body>
    <header>
        <img src="/RNDC/public/assets/images/colombia-potencia.webp" alt="Colombia Potencia de la Vida" class="logo-left">
        <div class="header-center">
            <h1>Remesa Terrestre de Carga</h1>
        </div>
        <div class="header-actions">
            <a href="index.php?c=dashboard&a=index" class="btn-back">← Volver al Dashboard</a>
            <button class="index.php?c=dashbo" onclick="logout()">Cerrar Sesión</button>
        </div>
        <img src="/RNDC/public/assets/images/transporte.webp" alt="Ministerio de Transporte" class="logo-right">
    </header>

    <div class="main-content">
        <form id="remesaForm" class="form-container">
            <!-- DATOS GENERALES -->
            <div class="form-section">
                <h2 class="section-title">Datos Generales de la Remesa</h2>
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
                    <div class="form-group">
                        <label>Consecutivo Remesa *</label>
                        <input type="text" name="consecutivo" required>
                    </div>
                    <div class="form-group">
                        <label>Orden de Servicio</label>
                        <input type="text" name="ordenServicio">
                    </div>
                    <div class="form-group">
                        <label>Tipo Operación *</label>
                        <select name="tipoOperacion" required>
                            <option value="">Seleccione...</option>
                            <option value="general">General</option>
                            <option value="especial">Especial</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tipo Empaque *</label>
                        <select name="tipoEmpaque" required>
                            <option value="">Seleccione...</option>
                            <option value="bulto">Bulto</option>
                            <option value="caja">Caja</option>
                            <option value="estiba">Estiba</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- PROPIETARIO DE LA CARGA -->
            <div class="form-section">
                <h2 class="section-title">Propietario de la Carga / Generador</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Tipo Identificación *</label>
                        <select name="propTipoId" required>
                            <option value="CC">Cédula Ciudadanía</option>
                            <option value="NIT">NIT</option>
                            <option value="CE">Cédula Extranjería</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Número Identificación *</label>
                        <input type="text" name="propNumId" required>
                    </div>
                    <div class="form-group full-width">
                        <label>Nombre *</label>
                        <input type="text" name="propNombre" required>
                    </div>
                    <div class="form-group">
                        <label>Municipio *</label>
                        <input type="text" name="propMunicipio" required>
                    </div>
                    <div class="form-group">
                        <label>Sede</label>
                        <input type="text" name="propSede">
                    </div>
                </div>
            </div>

            <!-- SITIO CARGUE -->
            <div class="form-section">
                <h2 class="section-title">Sitio de Cargue</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Tipo Identificación *</label>
                        <select name="cargueTipoId" required>
                            <option value="CC">Cédula Ciudadanía</option>
                            <option value="NIT">NIT</option>
                            <option value="CE">Cédula Extranjería</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Número Identificación *</label>
                        <input type="text" name="cargueNumId" required>
                    </div>
                    <div class="form-group full-width">
                        <label>Nombre *</label>
                        <input type="text" name="cargueNombre" required>
                    </div>
                    <div class="form-group full-width">
                        <label>Dirección *</label>
                        <input type="text" name="cargueDireccion" required>
                    </div>
                    <div class="form-group">
                        <label>Municipio *</label>
                        <input type="text" name="cargueMunicipio" required>
                    </div>
                    <div class="form-group">
                        <label>Fecha Cita *</label>
                        <input type="date" name="cargueFecha" required>
                    </div>
                    <div class="form-group">
                        <label>Hora Cita *</label>
                        <input type="time" name="cargueHora" required>
                    </div>
                    <div class="form-group">
                        <label>Tiempo Cargue (Horas) *</label>
                        <input type="number" name="cargueTiempoHoras" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Tiempo Cargue (Minutos)</label>
                        <input type="number" name="cargueTiempoMin" min="0" max="59">
                    </div>
                    <div class="form-group">
                        <label>Latitud</label>
                        <input type="text" name="cargueLatitud" placeholder="Ej: 4.6097">
                    </div>
                    <div class="form-group">
                        <label>Longitud</label>
                        <input type="text" name="cargueLongitud" placeholder="Ej: -74.0817">
                    </div>
                </div>
            </div>

            <!-- SITIO DESCARGUE -->
            <div class="form-section">
                <h2 class="section-title">Sitio de Descargue</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Tipo Identificación *</label>
                        <select name="descargueTipoId" required>
                            <option value="CC">Cédula Ciudadanía</option>
                            <option value="NIT">NIT</option>
                            <option value="CE">Cédula Extranjería</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Número Identificación *</label>
                        <input type="text" name="descargueNumId" required>
                    </div>
                    <div class="form-group full-width">
                        <label>Nombre *</label>
                        <input type="text" name="descargueNombre" required>
                    </div>
                    <div class="form-group full-width">
                        <label>Dirección *</label>
                        <input type="text" name="descargueDireccion" required>
                    </div>
                    <div class="form-group">
                        <label>Municipio *</label>
                        <input type="text" name="descargueMunicipio" required>
                    </div>
                    <div class="form-group">
                        <label>Fecha Cita *</label>
                        <input type="date" name="descargueFecha" required>
                    </div>
                    <div class="form-group">
                        <label>Hora Cita *</label>
                        <input type="time" name="descargueHora" required>
                    </div>
                    <div class="form-group">
                        <label>Tiempo Descargue (Horas) *</label>
                        <input type="number" name="descargueTiempoHoras" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Tiempo Descargue (Minutos)</label>
                        <input type="number" name="descargueTiempoMin" min="0" max="59">
                    </div>
                    <div class="form-group">
                        <label>Latitud</label>
                        <input type="text" name="descargueLatitud" placeholder="Ej: 4.6097">
                    </div>
                    <div class="form-group">
                        <label>Longitud</label>
                        <input type="text" name="descargueLongitud" placeholder="Ej: -74.0817">
                    </div>
                </div>
            </div>

            <!-- PRODUCTO MERCANCÍA -->
            <div class="form-section">
                <h2 class="section-title">Producto - Mercancía</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Naturaleza Carga *</label>
                        <select name="naturalezaCarga" required>
                            <option value="">Seleccione...</option>
                            <option value="general">General</option>
                            <option value="peligrosa">Peligrosa</option>
                            <option value="perecedera">Perecedera</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Código Producto *</label>
                        <input type="text" name="codigoProducto" required>
                    </div>
                    <div class="form-group full-width">
                        <label>Descripción Producto *</label>
                        <textarea name="descripcionProducto" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Unidad Medida *</label>
                        <select name="unidadMedida" required>
                            <option value="KG">Kilogramo</option>
                            <option value="TON">Tonelada</option>
                            <option value="GAL">Galón</option>
                            <option value="LT">Litro</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Cantidad *</label>
                        <input type="number" name="cantidad" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label>Empaque Primario *</label>
                        <select name="empaquePrimario" required>
                            <option value="">Seleccione...</option>
                            <option value="caja">Caja</option>
                            <option value="saco">Saco</option>
                            <option value="bulto">Bulto</option>
                            <option value="estiba">Estiba</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Empaque Externo</label>
                        <select name="empaqueExterno">
                            <option value="">Seleccione...</option>
                            <option value="caja">Caja</option>
                            <option value="contenedor">Contenedor</option>
                            <option value="estiba">Estiba</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- SEGURO MERCANCÍA -->
            <div class="form-section">
                <h2 class="section-title">Seguro de Mercancía</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Tipo Póliza *</label>
                        <select name="tipoPoliza" required>
                            <option value="general">General</option>
                            <option value="especial">Especial</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Número Póliza *</label>
                        <input type="text" name="numeroPoliza" value="1070000035901" required>
                    </div>
                    <div class="form-group">
                        <label>Fecha Vencimiento *</label>
                        <input type="date" name="vencimientoPoliza" required>
                    </div>
                    <div class="form-group">
                        <label>Aseguradora *</label>
                        <input type="text" name="aseguradora" value="SEGUROS COMERCIALES" required>
                    </div>
                    <div class="form-group">
                        <label>NIT Aseguradora *</label>
                        <input type="text" name="nitAseguradora" value="8600021807" required>
                    </div>
                </div>
            </div>

            <!-- OBSERVACIONES -->
            <div class="form-section">
                <h2 class="section-title">Observaciones</h2>
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label>Observaciones Adicionales</label>
                        <textarea name="observaciones" rows="4" placeholder="Ingrese observaciones adicionales sobre la remesa..."></textarea>
                    </div>
                </div>
            </div>

            <!-- BOTONES -->
            <div class="form-actions">
                <button type="button" class="btn-secondary" onclick="resetForm()">Limpiar Formulario</button>
                <button type="submit" class="btn-primary">Guardar Remesa</button>
            </div>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Ministerio de Transporte - Todos los derechos reservados</p>
    </footer>

    <script src="/RNDC/public/js/remesa.js"></script>
</body>
</html>