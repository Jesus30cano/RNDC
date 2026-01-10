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
            <button class="btn-logout" onclick="logout()">Cerrar Sesión</button>
        </div>
        <img src="/RNDC/public/assets/images/transporte.webp" alt="Ministerio de Transporte" class="logo-right">
    </header>

    <div class="main-content">
        <form id="remesaForm" class="form-container">
            <!-- DATOS GENERALES -->
            <div class="form-section">
                <h2 class="section-title">Remesa</h2>
                <div class="form-grid">
                    <div class="form-group ">
                        <label>Nombre Empresa</label>
                        <input type="text" value="TRANSPORTES QUIROGA S.A.S" required>
                    </div>
                    <div class="form-group">
                        <label>NIT Empresa</label>
                        <input type="text" value="8020099265" required>
                    </div>
                    <div class="form-group">
                        <label>Usuario</label>
                        <input type="text" value="TRANSQUIROGA@0144" required>
                    </div>
                    
                </div>
            </div>

            <!-- PROPIETARIO DE LA CARGA -->
            <div class="form-section">
                <h2 class="section-title">Propietario de la Carga / Generador de Carga / Contratante</h2>
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
            <!-- datos generales de la remesa -->
             <div class="form-section">
                <h2 class="section-title">Datos Generales de la Remesa</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label >Consecutivo Informacion de Carga</label>
                        <input type="text" name="consecutivoInfoCarga" required>

                    </div>
                    <div class="form-group">
                        <label >Consecutivo Remesa Copia</label>
                        <input type="text" name="consecutivoRemesaCopia">
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
                    <div class="form-group">
                        <label >Sede</label>
                        <select name="sedeCargue" id="sedeCargue">
                            <option value="">Seleccione...</option>
                            <option value="sede1">Sede 1</option>
                            <option value="sede2">Sede 2</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label >Codigo Sede</label>
                        <input type="text" name="codigoSedeCarge" id="codigoSedeCargue" >
                    </div>
                    <div class="form-group ">
                        <label>Nombre *</label>
                        <input type="text" name="cargueNombre" required>
                    </div>
                    <div class="form-group ">
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
                    <div class="form-group">
                        <label >Sede</label>
                        <select name="sedeDescargue" id="sedeDescargue">
                            <option value="">Seleccione...</option>
                            <option value="sede1">Sede 1</option>
                            <option value="sede2">Sede 2</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label >Codigo Sede</label>
                        <input type="text" name="codigoSedeDescarge" id="codigoSedeDescarge" >
                    </div>                    
                    <div class="form-group ">
                        <label>Nombre *</label>
                        <input type="text" name="descargueNombre" required>
                    </div>
                    <div class="form-group ">
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
                    <div class="form-group">
                        <label>Capitulo *</label>
                        <select name="capitulo" id="capitulo">
                            <option value="">Seleccione...</option>
                            <option value="capitulo1">Capitulo 1</option>
                            <option value="capitulo2">Capitulo 2</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Partida *</label>
                        <select name="partida" id="partida">
                            <option value="">Seleccione...</option>
                            <option value="partida1">Partida 1</option>
                            <option value="partida2">Partida 2</option>
                        </select>
                    </div>      
                    <div class="form-group">
                        <label>Subpartida *</label>
                        <select name="subpartida" id="subpartida">
                            <option value="">Seleccione...</option>
                            <option value="subpartida1">Subpartida 1</option>
                            <option value="subpartida2">Subpartida 2</option>
                        </select>
                    </div>                
                    <div class="form-group">
                        <label >CodSubpartida</label>
                        <input type="text" name="codSubpartida" id="codSubpartida" >
                    </div>
                    <div class="form-group">
                        <label>Codigo Arancel *</label>
                        <select name="codigoArancel" id="codigoArancel">
                            <option value="">Seleccione...</option>
                            <option value="codigo1">Partida 1</option>
                            <option value="codigo2">Partida 2</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label >Cod.Arancel</label>
                        <input type="text" name="codArancel" id="codArancel" >
                    </div>
                    <div class="form-group">
                        <label for="">Codigo UN</label>
                        <input type="text" name="codigoUN" >
                    </div>
                    <div class="form-group">
                        <label>Estado de Producto</label>
                        <select name="estadoProducto" id="estadoProducto">
                            <option value="">Seleccione...</option>
                            <option value="nuevo">Nuevo</option>
                            <option value="usado">Usado</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Grupo de Embalaje Envase *</label>
                        <select name="grupoEmbalajeEnvase" id="grupoEmbalajeEnvase">
                            <option value="">Seleccione...</option>
                            <option value="grupo1">Grupo 1</option>
                            <option value="grupo2">Grupo 2</option>
                        </select>
                    </div>                                              
                    <div class="form-group full-width">
                        <label>Descripción Producto *</label>
                        <textarea name="descripcionProducto" rows="3" required></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label>Nombre Tecnico o Grupo Quimico del N.E.P. *</label>
                        <textarea name="nombreTecnicoGrupoQuimico" rows="3" required></textarea>
                    </div> 
                    <div class="form-group full-width">
                        <label for="">"En ésta casilla se describe el nombre o grupo químico de la sustancia que le aporta el peligro, por tratarse de un NO Especificado en otra Parte"</label>
                    </div>
                    <div class="form-group full-width">
                        <label>Descripcion Detallada Residuaos Peligroso*</label>
                        <textarea name="descripcionDetalladaResiduosPeligrosos" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Caractetisticas Peligrocidad *</label>
                        <select name="caracteristicasPeligrocidad" required>
                            <option value="bajo">bajo</option>
                            <option value="medio">medio</option>
                            <option value="alto">alto</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Corrientes de Residuos Peligrosos *</label>
                        <select name="corrientesResiduosPeligrosos" required>
                            <option value="bajo">bajo</option>
                            <option value="medio">medio</option>
                            <option value="alto">alto</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Desagregacion *</label>
                        <select name="desagregacion" required>
                            <option value="bajo">bajo</option>
                            <option value="medio">medio</option>
                            <option value="alto">alto</option>
                        </select>
                    </div>

                </div>
            </div>
            <!-- empaque y cantidad -->
