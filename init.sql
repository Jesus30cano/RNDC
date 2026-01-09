CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    rol ENUM('ADMIN', 'OPERADOR', 'CONSULTA') DEFAULT 'OPERADOR',
    estado BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE empresas (
    id_empresa INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    nit VARCHAR(20) NOT NULL UNIQUE,
    direccion VARCHAR(200),
    municipio VARCHAR(100),
    telefono VARCHAR(30),
    email VARCHAR(100)
);

CREATE TABLE conductores (
    id_conductor INT AUTO_INCREMENT PRIMARY KEY,
    tipo_identificacion VARCHAR(20),
    numero_identificacion VARCHAR(30) UNIQUE,
    nombre VARCHAR(150),
    telefono VARCHAR(30),
    categoria_licencia VARCHAR(10),
    vencimiento_licencia DATE
);

CREATE TABLE vehiculos (
    id_vehiculo INT AUTO_INCREMENT PRIMARY KEY,
    placa VARCHAR(10) UNIQUE,
    configuracion VARCHAR(50),
    peso_vacio DECIMAL(10,2),
    tenedor VARCHAR(150),
    soat VARCHAR(50),
    vencimiento_soat DATE,
    aseguradora VARCHAR(100)
);
 
CREATE TABLE manifiestos (
    id_manifiesto INT AUTO_INCREMENT PRIMARY KEY,
    consecutivo VARCHAR(30) UNIQUE,
    id_empresa INT,
    fecha_expedicion DATE,
    municipio_origen VARCHAR(100),
    municipio_destino VARCHAR(100),
    via_utilizada VARCHAR(150),
    valor_viaje DECIMAL(12,2),
    retencion_fuente DECIMAL(12,2),
    retencion_ica DECIMAL(12,2),
    neto_pagar DECIMAL(12,2),
    estado ENUM('CREADO', 'CUMPLIDO', 'REVERSADO') DEFAULT 'CREADO',
    creado_por INT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_empresa) REFERENCES empresas(id_empresa),
    FOREIGN KEY (creado_por) REFERENCES usuarios(id_usuario)
);

CREATE TABLE manifiesto_conductores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_manifiesto INT,
    id_conductor INT,

    FOREIGN KEY (id_manifiesto) REFERENCES manifiestos(id_manifiesto),
    FOREIGN KEY (id_conductor) REFERENCES conductores(id_conductor)
);

CREATE TABLE manifiesto_vehiculos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_manifiesto INT,
    id_vehiculo INT,

    FOREIGN KEY (id_manifiesto) REFERENCES manifiestos(id_manifiesto),
    FOREIGN KEY (id_vehiculo) REFERENCES vehiculos(id_vehiculo)
);

CREATE TABLE remesas (
    id_remesa INT AUTO_INCREMENT PRIMARY KEY,
    consecutivo VARCHAR(30) UNIQUE,
    id_empresa INT,
    id_manifiesto INT,
    tipo_operacion VARCHAR(50),
    tipo_empaque VARCHAR(50),
    sitio_cargue VARCHAR(200),
    sitio_descargue VARCHAR(200),
    municipio_cargue VARCHAR(100),
    municipio_descargue VARCHAR(100),
    fecha_cita_cargue DATE,
    fecha_cita_descargue DATE,
    observaciones TEXT,

    FOREIGN KEY (id_empresa) REFERENCES empresas(id_empresa),
    FOREIGN KEY (id_manifiesto) REFERENCES manifiestos(id_manifiesto)
);

CREATE TABLE mercancias (
    id_mercancia INT AUTO_INCREMENT PRIMARY KEY,
    id_remesa INT,
    codigo_producto VARCHAR(50),
    descripcion VARCHAR(255),
    naturaleza_carga VARCHAR(50),
    unidad_medida VARCHAR(20),
    cantidad DECIMAL(12,2),
    peso DECIMAL(12,2),
    peligrosa BOOLEAN DEFAULT FALSE,

    FOREIGN KEY (id_remesa) REFERENCES remesas(id_remesa)
);

CREATE TABLE seguros_mercancia (
    id_seguro INT AUTO_INCREMENT PRIMARY KEY,
    id_remesa INT,
    numero_poliza VARCHAR(50),
    aseguradora VARCHAR(150),
    nit_aseguradora VARCHAR(30),
    fecha_vencimiento DATE,

    FOREIGN KEY (id_remesa) REFERENCES remesas(id_remesa)
);

