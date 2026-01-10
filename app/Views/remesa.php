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
                        <input type="text" id="nitEmpresa" name="nitEmpresa" value="" required>
                    </div>
                    <div class="form-group">
                        <label>Usuario</label>
                        <input type="text" id="usuario" name="usuario" value="Admin Principal" readonly>
                    </div>
                </div>
            </div>

            <!-- PROPIETARIO DE LA CARGA -->
            <div class="form-section">
                <h2 class="section-title">Propietario de la Carga / Generador de Carga / Contratante</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Tipo Identificación *</label>
                        <select id="propTipoId" name="propTipoId" required>
                            <option value="">Seleccione...</option>
                            <option value="1">Cédula de Ciudadanía</option>
                            <option value="2">NIT</option>
                            <option value="3">Cédula de Extranjería</option>
                            <option value="4">Tarjeta de Identidad</option>
                            <option value="5">Pasaporte</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Número Identificación *</label>
                        <input type="text" id="propNumId" name="propNumId" required>
                    </div>
                    <div class="form-group full-width">
                        <label>Nombre *</label>
                        <input type="text" id="propNombre" name="propNombre" required>
                    </div>
                    <div class="form-group">
                        <label>Municipio *</label>
                        <select id="propMunicipio" name="propMunicipio" required>
                            <option value="">Seleccione...</option>
                            <option value="1">Bogotá D.C.</option>
                            <option value="2">Medellín</option>
                            <option value="3">Cali</option>
                            <option value="4">Barranquilla</option>
                            <option value="5">Cartagena</option>
                            <option value="6">Bucaramanga</option>
                            <option value="7">Pereira</option>
                            <option value="8">Santa Marta</option>
                            <option value="9">Manizales</option>
                            <option value="10">Ibagué</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Sede</label>
                        <input type="text" id="propSede" name="propSede">
                    </div>
                </div>
            </div>

            <!-- DATOS GENERALES DE LA REMESA -->
            <div class="form-section">
                <h2 class="section-title">Datos Generales de la Remesa</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Consecutivo Información de Carga</label>
                        <input type="text" id="consecutivoInfoCarga" name="consecutivoInfoCarga" required>
                    </div>
                    <div class="form-group">
                        <label>Consecutivo Remesa Copia</label>
                        <input type="text" id="consecutivoRemesaCopia" name="consecutivoRemesaCopia">
                    </div>
                    <div class="form-group">
                        <label>Consecutivo Remesa *</label>
                        <input type="text" id="consecutivo" name="consecutivo" required>
                    </div>
                    <div class="form-group">
                        <label>Orden de Servicio</label>
                        <input type="text" id="ordenServicio" name="ordenServicio">
                    </div>
                    <div class="form-group">
                        <label>Tipo Operación *</label>
                        <select id="tipoOperacion" name="tipoOperacion" required>
                            <option value="">Seleccione...</option>
                            <option value="General">General</option>
                            <option value="Especial">Especial</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tipo Empaque *</label>
                        <select id="tipoEmpaque" name="tipoEmpaque" required>
                            <option value="">Seleccione...</option>
                            <option value="Bulto">Bulto</option>
                            <option value="Caja">Caja</option>
                            <option value="Estiba">Estiba</option>
                            <option value="Tambor">Tambor</option>
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
                        <select id="cargueTipoId" name="cargueTipoId" required>
                            <option value="">Seleccione...</option>
                            <option value="1">Cédula de Ciudadanía</option>
                            <option value="2">NIT</option>
                            <option value="3">Cédula de Extranjería</option>
                            <option value="4">Tarjeta de Identidad</option>
                            <option value="5">Pasaporte</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Número Identificación *</label>
                        <input type="text" id="cargueNumId" name="cargueNumId" required>
                    </div>
                    <div class="form-group">
                        <label>Sede</label>
                        <select id="sedeCargue" name="sedeCargue">
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Código Sede</label>
                        <input type="text" id="codigoSedeCargue" name="codigoSedeCargue">
                    </div>
                    <div class="form-group">
                        <label>Nombre *</label>
                        <input type="text" id="cargueNombre" name="cargueNombre" required>
                    </div>
                    <div class="form-group">
                        <label>Dirección *</label>
                        <input type="text" id="cargueDireccion" name="cargueDireccion" required>
                    </div>
                    <div class="form-group">
                        <label>Municipio *</label>
                        <select id="cargueMunicipio" name="cargueMunicipio" required>
                            <option value="">Seleccione...</option>
                            <option value="1">Bogotá D.C.</option>
                            <option value="2">Medellín</option>
                            <option value="3">Cali</option>
                            <option value="4">Barranquilla</option>
                            <option value="5">Cartagena</option>
                            <option value="6">Bucaramanga</option>
                            <option value="7">Pereira</option>
                            <option value="8">Santa Marta</option>
                            <option value="9">Manizales</option>
                            <option value="10">Ibagué</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Fecha Cita *</label>
                        <input type="date" id="cargueFecha" name="cargueFecha" required>
                    </div>
                    <div class="form-group">
                        <label>Hora Cita *</label>
                        <input type="time" id="cargueHora" name="cargueHora" required>
                    </div>
                    <div class="form-group">
                        <label>Tiempo Cargue (Horas) *</label>
                        <input type="number" id="cargueTiempoHoras" name="cargueTiempoHoras" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Tiempo Cargue (Minutos)</label>
                        <input type="number" id="cargueTiempoMin" name="cargueTiempoMin" min="0" max="59">
                    </div>
                    <div class="form-group">
                        <label>Latitud</label>
                        <input type="text" id="cargueLatitud" name="cargueLatitud" placeholder="Ej: 4.6097">
                    </div>
                    <div class="form-group">
                        <label>Longitud</label>
                        <input type="text" id="cargueLongitud" name="cargueLongitud" placeholder="Ej: -74.0817">
                    </div>
                </div>
            </div>

            <!-- SITIO DESCARGUE -->
            <div class="form-section">
                <h2 class="section-title">Sitio de Descargue</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Tipo Identificación *</label>
                        <select id="descargueTipoId" name="descargueTipoId" required>
                            <option value="">Seleccione...</option>
                            <option value="1">Cédula de Ciudadanía</option>
                            <option value="2">NIT</option>
                            <option value="3">Cédula de Extranjería</option>
                            <option value="4">Tarjeta de Identidad</option>
                            <option value="5">Pasaporte</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Número Identificación *</label>
                        <input type="text" id="descargueNumId" name="descargueNumId" required>
                    </div>
                    <div class="form-group">
                        <label>Sede</label>
                        <select id="sedeDescargue" name="sedeDescargue">
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Código Sede</label>
                        <input type="text" id="codigoSedeDescargue" name="codigoSedeDescargue">
                    </div>
                    <div class="form-group">
                        <label>Nombre *</label>
                        <input type="text" id="descargueNombre" name="descargueNombre" required>
                    </div>
                    <div class="form-group">
                        <label>Dirección *</label>
                        <input type="text" id="descargueDireccion" name="descargueDireccion" required>
                    </div>
                    <div class="form-group">
                        <label>Municipio *</label>
                        <select id="descargueMunicipio" name="descargueMunicipio" required>
                            <option value="">Seleccione...</option>
                            <option value="1">Bogotá D.C.</option>
                            <option value="2">Medellín</option>
                            <option value="3">Cali</option>
                            <option value="4">Barranquilla</option>
                            <option value="5">Cartagena</option>
                            <option value="6">Bucaramanga</option>
                            <option value="7">Pereira</option>
                            <option value="8">Santa Marta</option>
                            <option value="9">Manizales</option>
                            <option value="10">Ibagué</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Fecha Cita *</label>
                        <input type="date" id="descargueFecha" name="descargueFecha" required>
                    </div>
                    <div class="form-group">
                        <label>Hora Cita *</label>
                        <input type="time" id="descargueHora" name="descargueHora" required>
                    </div>
                    <div class="form-group">
                        <label>Tiempo Descargue (Horas) *</label>
                        <input type="number" id="descargueTiempoHoras" name="descargueTiempoHoras" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Tiempo Descargue (Minutos)</label>
                        <input type="number" id="descargueTiempoMin" name="descargueTiempoMin" min="0" max="59">
                    </div>
                    <div class="form-group">
                        <label>Latitud</label>
                        <input type="text" id="descargueLatitud" name="descargueLatitud" placeholder="Ej: 4.6097">
                    </div>
                    <div class="form-group">
                        <label>Longitud</label>
                        <input type="text" id="descargueLongitud" name="descargueLongitud" placeholder="Ej: -74.0817">
                    </div>
                </div>
            </div>

            <!-- PRODUCTO MERCANCÍA -->
            <div class="form-section">
                <h2 class="section-title">Producto - Mercancía</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Naturaleza Carga *</label>
                        <select id="naturalezaCarga" name="naturalezaCarga" required>
                            <option value="">Seleccione...</option>
                            <option value="General">General</option>
                            <option value="Peligrosa">Peligrosa</option>
                            <option value="Perecedera">Perecedera</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Código Producto *</label>
                        <input type="text" id="codigoProducto" name="codigoProducto" required>
                    </div>
                    <div class="form-group">
                        <label>Capítulo *</label>
                        <select id="capitulo" name="capitulo">
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Partida *</label>
                        <select id="partida" name="partida">
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Subpartida *</label>
                        <select id="subpartida" name="subpartida">
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Cod.Subpartida</label>
                        <input type="text" id="codSubpartida" name="codSubpartida">
                    </div>
                    <div class="form-group">
                        <label>Código Arancel *</label>
                        <select id="codigoArancel" name="codigoArancel">
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Cod.Arancel</label>
                        <input type="text" id="codArancel" name="codArancel">
                    </div>
                    <div class="form-group">
                        <label>Código UN</label>
                        <input type="text" id="codigoUN" name="codigoUN">
                    </div>
                    <div class="form-group">
                        <label>Estado de Producto</label>
                        <select id="estadoProducto" name="estadoProducto">
                            <option value="">Seleccione...</option>
                            <option value="Nuevo">Nuevo</option>
                            <option value="Usado">Usado</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Grupo de Embalaje Envase *</label>
                        <select id="grupoEmbalajeEnvase" name="grupoEmbalajeEnvase">
                            <option value="">Seleccione...</option>
                            <option value="I">I</option>
                            <option value="II">II</option>
                            <option value="III">III</option>
                        </select>
                    </div>
                    <div class="form-group full-width">
                        <label>Descripción Producto *</label>
                        <textarea id="descripcionProducto" name="descripcionProducto" rows="3" required></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label>Nombre Técnico o Grupo Químico del N.E.P.</label>
                        <textarea id="nombreTecnicoGrupoQuimico" name="nombreTecnicoGrupoQuimico" rows="3"></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label>En ésta casilla se describe el nombre o grupo químico de la sustancia que le aporta el peligro, por tratarse de un NO Especificado en otra Parte</label>
                    </div>
                    <div class="form-group full-width">
                        <label>Descripción Detallada Residuos Peligrosos</label>
                        <textarea id="descripcionDetalladaResiduosPeligrosos" name="descripcionDetalladaResiduosPeligrosos" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Características Peligrosidad</label>
                        <select id="caracteristicasPeligrosidad" name="caracteristicasPeligrosidad">
                            <option value="">Seleccione...</option>
                            <option value="bajo">Bajo</option>
                            <option value="medio">Medio</option>
                            <option value="alto">Alto</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Corrientes de Residuos Peligrosos</label>
                        <select id="corrientesResiduosPeligrosos" name="corrientesResiduosPeligrosos">
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Desagregación</label>
                        <select id="desagregacion" name="desagregacion">
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- EMPAQUE Y CANTIDAD -->
            <div class="form-section">
                <h2 class="section-title">Empaque y Cantidad del Producto</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Unidad Medida del Producto *</label>
                        <select id="unidadMedidaProducto" name="unidadMedidaProducto" required>
                            <option value="">Seleccione...</option>
                            <option value="1">Kilogramo (KG)</option>
                            <option value="2">Tonelada (TON)</option>
                            <option value="3">Libra (LB)</option>
                            <option value="4">Galón (GAL)</option>
                            <option value="5">Litro (LT)</option>
                            <option value="6">Metro Cúbico (M3)</option>
                            <option value="7">Unidad (UND)</option>
                            <option value="8">Caja (CAJ)</option>
                            <option value="9">Bulto (BLT)</option>
                            <option value="10">Estiba (EST)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Cantidad *</label>
                        <input type="number" id="cantidadProducto" name="cantidadProducto" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label>Unidad Medida Transporte *</label>
                        <select id="unidadMedidaTransporte" name="unidadMedidaTransporte" required>
                            <option value="">Seleccione...</option>
                            <option value="1">Kilogramo (KG)</option>
                            <option value="2">Tonelada (TON)</option>
                            <option value="3">Libra (LB)</option>
                            <option value="4">Galón (GAL)</option>
                            <option value="5">Litro (LT)</option>
                            <option value="6">Metro Cúbico (M3)</option>
                            <option value="7">Unidad (UND)</option>
                            <option value="8">Caja (CAJ)</option>
                            <option value="9">Bulto (BLT)</option>
                            <option value="10">Estiba (EST)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Cantidad *</label>
                        <input type="number" id="cantidadTransporte" name="cantidadTransporte" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label>Empaque Primario o Interno *</label>
                        <select id="empaquePrimario" name="empaquePrimario" required>
                            <option value="">Seleccione...</option>
                            <option value="Caja">Caja</option>
                            <option value="Saco">Saco</option>
                            <option value="Bulto">Bulto</option>
                            <option value="Estiba">Estiba</option>
                            <option value="Tambor">Tambor</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Material *</label>
                        <select id="materialPrimario" name="materialPrimario" required>
                            <option value="">Seleccione...</option>
                            <option value="Cartón">Cartón</option>
                            <option value="Plástico">Plástico</option>
                            <option value="Madera">Madera</option>
                            <option value="Metal">Metal</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Código</label>
                        <input type="text" id="codigoPrimario" name="codigoPrimario">
                    </div>
                    <div class="form-group">
                        <label>Empaque Externo</label>
                        <select id="empaqueExterno" name="empaqueExterno">
                            <option value="">Seleccione...</option>
                            <option value="Caja">Caja</option>
                            <option value="Contenedor">Contenedor</option>
                            <option value="Estiba">Estiba</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Material</label>
                        <select id="materialExterno" name="materialExterno">
                            <option value="">Seleccione...</option>
                            <option value="Cartón">Cartón</option>
                            <option value="Plástico">Plástico</option>
                            <option value="Madera">Madera</option>
                            <option value="Metal">Metal</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Código</label>
                        <input type="text" id="codigoExterno" name="codigoExterno">
                    </div>
                    <div class="form-group">
                        <label>Peso Contenedor Vacío</label>
                        <input type="number" id="pesoContenedorVacio" name="pesoContenedorVacio" step="0.01">
                    </div>
                    <div class="form-group">
                        <label>Kilos</label>
                        <input type="number" id="kilosContenedorVacio" name="kilosContenedorVacio" step="0.01">
                    </div>
                </div>
            </div>

            <!-- SEGURO MERCANCÍA -->
            <div class="form-section">
                <h2 class="section-title">Seguro de Mercancía</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Tipo Póliza *</label>
                        <input type="text" id="tipoPolizaGeneral" name="tipoPolizaGeneral"  required>
                    </div>
                    <div class="form-group">
                        <label>Tomador de la póliza *</label>
                        <select id="tomadorPolizaGeneral" name="tomadorPolizaGeneral" required>
                            <option value="">Seleccione...</option>
                            <option value="Empresa Transportadora">Empresa Transportadora</option>
                            <option value="Remitente">Remitente</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Número *</label>
                        <input type="text" id="numeroPolizaGeneral" name="numeroPolizaGeneral"  required>
                    </div>
                    <div class="form-group">
                        <label>Fecha Vencimiento *</label>
                        <input type="date" id="fechaVencimientoGeneral" name="fechaVencimientoGeneral"  required>
                    </div>
                    <div class="form-group">
                        <label>Aseguradora *</label>
                        <select id="aseguradoraGeneral" name="aseguradoraGeneral" required>
                            <option value="">Seleccione...</option>
                            <option value="1">SEGUROS COMERCIALES S.A.</option>
                            <option value="2">SEGUROS BOLIVAR S.A.</option>
                            <option value="3">SURA S.A.</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>NIT Aseguradora *</label>
                        <input type="text" id="nitAseguradoraGeneral" name="nitAseguradoraGeneral" value="8600021807" required>
                    </div>
                    <div class="form-group">
                        <label>Tipo Póliza *</label>
                        <input type="text" id="tipoPolizaPeligrosa" name="tipoPolizaPeligrosa"  required>
                    </div>
                    <div class="form-group">
                        <label>Tomador de la póliza *</label>
                        <select id="tomadorPolizaPeligrosa" name="tomadorPolizaPeligrosa" required>
                            <option value="">Seleccione...</option>
                            <option value="Empresa Transportadora">Empresa Transportadora</option>
                            <option value="Remitente">Remitente</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Número *</label>
                        <input type="text" id="numeroPolizaPeligrosa" name="numeroPolizaPeligrosa"  required>
                    </div>
                    <div class="form-group">
                        <label>Fecha Vencimiento *</label>
                        <input type="date" id="fechaVencimientoPeligrosa"  required>
        </div>

        <div class="form-group">
            <label>Aseguradora *</label>
            <select name="aseguradoraPeligrosa" required>
                            <option value="">Seleccione...</option>
                            <option value="1">SEGUROS COMERCIALES S.A.</option>
                            <option value="2">SEGUROS BOLIVAR S.A.</option>
                            <option value="3">SURA S.A.</option>
            </select>
        </div>

        <div class="form-group">
            <label>NIT Aseguradora *</label>
            <input type="text" name="nitAseguradoraPeligrosa"  required>
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
            
            
                        <select id="municipioTransbordo1" name="municipioTransbordo1" required>
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
            <label>Codigo 1</label>
            <input type="text" name="codigoMunicipioTransbordo1" id="codigoMunicipioTransbordo1">
        </div>

        <!-- Transbordo 2 -->
        <div class="form-group">
            <label>Municipio Transbordo 2</label>
            <select id="municipioTransbordo2" name="municipioTransbordo2" required>
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
            <label>Codigo 2</label>
            <input type="text" name="codigoMunicipioTransbordo2" id="codigoMunicipioTransbordo2">
        </div>

    </div>
</div>


            <!-- OBSERVACIONES -->
            <div class="form-section">
                <h2 class="section-title">Observaciones</h2>
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label>Observaciones Adicionales</label>
                        <textarea name="observaciones" id="observaciones" rows="4" placeholder="Ingrese observaciones adicionales sobre la remesa..."></textarea>
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