
-- =============================
-- DATOS DE PRUEBA PARA RNDC
-- EJECUTAR EN ORDEN ESTRICTO
-- =============================

USE rndc_db;

-- Limpiar datos existentes (CUIDADO: esto borra todo)
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE manifiesto_remesas;
TRUNCATE TABLE valores_manifiesto;
TRUNCATE TABLE manifiesto_conductores;
TRUNCATE TABLE manifiesto_vehiculo;
TRUNCATE TABLE trasbordos_remesa;
TRUNCATE TABLE seguros_remesa;
TRUNCATE TABLE productos_remesa;
TRUNCATE TABLE sitios_remesa;
TRUNCATE TABLE remesas;
TRUNCATE TABLE manifiestos;
TRUNCATE TABLE conductores;
TRUNCATE TABLE remolques;
TRUNCATE TABLE vehiculos;
TRUNCATE TABLE sedes_empresa;
TRUNCATE TABLE empresas;
TRUNCATE TABLE aseguradoras;
TRUNCATE TABLE unidades_medida;
TRUNCATE TABLE municipios;
TRUNCATE TABLE tipos_identificacion;
TRUNCATE TABLE usuarios;
SET FOREIGN_KEY_CHECKS = 1;

-- =============================
-- 1. USUARIOS (SIN DEPENDENCIAS)
-- =============================
INSERT INTO usuarios (id_usuario, nombre, email, password_hash, rol) VALUES
(1, 'Admin Principal', 'admin@rndc.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ADMIN'),
(2, 'Juan Operador', 'operador@rndc.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'OPERADOR');

-- =============================
-- 2. TIPOS DE IDENTIFICACIÓN (SIN DEPENDENCIAS)
-- =============================
INSERT INTO tipos_identificacion (id_tipo, codigo, nombre) VALUES
(1, 'CC', 'Cédula de Ciudadanía'),
(2, 'NIT', 'NIT'),
(3, 'CE', 'Cédula de Extranjería'),
(4, 'TI', 'Tarjeta de Identidad'),
(5, 'PP', 'Pasaporte');

-- =============================
-- 3. MUNICIPIOS (SIN DEPENDENCIAS)
-- =============================
INSERT INTO municipios (id_municipio, nombre, departamento, codigo_dane) VALUES
(1, 'Bogotá D.C.', 'Bogotá D.C.', '11001'),
(2, 'Medellín', 'Antioquia', '05001'),
(3, 'Cali', 'Valle del Cauca', '76001'),
(4, 'Barranquilla', 'Atlántico', '08001'),
(5, 'Cartagena', 'Bolívar', '13001'),
(6, 'Bucaramanga', 'Santander', '68001'),
(7, 'Pereira', 'Risaralda', '66001'),
(8, 'Santa Marta', 'Magdalena', '47001'),
(9, 'Manizales', 'Caldas', '17001'),
(10, 'Ibagué', 'Tolima', '73001');

-- =============================
-- 4. UNIDADES DE MEDIDA (SIN DEPENDENCIAS)
-- =============================
INSERT INTO unidades_medida (id_unidad, codigo, nombre, tipo) VALUES
(1, 'KG', 'Kilogramo', 'PESO'),
(2, 'TON', 'Tonelada', 'PESO'),
(3, 'LB', 'Libra', 'PESO'),
(4, 'GAL', 'Galón', 'VOLUMEN'),
(5, 'LT', 'Litro', 'VOLUMEN'),
(6, 'M3', 'Metro Cúbico', 'VOLUMEN'),
(7, 'UND', 'Unidad', 'UNIDAD'),
(8, 'CAJ', 'Caja', 'UNIDAD'),
(9, 'BLT', 'Bulto', 'UNIDAD'),
(10, 'EST', 'Estiba', 'UNIDAD');

-- =============================
-- 5. ASEGURADORAS (SIN DEPENDENCIAS)
-- =============================
INSERT INTO aseguradoras (id_aseguradora, nombre, nit, telefono, email) VALUES
(1, 'SEGUROS COMERCIALES S.A.', '8600021807', '6013456789', 'contacto@seguroscomerciales.com'),
(2, 'SEGUROS BOLIVAR S.A.', '8600123456', '6013456780', 'info@segurosbolivar.com'),
(3, 'SURA S.A.', '8600234567', '6013456781', 'contacto@sura.com');

-- =============================
-- 6. EMPRESAS
-- =============================
INSERT INTO empresas (id_empresa, razon_social, nit, email, telefono, direccion) VALUES
(1, 'TRANSPORTES QUIROGA S.A.S', '8020099265', 'info@transquiroga.com', '6017654321', 'Calle 100 #15-20'),
(2, 'ALIMENTOS DEL VALLE S.A.', '8901234567', 'ventas@alimentosvalle.com', '6023456789', 'Av. Cañasgordas #30-50'),
(3, 'INDUSTRIAS QUÍMICAS LTDA', '8902345678', 'contacto@indquimicas.com', '6044567891', 'Zona Industrial Km 5');

-- =============================
-- 7. SEDES DE EMPRESAS
-- =============================
INSERT INTO sedes_empresa (id_sede, id_empresa, codigo_sede, nombre_sede, direccion, id_municipio, telefono) VALUES
(1, 1, '0144', 'Sede Principal Bogotá', 'Calle 100 #15-20', 1, '6017654321'),
(2, 1, '0145', 'Sede Medellín', 'Carrera 50 #30-10', 2, '6044567890');

-- =============================
-- 8. VEHÍCULOS
-- =============================
INSERT INTO vehiculos (id_vehiculo, placa, configuracion, codigo_configuracion, peso_vacio, poliza_soat, vencimiento_soat, id_aseguradora_soat, tenedor_nombre, tenedor_identificacion) VALUES
(1, 'ABC123', 'C2', 'C2', 8500.00, 'SOAT123456', '2026-12-31', 1, 'TRANSPORTES QUIROGA S.A.S', '8020099265'),
(2, 'DEF456', 'C3', 'C3', 12000.00, 'SOAT789012', '2026-12-31', 1, 'TRANSPORTES QUIROGA S.A.S', '8020099265');

-- =============================
-- 9. REMOLQUES
-- =============================
INSERT INTO remolques (id_remolque, placa, configuracion, peso_vacio) VALUES
(1, 'REM001', 'SR', 6000.00),
(2, 'REM002', 'SR', 6500.00);

-- =============================
-- 10. CONDUCTORES
-- =============================
INSERT INTO conductores (id_conductor, nombre, id_tipo_identificacion, numero_identificacion, telefono, municipio, categoria_licencia, numero_licencia, vencimiento_licencia) VALUES
(1, 'Carlos Alberto Rodríguez', 1, '80123456', '3101234567', 1, 'C2', 'LIC123456', '2027-06-30'),
(2, 'María Fernanda López', 1, '52987654', '3209876543', 1, 'C3', 'LIC789012', '2027-12-31'),
(3, 'Pedro José Martínez', 1, '79456123', '3156789012', 2, 'C2', 'LIC456789', '2026-08-15');

-- =============================
-- 11. REMESA #1
-- =============================
INSERT INTO remesas (
    id_remesa,
    consecutivo, 
    consecutivo_info_carga,
    orden_servicio,
    id_empresa_generadora,
    id_usuario,
    propietario_tipo_id,
    propietario_num_id,
    propietario_nombre,
    propietario_municipio,
    propietario_sede,
    fecha_expedicion,
    tipo_operacion,
    tipo_empaque,
    observaciones
) VALUES (
    1,
    'REM-2026-001',
    'INFO-001',
    'OS-12345',
    2, -- ALIMENTOS DEL VALLE (debe existir en empresas)
    2, -- Juan Operador (debe existir en usuarios)
    2, -- NIT (debe existir en tipos_identificacion)
    '8901234567',
    'ALIMENTOS DEL VALLE S.A.',
    3, -- Cali (debe existir en municipios)
    'SEDE PRINCIPAL',
    '2026-01-10',
    'General',
    'Estiba',
    'Transporte de alimentos no perecederos'
);

-- Sitio de cargue para remesa #1
INSERT INTO sitios_remesa (
    id_sitio,
    id_remesa,
    tipo,
    tipo_identificacion,
    numero_identificacion,
    sede,
    codigo_sede,
    nombre,
    direccion,
    id_municipio,
    latitud,
    longitud,
    fecha_cita,
    hora_cita,
    tiempo_horas,
    tiempo_minutos
) VALUES (
    1,
    1,
    'CARGUE',
    2, -- NIT
    '8901234567',
    'PLANTA PRINCIPAL',
    'PLT-001',
    'ALIMENTOS DEL VALLE S.A.',
    'Av. Cañasgordas #30-50',
    3, -- Cali
    3.4516500,
    -76.5319900,
    '2026-01-11',
    '08:00:00',
    2,
    30
);

-- Sitio de descargue para remesa #1
INSERT INTO sitios_remesa (
    id_sitio,
    id_remesa,
    tipo,
    tipo_identificacion,
    numero_identificacion,
    sede,
    codigo_sede,
    nombre,
    direccion,
    id_municipio,
    latitud,
    longitud,
    fecha_cita,
    hora_cita,
    tiempo_horas,
    tiempo_minutos
) VALUES (
    2,
    1,
    'DESCARGUE',
    2, -- NIT
    '9001112233',
    'BODEGA NORTE',
    'BOD-045',
    'DISTRIBUIDORA NACIONAL S.A.',
    'Calle 127 #15-20',
    1, -- Bogotá
    4.7109900,
    -74.0721900,
    '2026-01-12',
    '14:00:00',
    2,
    0
);

-- Producto de la remesa #1
INSERT INTO productos_remesa (
    id_producto,
    id_remesa,
    codigo_producto,
    descripcion,
    naturaleza_carga,
    codigo_arancel,
    estado_producto,
    unidad_medida_producto,
    cantidad_producto,
    unidad_medida_transporte,
    cantidad_transporte,
    empaque_primario,
    material_primario,
    empaque_externo,
    material_externo
) VALUES (
    1,
    1,
    'PROD-ALM-001',
    'Galletas empacadas en cajas de cartón',
    'General',
    '19053100',
    'Nuevo',
    1, -- KG
    5000.00,
    2, -- TON
    5.00,
    'Caja',
    'Cartón',
    'Estiba',
    'Madera'
);

-- Seguros de la remesa #1
INSERT INTO seguros_remesa (
    id_seguro,
    id_remesa,
    tipo_poliza,
    tomador_poliza,
    numero_poliza,
    fecha_vencimiento,
    id_aseguradora,
    nit_aseguradora
) VALUES (
    1,
    1,
    'Gen',
    'Empresa Transportadora',
    '1070000035901',
    '2026-06-30',
    1,
    '8600021807'
);

-- =============================
-- 12. REMESA #2
-- =============================
INSERT INTO remesas (
    id_remesa,
    consecutivo,
    orden_servicio,
    id_empresa_generadora,
    id_usuario,
    propietario_tipo_id,
    propietario_num_id,
    propietario_nombre,
    propietario_municipio,
    fecha_expedicion,
    tipo_operacion,
    tipo_empaque,
    observaciones
) VALUES (
    2,
    'REM-2026-002',
    'OS-12346',
    3, -- INDUSTRIAS QUÍMICAS
    2,
    2, -- NIT
    '8902345678',
    'INDUSTRIAS QUÍMICAS LTDA',
    2, -- Medellín
    '2026-01-10',
    'Especial',
    'Tambor',
    'Transporte de productos químicos - CARGA PELIGROSA'
);

-- Sitio de cargue para remesa #2
INSERT INTO sitios_remesa (
    id_sitio,
    id_remesa,
    tipo,
    tipo_identificacion,
    numero_identificacion,
    nombre,
    direccion,
    id_municipio,
    fecha_cita,
    hora_cita,
    tiempo_horas,
    tiempo_minutos
) VALUES (
    3,
    2,
    'CARGUE',
    2,
    '8902345678',
    'INDUSTRIAS QUÍMICAS LTDA',
    'Zona Industrial Km 5',
    2, -- Medellín
    '2026-01-11',
    '10:00:00',
    3,
    0
);

-- Sitio de descargue para remesa #2
INSERT INTO sitios_remesa (
    id_sitio,
    id_remesa,
    tipo,
    tipo_identificacion,
    numero_identificacion,
    nombre,
    direccion,
    id_municipio,
    fecha_cita,
    hora_cita,
    tiempo_horas,
    tiempo_minutos
) VALUES (
    4,
    2,
    'DESCARGUE',
    2,
    '8001122334',
    'QUÍMICA NACIONAL S.A.',
    'Autopista Norte Km 20',
    1, -- Bogotá
    '2026-01-12',
    '16:00:00',
    2,
    30
);

-- Producto de la remesa #2
INSERT INTO productos_remesa (
    id_producto,
    id_remesa,
    codigo_producto,
    descripcion,
    naturaleza_carga,
    codigo_un,
    unidad_medida_producto,
    cantidad_producto,
    unidad_medida_transporte,
    cantidad_transporte,
    empaque_primario,
    material_primario
) VALUES (
    2,
    2,
    'QUIM-001',
    'Solvente industrial en tambores metálicos',
    'Peligrosa',
    'UN1263',
    4, -- GAL
    800.00,
    1, -- KG
    3000.00,
    'Tambor',
    'Metal'
);

-- Seguros de la remesa #2 (incluye póliza de carga peligrosa)
INSERT INTO seguros_remesa (
    id_seguro,
    id_remesa,
    tipo_poliza,
    tomador_poliza,
    numero_poliza,
    fecha_vencimiento,
    id_aseguradora,
    nit_aseguradora
) VALUES 
(2, 2, 'Gen', 'Empresa Transportadora', '1070000035901', '2026-06-30', 1, '8600021807'),
(3, 2, 'Pelig', 'Empresa Transportadora', '1070000035902', '2026-06-30', 1, '8600021807');

-- =============================
-- 13. MANIFIESTO
-- =============================
INSERT INTO manifiestos (
    id_manifiesto,
    consecutivo,
    id_empresa,
    id_usuario,
    informacion_viaje,
    tipo_manifiesto,
    fecha_expedicion,
    viajes_dia,
    municipio_origen,
    municipio_destino,
    via_utilizada,
    titular_tipo_identificacion,
    titular_numero_identificacion,
    titular_nombre,
    titular_direccion,
    titular_municipio,
    titular_telefono,
    firma_electronica,
    cantidad_remesas,
    kilogramos_total,
    tiempo_cargue_horas,
    tiempo_cargue_minutos,
    tiempo_descargue_horas,
    tiempo_descargue_minutos,
    recomendaciones
) VALUES (
    1,
    'MAN-2026-001',
    1, -- TRANSPORTES QUIROGA
    2, -- Juan Operador
    'Viaje Medellín - Bogotá con 2 remesas',
    'Normal',
    '2026-01-11',
    1,
    2, -- Medellín (origen)
    1, -- Bogotá (destino)
    'Ruta Nacional',
    2, -- NIT
    '8020099265',
    'TRANSPORTES QUIROGA S.A.S',
    'Calle 100 #15-20',
    1, -- Bogotá
    '6017654321',
    TRUE,
    2, -- 2 remesas
    8000.00,
    5, -- 5 horas total cargue
    30, -- 30 minutos
    4, -- 4 horas total descargue
    30, -- 30 minutos
    'Conductor debe reportar cada 4 horas. Vía despejada.'
);

-- Vehículo del manifiesto
INSERT INTO manifiesto_vehiculo (
    id_manifiesto_vehiculo,
    id_manifiesto,
    id_vehiculo,
    id_remolque1,
    configuracion_resultante
) VALUES (
    1,
    1, -- Manifiesto
    1, -- Vehículo ABC123
    1, -- Remolque REM001
    'C2-SR'
);

-- Conductores del manifiesto
INSERT INTO manifiesto_conductores (id_manifiesto, id_conductor, orden) VALUES
(1, 1, 1), -- Carlos como conductor principal
(1, 2, 2); -- María como conductora 2

-- Valores del manifiesto
INSERT INTO valores_manifiesto (
    id_valor,
    id_manifiesto,
    valor_viaje,
    valor_vacio_1,
    retencion_fuente,
    retencion_ica_porcentaje,
    retencion_ica_valor,
    anticipo,
    neto_pagar,
    saldo_pagar,
    lugar_pago,
    fecha_pago,
    responsable_pago,
    incluye_cargue,
    incluye_descargue
) VALUES (
    1,
    1,
    4500000.00, -- Valor del viaje
    0.00,
    180000.00, -- 4% retención
    3.50, -- 3.5 por mil
    15750.00, -- Valor ICA
    2000000.00, -- Anticipo
    4304250.00, -- Neto a pagar
    2304250.00, -- Saldo
    'Bogotá',
    '2026-01-15',
    'TRANSPORTES QUIROGA S.A.S',
    TRUE,
    TRUE
);

-- Relacionar las dos remesas con el manifiesto
INSERT INTO manifiesto_remesas (
    id_manifiesto_remesa,
    id_manifiesto,
    id_remesa,
    horas_pacto_cargue,
    minutos_pacto_cargue,
    horas_pacto_descargue,
    minutos_pacto_descargue,
    orden
) VALUES 
(1, 1, 1, 2, 30, 2, 0, 1), -- Remesa 1
(2, 1, 2, 3, 0, 2, 30, 2); -- Remesa 2

-- =============================
-- CONSULTAS DE VERIFICACIÓN
-- =============================

SELECT '==== VERIFICACIÓN DE REMESAS ====' as titulo;
SELECT 
    r.consecutivo,
    r.fecha_expedicion,
    r.propietario_nombre,
    e.razon_social as empresa_transportadora,
    u.nombre as usuario,
    (SELECT COUNT(*) FROM productos_remesa WHERE id_remesa = r.id_remesa) as productos,
    (SELECT COUNT(*) FROM seguros_remesa WHERE id_remesa = r.id_remesa) as seguros
FROM remesas r
JOIN empresas e ON r.id_empresa_generadora = e.id_empresa
JOIN usuarios u ON r.id_usuario = u.id_usuario;

SELECT '==== VERIFICACIÓN DE MANIFIESTO ====' as titulo;
SELECT 
    m.consecutivo,
    m.fecha_expedicion,
    m.tipo_manifiesto,
    e.razon_social as empresa,
    mo.nombre as origen,
    md.nombre as destino,
    v.placa,
    c1.nombre as conductor_principal,
    c2.nombre as conductor_2,
    vm.valor_viaje,
    vm.neto_pagar,
    m.cantidad_remesas
FROM manifiestos m
JOIN empresas e ON m.id_empresa = e.id_empresa
JOIN municipios mo ON m.municipio_origen = mo.id_municipio
JOIN municipios md ON m.municipio_destino = md.id_municipio
JOIN manifiesto_vehiculo mv ON m.id_manifiesto = mv.id_manifiesto
JOIN vehiculos v ON mv.id_vehiculo = v.id_vehiculo
LEFT JOIN manifiesto_conductores mc1 ON m.id_manifiesto = mc1.id_manifiesto AND mc1.orden = 1
LEFT JOIN conductores c1 ON mc1.id_conductor = c1.id_conductor
LEFT JOIN manifiesto_conductores mc2 ON m.id_manifiesto = mc2.id_manifiesto AND mc2.orden = 2
LEFT JOIN conductores c2 ON mc2.id_conductor = c2.id_conductor
LEFT JOIN valores_manifiesto vm ON m.id_manifiesto = vm.id_manifiesto;

SELECT '==== REMESAS DEL MANIFIESTO ====' as titulo;
SELECT 
    m.consecutivo as manifiesto,
    r.consecutivo as remesa,
    r.propietario_nombre,
    mr.horas_pacto_cargue,
    mr.minutos_pacto_cargue,
    mr.horas_pacto_descargue,
    mr.minutos_pacto_descargue,
    mr.orden
FROM manifiestos m
JOIN manifiesto_remesas mr ON m.id_manifiesto = mr.id_manifiesto
JOIN remesas r ON mr.id_remesa = r.id_remesa
ORDER BY m.consecutivo, mr.orden;

SELECT '==== DETALLE SITIOS DE REMESA 1 ====' as titulo;
SELECT 
    r.consecutivo,
    r.propietario_nombre,
    s.tipo,
    s.nombre as sitio_nombre,
    s.direccion,
    mun.nombre as municipio,
    s.fecha_cita,
    s.hora_cita
FROM remesas r
JOIN sitios_remesa s ON r.id_remesa = s.id_remesa
JOIN municipios mun ON s.id_municipio = mun.id_municipio
WHERE r.consecutivo = 'REM-2026-001'
ORDER BY s.tipo;