<div class="form-section">
    <h2 class="section-title">Empaque y Cantidad del Producto</h2>

    <div class="form-grid">

        <!-- Unidad medida producto -->
        <div class="form-group">
            <label>Unidad Medida del Producto *</label>
            <select name="unidadMedidaProducto" required>
                <option value="KG">Kilogramo</option>
                <option value="TON">Tonelada</option>
                <option value="GAL">Galón</option>
                <option value="LT">Litro</option>
            </select>
        </div>

        <div class="form-group">
            <label>Cantidad *</label>
            <input type="number" name="cantidadProducto" step="0.01" required>
        </div>

        <!-- Unidad medida transporte -->
        <div class="form-group">
            <label>Unidad Medida Transporte *</label>
            <select name="unidadMedidaTransporte" required>
                <option value="KG">Kilogramo</option>
                <option value="TON">Tonelada</option>
            </select>
        </div>

        <div class="form-group">
            <label>Cantidad *</label>
            <input type="number" name="cantidadTransporte" step="0.01" required>
        </div>

        <!-- Empaque primario -->
        <div class="form-group">
            <label>Empaque Primario o Interno *</label>
            <select name="empaquePrimario" required>
                <option value="">Seleccione...</option>
                <option value="caja">Caja</option>
                <option value="saco">Saco</option>
                <option value="bulto">Bulto</option>
                <option value="estiba">Estiba</option>
            </select>
        </div>

        <div class="form-group">
            <label>Material *</label>
            <select name="materialPrimario" required>
                <option value="">Seleccione...</option>
                <option value="carton">Cartón</option>
                <option value="plastico">Plástico</option>
                <option value="madera">Madera</option>
                <option value="metal">Metal</option>
            </select>
        </div>

        <div class="form-group">
            <label>Código</label>
            <input type="text" name="codigoPrimario">
        </div>

        <!-- Empaque externo -->
        <div class="form-group">
            <label>Empaque Externo</label>
            <select name="empaqueExterno">
                <option value="">Seleccione...</option>
                <option value="caja">Caja</option>
                <option value="contenedor">Contenedor</option>
                <option value="estiba">Estiba</option>
            </select>
        </div>

        <div class="form-group">
            <label>Material</label>
            <select name="materialExterno">
                <option value="">Seleccione...</option>
                <option value="carton">Cartón</option>
                <option value="plastico">Plástico</option>
                <option value="madera">Madera</option>
                <option value="metal">Metal</option>
            </select>
        </div>

        <div class="form-group">
            <label>Código</label>
            <input type="text" name="codigoExterno">
        </div>

        <!-- Peso contenedor vacío -->
        <div class="form-group">
            <label>Peso Contenedor Vacío</label>
            <input type="number" name="pesoContenedorVacio" step="0.01">
        </div>

        <div class="form-group">
            <label>Kilos</label>
            <input type="number" name="kilosContenedorVacio" step="0.01">
        </div>

    </div>
