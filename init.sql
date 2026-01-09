-- =============================
);


-- =============================
-- CATALOGOS
-- =============================
CREATE TABLE municipios (
id_municipio INT AUTO_INCREMENT PRIMARY KEY,
nombre VARCHAR(150) NOT NULL,
departamento VARCHAR(150),
codigo_dane VARCHAR(20) UNIQUE
);


CREATE TABLE unidades_medida (
id_unidad INT AUTO_INCREMENT PRIMARY KEY,
nombre VARCHAR(50) NOT NULL
);


CREATE TABLE tipos_identificacion (
id_tipo INT AUTO_INCREMENT PRIMARY KEY,
nombre VARCHAR(50) NOT NULL
);


-- =============================
-- REMESAS
-- =============================
CREATE TABLE remesas (
id_remesa INT AUTO_INCREMENT PRIMARY KEY,
consecutivo VARCHAR(50) NOT NULL UNIQUE,
orden_servicio VARCHAR(50),
id_empresa_generadora INT NOT NULL,
id_usuario INT NOT NULL,
fecha_expedicion DATE,
tipo_operacion VARCHAR(50),
tipo_empaque VARCHAR(50),
observaciones TEXT,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (id_empresa_generadora) REFERENCES empresas(id_empresa),
FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);


CREATE TABLE sitios_remesa (
id_sitio INT AUTO_INCREMENT PRIMARY KEY,
id_remesa INT NOT NULL,
tipo ENUM('CARGUE','DESCARGUE') NOT NULL,
id_municipio INT NOT NULL,
direccion VARCHAR(200),
latitud DECIMAL(10,7),
longitud DECIMAL(10,7),
fecha_cita DATE,
hora_inicio TIME,
hora_fin TIME,
FOREIGN KEY (id_remesa) REFERENCES remesas(id_remesa),
FOREIGN KEY (id_municipio) REFERENCES municipios(id_municipio)
);


CREATE TABLE productos_remesa (
id_producto INT AUTO_INCREMENT PRIMARY KEY,
id_remesa INT NOT NULL,
codigo_producto VARCHAR(50),
descripcion VARCHAR(255),
naturaleza_carga VARCHAR(100),
codigo_un VARCHAR(50),
codigo_arancel VARCHAR(50),
cantidad DECIMAL(12,2),
id_unidad INT,
peso DECIMAL(12,2),
FOREIGN KEY (id_remesa) REFERENCES remesas(id_remesa),
FOREIGN KEY (id_unidad) REFERENCES unidades_medida(id_unidad)
);


CREATE TABLE seguros_remesa (
id_seguro INT AUTO_INCREMENT PRIMARY KEY,
id_remesa INT NOT NULL,
aseguradora VARCHAR(150),
nit_aseguradora VARCHAR(20),
numero_poliza VARCHAR(50),
fecha_vencimiento DATE,
tipo_poliza VARCHAR(150),
FOREIGN KEY (id_remesa) REFERENCES remesas(id_remesa)
);


CREATE TABLE trasbordos_remesa (
id_trasbordo INT AUTO_INCREMENT PRIMARY KEY,
id_remesa INT NOT NULL,
id_municipio INT NOT NULL,
orden INT,
FOREIGN KEY (id_remesa) REFERENCES remesas(id_remesa),
FOREIGN KEY (id_municipio) REFERENCES municipios(id_municipio)
);


-- =============================
-- MANIFIESTOS
-- =============================
CREATE TABLE manifiestos (
id_manifiesto INT AUTO_INCREMENT PRIMARY KEY,
consecutivo VARCHAR(50) NOT NULL UNIQUE,
id_empresa INT NOT NULL,
id_usuario INT NOT NULL,
fecha_expedicion DATE,
municipio_origen INT,
municipio_destino INT,
via_utilizada VARCHAR(150),
tipo_manifiesto VARCHAR(50),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (id_empresa) REFERENCES empresas(id_empresa),
FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);


CREATE TABLE vehiculos (
id_vehiculo INT AUTO_INCREMENT PRIMARY KEY,
placa VARCHAR(20) NOT NULL UNIQUE,
configuracion VARCHAR(50),
peso_vacio DECIMAL(12,2),
soat VARCHAR(50),
vencimiento_soat DATE
);


CREATE TABLE manifiesto_vehiculo (
id_manifiesto INT NOT NULL,
id_vehiculo INT NOT NULL,
PRIMARY KEY (id_manifiesto, id_vehiculo),
FOREIGN KEY (id_manifiesto) REFERENCES manifiestos(id_manifiesto),
FOREIGN KEY (id_vehiculo) REFERENCES vehiculos(id_vehiculo)
);


CREATE TABLE conductores (
id_conductor INT AUTO_INCREMENT PRIMARY KEY,
nombre VARCHAR(150) NOT NULL,id_tipo_identificacion INT,
numero_identificacion VARCHAR(50),
telefono VARCHAR(50),
categoria_licencia VARCHAR(10),
vencimiento_licencia DATE,
FOREIGN KEY (id_tipo_identificacion) REFERENCES tipos_identificacion(id_tipo)
);


CREATE TABLE manifiesto_conductores (
id_manifiesto INT NOT NULL,
id_conductor INT NOT NULL,
orden INT,
PRIMARY KEY (id_manifiesto, id_conductor),
FOREIGN KEY (id_manifiesto) REFERENCES manifiestos(id_manifiesto),
FOREIGN KEY (id_conductor) REFERENCES conductores(id_conductor)
);


CREATE TABLE valores_manifiesto (
id_valor INT AUTO_INCREMENT PRIMARY KEY,
id_manifiesto INT NOT NULL,
valor_viaje DECIMAL(14,2),
valor_vacio_1 DECIMAL(14,2),
valor_vacio_2 DECIMAL(14,2),
retencion_fuente DECIMAL(14,2),
retencion_ica DECIMAL(14,2),
anticipo DECIMAL(14,2),
neto_pagar DECIMAL(14,2),
FOREIGN KEY (id_manifiesto) REFERENCES manifiestos(id_manifiesto)
);


CREATE TABLE manifiesto_remesas (
id_manifiesto INT NOT NULL,
id_remesa INT NOT NULL,
PRIMARY KEY (id_manifiesto, id_remesa),
FOREIGN KEY (id_manifiesto) REFERENCES manifiestos(id_manifiesto),
FOREIGN KEY (id_remesa) REFERENCES remesas(id_remesa)
);