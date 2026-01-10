-- =============================
-- BASE DE DATOS RNDC AJUSTADA
-- =============================
CREATE DATABASE IF NOT EXISTS rndc_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE rndc_db;

-- =============================
-- USUARIOS
-- =============================
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    rol ENUM('ADMIN','OPERADOR','CONSULTA') DEFAULT 'OPERADOR',
    activo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =============================
-- EMPRESAS
-- =============================
CREATE TABLE empresas (
    id_empresa INT AUTO_INCREMENT PRIMARY KEY,
    razon_social VARCHAR(200) NOT NULL,
    nit VARCHAR(20) NOT NULL UNIQUE,
    email VARCHAR(150),
    telefono VARCHAR(50),
    direccion VARCHAR(200),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =============================
-- SEDES DE EMPRESAS
-- =============================
CREATE TABLE sedes_empresa (
    id_sede INT AUTO_INCREMENT PRIMARY KEY,
    id_empresa INT NOT NULL,
    codigo_sede VARCHAR(50),
    nombre_sede VARCHAR(200),
    direccion VARCHAR(200),
    id_municipio INT,
    telefono VARCHAR(50),
    activo BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (id_empresa) REFERENCES empresas(id_empresa)
);

-- =============================
-- CATÁLOGOS
-- =============================
CREATE TABLE municipios (
    id_municipio INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    departamento VARCHAR(150),
    codigo_dane VARCHAR(20) UNIQUE
);

CREATE TABLE unidades_medida (
    id_unidad INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(20) NOT NULL UNIQUE,
    nombre VARCHAR(50) NOT NULL,
    tipo ENUM('PESO','VOLUMEN','UNIDAD') DEFAULT 'UNIDAD'
);

CREATE TABLE tipos_identificacion (
    id_tipo INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(10) NOT NULL UNIQUE,
    nombre VARCHAR(50) NOT NULL
);

CREATE TABLE tipos_empaque (
    id_tipo_empaque INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(20),
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT
);

CREATE TABLE materiales_empaque (
    id_material INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(20),
    nombre VARCHAR(100) NOT NULL
);

CREATE TABLE naturalezas_carga (
    id_naturaleza INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(20),
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT
);

-- =============================
-- ASEGURADORAS
-- =============================
CREATE TABLE aseguradoras (
    id_aseguradora INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    nit VARCHAR(20) NOT NULL UNIQUE,
    telefono VARCHAR(50),
    email VARCHAR(150)
);

-- =============================
-- REMESAS
-- =============================
CREATE TABLE remesas (
    id_remesa INT AUTO_INCREMENT PRIMARY KEY,
    consecutivo VARCHAR(50) NOT NULL UNIQUE,
    consecutivo_info_carga VARCHAR(50),
    consecutivo_remesa_copia VARCHAR(50),
    orden_servicio VARCHAR(50),
    
    -- Empresa generadora
    id_empresa_generadora INT NOT NULL,
    id_usuario INT NOT NULL,
    
    -- Propietario/Generador de carga
    propietario_tipo_id INT,
    propietario_num_id VARCHAR(50),
    propietario_nombre VARCHAR(200),
    propietario_municipio INT,
    propietario_sede VARCHAR(100),
    
    -- Datos generales
    fecha_expedicion DATE,
    tipo_operacion VARCHAR(50),
    tipo_empaque VARCHAR(50),
    
    -- Observaciones
    observaciones TEXT,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (id_empresa_generadora) REFERENCES empresas(id_empresa),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (propietario_tipo_id) REFERENCES tipos_identificacion(id_tipo),
    FOREIGN KEY (propietario_municipio) REFERENCES municipios(id_municipio)
);

-- =============================
-- SITIOS DE CARGUE Y DESCARGUE
-- =============================
CREATE TABLE sitios_remesa (
    id_sitio INT AUTO_INCREMENT PRIMARY KEY,
    id_remesa INT NOT NULL,
    tipo ENUM('CARGUE','DESCARGUE') NOT NULL,
    
    -- Identificación del sitio
    tipo_identificacion INT,
    numero_identificacion VARCHAR(50),
    sede VARCHAR(100),
    codigo_sede VARCHAR(50),
    nombre VARCHAR(200),
    
    -- Ubicación
    direccion VARCHAR(200),
    id_municipio INT NOT NULL,
    latitud DECIMAL(10,7),
    longitud DECIMAL(10,7),
    
    -- Cita y tiempos
    fecha_cita DATE,
    hora_cita TIME,
    tiempo_horas INT,
    tiempo_minutos INT,
    
    FOREIGN KEY (id_remesa) REFERENCES remesas(id_remesa) ON DELETE CASCADE,
    FOREIGN KEY (id_municipio) REFERENCES municipios(id_municipio),
    FOREIGN KEY (tipo_identificacion) REFERENCES tipos_identificacion(id_tipo)
);

-- =============================
-- PRODUCTOS DE LA REMESA
-- =============================
CREATE TABLE productos_remesa (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    id_remesa INT NOT NULL,
    
    -- Identificación del producto
    codigo_producto VARCHAR(50),
    descripcion TEXT,
    
    -- Naturaleza y clasificación
    naturaleza_carga VARCHAR(100),
    codigo_un VARCHAR(50),
    capitulo VARCHAR(50),
    partida VARCHAR(50),
    subpartida VARCHAR(50),
    codigo_subpartida VARCHAR(50),
    codigo_arancel VARCHAR(50),
    cod_arancel VARCHAR(50),
    
    -- Estado y características
    estado_producto VARCHAR(50),
    grupo_embalaje_envase VARCHAR(100),
    nombre_tecnico_quimico TEXT,
    descripcion_residuos_peligrosos TEXT,
    caracteristicas_peligrosidad VARCHAR(100),
    corrientes_residuos_peligrosos VARCHAR(100),
    desagregacion VARCHAR(100),
    
    -- Cantidades
    unidad_medida_producto INT,
    cantidad_producto DECIMAL(12,2),
    unidad_medida_transporte INT,
    cantidad_transporte DECIMAL(12,2),
    
    -- Empaque primario
    empaque_primario VARCHAR(100),
    material_primario VARCHAR(100),
    codigo_primario VARCHAR(50),
    
    -- Empaque externo
    empaque_externo VARCHAR(100),
    material_externo VARCHAR(100),
    codigo_externo VARCHAR(50),
    
    -- Peso contenedor
    peso_contenedor_vacio DECIMAL(12,2),
    kilos_contenedor_vacio DECIMAL(12,2),
    
    FOREIGN KEY (id_remesa) REFERENCES remesas(id_remesa) ON DELETE CASCADE,
    FOREIGN KEY (unidad_medida_producto) REFERENCES unidades_medida(id_unidad),
    FOREIGN KEY (unidad_medida_transporte) REFERENCES unidades_medida(id_unidad)
);

-- =============================
-- SEGUROS DE LA REMESA
-- =============================
CREATE TABLE seguros_remesa (
    id_seguro INT AUTO_INCREMENT PRIMARY KEY,
    id_remesa INT NOT NULL,
    tipo_poliza VARCHAR(20), -- 'Gen' o 'Pelig'
    tomador_poliza VARCHAR(100),
    numero_poliza VARCHAR(50),
    fecha_vencimiento DATE,
    id_aseguradora INT,
    nit_aseguradora VARCHAR(20),
    
    FOREIGN KEY (id_remesa) REFERENCES remesas(id_remesa) ON DELETE CASCADE,
    FOREIGN KEY (id_aseguradora) REFERENCES aseguradoras(id_aseguradora)
);

-- =============================
-- TRANSBORDOS DE LA REMESA
-- =============================
CREATE TABLE trasbordos_remesa (
    id_trasbordo INT AUTO_INCREMENT PRIMARY KEY,
    id_remesa INT NOT NULL,
    id_municipio INT NOT NULL,
    codigo_municipio VARCHAR(20),
    orden INT,
    
    FOREIGN KEY (id_remesa) REFERENCES remesas(id_remesa) ON DELETE CASCADE,
    FOREIGN KEY (id_municipio) REFERENCES municipios(id_municipio)
);

-- =============================
-- MANIFIESTOS
-- =============================
CREATE TABLE manifiestos (
    id_manifiesto INT AUTO_INCREMENT PRIMARY KEY,
    consecutivo VARCHAR(50) NOT NULL UNIQUE,
    
    -- Empresa y usuario
    id_empresa INT NOT NULL,
    id_usuario INT NOT NULL,
    
    -- Información preliminar
    informacion_viaje VARCHAR(200),
    radicado_viaje_consolidado VARCHAR(100),
    manifiesto_anterior VARCHAR(100),
    
    -- Características generales
    tipo_manifiesto VARCHAR(50),
    fecha_expedicion DATE,
    viajes_dia INT DEFAULT 1,
    
    -- Origen y destino
    municipio_origen INT,
    codigo_municipio_origen VARCHAR(20),
    municipio_destino INT,
    codigo_municipio_destino VARCHAR(20),
    municipio_intermedio INT,
    codigo_municipio_intermedio VARCHAR(20),
    
    via_utilizada VARCHAR(150),
    
    -- Recorridos vacíos
    municipio_origen_vacio1 INT,
    codigo_municipio_origen_vacio1 VARCHAR(20),
    municipio_destino_vacio1 INT,
    codigo_municipio_destino_vacio1 VARCHAR(20),
    
    municipio_origen_vacio2 INT,
    codigo_municipio_origen_vacio2 VARCHAR(20),
    municipio_destino_vacio2 INT,
    codigo_municipio_destino_vacio2 VARCHAR(20),
    
    -- Titular del manifiesto
    titular_tipo_identificacion INT,
    titular_numero_identificacion VARCHAR(50),
    titular_sede VARCHAR(100),
    titular_nombre VARCHAR(200),
    titular_direccion VARCHAR(200),
    titular_municipio INT,
    titular_telefono VARCHAR(50),
    
    -- Datos de control
    firma_electronica BOOLEAN DEFAULT TRUE,
    empresa_monitoreo VARCHAR(200),
    
    -- Tiempos y valores de remesas
    cantidad_remesas INT,
    kilogramos_total DECIMAL(12,2),
    galones_total DECIMAL(12,2),
    tiempo_cargue_horas INT,
    tiempo_cargue_minutos INT,
    tiempo_descargue_horas INT,
    tiempo_descargue_minutos INT,
    
    -- Recomendaciones
    recomendaciones TEXT,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (id_empresa) REFERENCES empresas(id_empresa),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (municipio_origen) REFERENCES municipios(id_municipio),
    FOREIGN KEY (municipio_destino) REFERENCES municipios(id_municipio),
    FOREIGN KEY (titular_tipo_identificacion) REFERENCES tipos_identificacion(id_tipo)
);

-- =============================
-- VEHÍCULOS
-- =============================
CREATE TABLE vehiculos (
    id_vehiculo INT AUTO_INCREMENT PRIMARY KEY,
    placa VARCHAR(20) NOT NULL UNIQUE,
    configuracion VARCHAR(50),
    codigo_configuracion VARCHAR(20),
    peso_vacio DECIMAL(12,2),
    
    -- SOAT
    poliza_soat VARCHAR(50),
    vencimiento_soat DATE,
    id_aseguradora_soat INT,
    
    -- Tenedor
    tenedor_nombre VARCHAR(200),
    tenedor_identificacion VARCHAR(50),
    
    activo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (id_aseguradora_soat) REFERENCES aseguradoras(id_aseguradora)
);

-- =============================
-- REMOLQUES
-- =============================
CREATE TABLE remolques (
    id_remolque INT AUTO_INCREMENT PRIMARY KEY,
    placa VARCHAR(20) NOT NULL UNIQUE,
    configuracion VARCHAR(50),
    peso_vacio DECIMAL(12,2),
    activo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =============================
-- VEHÍCULOS DEL MANIFIESTO
-- =============================
CREATE TABLE manifiesto_vehiculo (
    id_manifiesto_vehiculo INT AUTO_INCREMENT PRIMARY KEY,
    id_manifiesto INT NOT NULL,
    id_vehiculo INT NOT NULL,
    
    -- Remolque si aplica
    id_remolque1 INT,
    configuracion_resultante VARCHAR(50),
    codigo_configuracion_resultante VARCHAR(20),
    
    FOREIGN KEY (id_manifiesto) REFERENCES manifiestos(id_manifiesto) ON DELETE CASCADE,
    FOREIGN KEY (id_vehiculo) REFERENCES vehiculos(id_vehiculo),
    FOREIGN KEY (id_remolque1) REFERENCES remolques(id_remolque),
    UNIQUE KEY unique_manifiesto_vehiculo (id_manifiesto, id_vehiculo)
);

-- =============================
-- CONDUCTORES
-- =============================
CREATE TABLE conductores (
    id_conductor INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    id_tipo_identificacion INT,
    numero_identificacion VARCHAR(50) UNIQUE,
    telefono VARCHAR(50),
    municipio INT,
    categoria_licencia VARCHAR(10),
    numero_licencia VARCHAR(50),
    vencimiento_licencia DATE,
    activo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (id_tipo_identificacion) REFERENCES tipos_identificacion(id_tipo),
    FOREIGN KEY (municipio) REFERENCES municipios(id_municipio)
);

-- =============================
-- CONDUCTORES DEL MANIFIESTO
-- =============================
CREATE TABLE manifiesto_conductores (
    id_manifiesto INT NOT NULL,
    id_conductor INT NOT NULL,
    orden INT DEFAULT 1, -- 1 para conductor principal, 2 para segundo conductor
    
    PRIMARY KEY (id_manifiesto, id_conductor),
    FOREIGN KEY (id_manifiesto) REFERENCES manifiestos(id_manifiesto) ON DELETE CASCADE,
    FOREIGN KEY (id_conductor) REFERENCES conductores(id_conductor)
);

-- =============================
-- VALORES DEL MANIFIESTO
-- =============================
CREATE TABLE valores_manifiesto (
    id_valor INT AUTO_INCREMENT PRIMARY KEY,
    id_manifiesto INT NOT NULL,
    
    -- Valores
    valor_viaje DECIMAL(14,2),
    valor_vacio_1 DECIMAL(14,2),
    valor_vacio_2 DECIMAL(14,2),
    
    -- Retenciones
    retencion_fuente DECIMAL(14,2),
    retencion_ica_porcentaje DECIMAL(5,2),
    retencion_ica_valor DECIMAL(14,2),
    
    -- Pagos
    anticipo DECIMAL(14,2),
    neto_pagar DECIMAL(14,2),
    saldo_pagar DECIMAL(14,2),
    
    -- Información del pago
    lugar_pago VARCHAR(200),
    fecha_pago DATE,
    responsable_pago VARCHAR(200),
    
    -- Cargue y descargue
    incluye_cargue BOOLEAN DEFAULT FALSE,
    incluye_descargue BOOLEAN DEFAULT FALSE,
    
    FOREIGN KEY (id_manifiesto) REFERENCES manifiestos(id_manifiesto) ON DELETE CASCADE
);

-- =============================
-- RELACIÓN MANIFIESTO-REMESAS
-- =============================
CREATE TABLE manifiesto_remesas (
    id_manifiesto_remesa INT AUTO_INCREMENT PRIMARY KEY,
    id_manifiesto INT NOT NULL,
    id_remesa INT NOT NULL,
    
    -- Tiempos pactados específicos para esta remesa en este manifiesto
    horas_pacto_cargue INT,
    minutos_pacto_cargue INT,
    horas_pacto_descargue INT,
    minutos_pacto_descargue INT,
    
    orden INT, -- Orden de cargue/descargue
    
    FOREIGN KEY (id_manifiesto) REFERENCES manifiestos(id_manifiesto) ON DELETE CASCADE,
    FOREIGN KEY (id_remesa) REFERENCES remesas(id_remesa),
    UNIQUE KEY unique_manifiesto_remesa (id_manifiesto, id_remesa)
);

-- =============================
-- ÍNDICES PARA MEJORAR CONSULTAS
-- =============================

-- Índices en remesas
CREATE INDEX idx_remesas_consecutivo ON remesas(consecutivo);
CREATE INDEX idx_remesas_fecha ON remesas(fecha_expedicion);
CREATE INDEX idx_remesas_empresa ON remesas(id_empresa_generadora);

-- Índices en manifiestos
CREATE INDEX idx_manifiestos_consecutivo ON manifiestos(consecutivo);
CREATE INDEX idx_manifiestos_fecha ON manifiestos(fecha_expedicion);
CREATE INDEX idx_manifiestos_empresa ON manifiestos(id_empresa);

-- Índices en vehículos
CREATE INDEX idx_vehiculos_placa ON vehiculos(placa);

-- Índices en conductores
CREATE INDEX idx_conductores_identificacion ON conductores(numero_identificacion);

-- =============================
-- VISTAS ÚTILES PARA CONSULTAS
-- =============================

-- Vista completa de remesas con sitios
CREATE VIEW v_remesas_completas AS
SELECT 
    r.*,
    e.razon_social as empresa_nombre,
    u.nombre as usuario_nombre,
    ti.nombre as propietario_tipo_id_nombre,
    m_prop.nombre as propietario_municipio_nombre,
    sc.direccion as cargue_direccion,
    mc.nombre as cargue_municipio,
    sd.direccion as descargue_direccion,
    md.nombre as descargue_municipio
FROM remesas r
LEFT JOIN empresas e ON r.id_empresa_generadora = e.id_empresa
LEFT JOIN usuarios u ON r.id_usuario = u.id_usuario
LEFT JOIN tipos_identificacion ti ON r.propietario_tipo_id = ti.id_tipo
LEFT JOIN municipios m_prop ON r.propietario_municipio = m_prop.id_municipio
LEFT JOIN sitios_remesa sc ON r.id_remesa = sc.id_remesa AND sc.tipo = 'CARGUE'
LEFT JOIN municipios mc ON sc.id_municipio = mc.id_municipio
LEFT JOIN sitios_remesa sd ON r.id_remesa = sd.id_remesa AND sd.tipo = 'DESCARGUE'
LEFT JOIN municipios md ON sd.id_municipio = md.id_municipio;

-- Vista completa de manifiestos
CREATE VIEW v_manifiestos_completos AS
SELECT 
    m.*,
    e.razon_social as empresa_nombre,
    u.nombre as usuario_nombre,
    mo.nombre as municipio_origen_nombre,
    md.nombre as municipio_destino_nombre,
    v.valor_viaje,
    v.neto_pagar,
    COUNT(DISTINCT mr.id_remesa) as total_remesas,
    COUNT(DISTINCT mc.id_conductor) as total_conductores
FROM manifiestos m
LEFT JOIN empresas e ON m.id_empresa = e.id_empresa
LEFT JOIN usuarios u ON m.id_usuario = u.id_usuario
LEFT JOIN municipios mo ON m.municipio_origen = mo.id_municipio
LEFT JOIN municipios md ON m.municipio_destino = md.id_municipio
LEFT JOIN valores_manifiesto v ON m.id_manifiesto = v.id_manifiesto
LEFT JOIN manifiesto_remesas mr ON m.id_manifiesto = mr.id_manifiesto
LEFT JOIN manifiesto_conductores mc ON m.id_manifiesto = mc.id_manifiesto
GROUP BY m.id_manifiesto;