</div>



            <!-- SEGURO MERCANCÍA -->
<div class="form-section">
    <h2 class="section-title">Seguro de Mercancía</h2>

    <div class="form-grid">

        <!-- Póliza General -->
        <div class="form-group">
            <label>Tipo Póliza *</label>
            <input type="text" name="tipoPolizaGeneral" value="Gen" readonly>
        </div>

        <div class="form-group">
            <label>Tomador de la póliza *</label>
            <select name="tomadorPolizaGeneral" required>
                <option value="empresa_transportadora">Empresa Transportadora</option>
                <option value="remitente">Remitente</option>
            </select>
        </div>

        <div class="form-group">
            <label>Número *</label>
            <input type="text" name="numeroPolizaGeneral" value="1070000035901" required>
        </div>

        <div class="form-group">
            <label>Fecha Vencimiento *</label>
            <input type="date" name="fechaVencimientoGeneral" value="2026-06-30" required>
        </div>

        <div class="form-group">
            <label>Aseguradora *</label>
            <select name="aseguradoraGeneral" required>
                <option value="seguros_comerciales">SEGUROS COMERCIALES</option>
            </select>
        </div>

        <div class="form-group">
            <label>NIT Aseguradora *</label>
            <input type="text" name="nitAseguradoraGeneral" value="8600021807" required>
        </div>

        <!-- Póliza Mercancía Peligrosa -->
        <div class="form-group">
            <label>Tipo Póliza *</label>
            <input type="text" name="tipoPolizaPeligrosa" value="Pelig" readonly>
        </div>

        <div class="form-group">
            <label>Tomador de la póliza *</label>
            <select name="tomadorPolizaPeligrosa" required>
                <option value="empresa_transportadora">Empresa Transportadora</option>
                <option value="remitente">Remitente</option>
            </select>
        </div>

        <div class="form-group">
            <label>Número *</label>
            <input type="text" name="numeroPolizaPeligrosa" value="1070000035901" required>
        </div>

        <div class="form-group">
            <label>Fecha Vencimiento *</label>
            <input type="date" name="fechaVencimientoPeligrosa" value="2026-06-30" required>
        </div>

        <div class="form-group">
            <label>Aseguradora *</label>
            <select name="aseguradoraPeligrosa" required>
                <option value="seguros_comerciales">SEGUROS COMERCIALES</option>
            </select>
        </div>

        <div class="form-group">
            <label>NIT Aseguradora *</label>
            <input type="text" name="nitAseguradoraPeligrosa" value="8600021807" required>
        </div>

    </div>

    <div class="form-group full-width">
        Póliza de Responsabilidad Civil Extracontractual según Sección 8, artículo 2.2.1.7.8.5.1.
        Transporte terrestre automotor de mercancías peligrosas por carretera, del Decreto 1079 de 2015
        (que cubre daños ambientales)
    </div>
    
</div>
<!-- TRANSBORDOS -->
<div class="form-section">
    <h2 class="section-title">Municipios de Transbordo</h2>

    <div class="form-grid">

        <!-- Transbordo 1 -->
        <div class="form-group">
            <label>Municipio Transbordo 1</label>
            <input type="text" name="municipioTransbordo1">
        </div>

        <div class="form-group">
            <label>Codigo 1</label>
            <input type="text" name="codigoMunicipioTransbordo1">
        </div>

        <!-- Transbordo 2 -->
        <div class="form-group">
            <label>Municipio Transbordo 2</label>
            <input type="text" name="municipioTransbordo2">
        </div>

        <div class="form-group">
            <label>Codigo 2</label>
            <input type="text" name="codigoMunicipioTransbordo2">
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