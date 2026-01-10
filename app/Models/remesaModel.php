<?php
require_once __DIR__ . '/../Config/conexion.php';

class RemesaModel {
    private $pdo;

    public function __construct() {
        $conexion = new Conexion();
        $conexion->getConnection();
        $this->pdo = $conexion->getConexion();
    }

    /**
     * Guarda una remesa completa con todos sus datos relacionados
     */
    public function guardarRemesa($datos) {
        try {
            $this->pdo->beginTransaction();

            // Log para debug
            error_log("🔍 Iniciando guardado de remesa");
            error_log("📋 Datos recibidos: " . print_r($datos, true));

            // 1. Guardar datos principales de la remesa
            $idRemesa = $this->insertarRemesaPrincipal($datos);
            error_log("✅ Remesa principal guardada con ID: " . $idRemesa);

            // 2. Guardar sitio de cargue
            if (!empty($datos['cargueNumId'])) {
                $this->insertarSitioCargue($idRemesa, $datos);
                error_log("✅ Sitio de cargue guardado");
            }

            // 3. Guardar sitio de descargue
            if (!empty($datos['descargueNumId'])) {
                $this->insertarSitioDescargue($idRemesa, $datos);
                error_log("✅ Sitio de descargue guardado");
            }

            // 4. Guardar producto/mercancía
            if (!empty($datos['codigoProducto'])) {
                $this->insertarProducto($idRemesa, $datos);
                error_log("✅ Producto guardado");
            }

            // 5. Guardar seguros
            if (!empty($datos['numeroPolizaGeneral'])) {
                $this->insertarSeguroGeneral($idRemesa, $datos);
                error_log("✅ Seguro general guardado");
            }
            if (!empty($datos['numeroPolizaPeligrosa'])) {
                $this->insertarSeguroPeligrosa($idRemesa, $datos);
                error_log("✅ Seguro peligrosa guardado");
            }
            error_log("========================================================================");

            // 6. Guardar transbordos si existen
            $this->insertarTransbordos($idRemesa, $datos);
            error_log("✅ Transbordos procesados");

            $this->pdo->commit();
            error_log("🎉 Remesa guardada completamente");

            return [
                'success' => true,
                'message' => 'Remesa guardada exitosamente',
                'id_remesa' => $idRemesa,
                'consecutivo' => $datos['consecutivo']
            ];

        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("❌ Error al guardar remesa: " . $e->getMessage());
            error_log("📍 Línea: " . $e->getLine());
            error_log("📂 Archivo: " . $e->getFile());
            error_log("🔍 Stack trace: " . $e->getTraceAsString());
            
            return [
                'success' => false,
                'message' => 'Error al guardar la remesa: ' . $e->getMessage(),
                'error_details' => [
                    'line' => $e->getLine(),
                    'file' => basename($e->getFile())
                ]
            ];
        }
    }

    private function insertarRemesaPrincipal($datos) {
        // Obtener IDs primero y validar
        $idEmpresa = $this->obtenerIdEmpresaPorNit($datos['nitEmpresa']);
        if (!$idEmpresa) {
            throw new Exception("No se encontró la empresa con NIT: " . $datos['nitEmpresa']);
        }

        $idUsuario = $this->obtenerIdUsuarioPorNombre($datos['usuario']);
        if (!$idUsuario) {
            throw new Exception("No se encontró el usuario: " . $datos['usuario']);
        }

        $sql = "INSERT INTO remesas (
            consecutivo,
            consecutivo_info_carga,
            consecutivo_remesa_copia,
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
            :consecutivo,
            :consecutivo_info_carga,
            :consecutivo_remesa_copia,
            :orden_servicio,
            :id_empresa_generadora,
            :id_usuario,
            :propietario_tipo_id,
            :propietario_num_id,
            :propietario_nombre,
            :propietario_municipio,
            :propietario_sede,
            :fecha_expedicion,
            :tipo_operacion,
            :tipo_empaque,
            :observaciones
        )";

        $stmt = $this->pdo->prepare($sql);
        $params = [
            ':consecutivo' => $datos['consecutivo'],
            ':consecutivo_info_carga' => $datos['consecutivoInfoCarga'] ?? null,
            ':consecutivo_remesa_copia' => $datos['consecutivoRemesaCopia'] ?? null,
            ':orden_servicio' => $datos['ordenServicio'] ?? null,
            ':id_empresa_generadora' => $idEmpresa,
            ':id_usuario' => $idUsuario,
            ':propietario_tipo_id' => $datos['propTipoId'] ?? null,
            ':propietario_num_id' => $datos['propNumId'] ?? null,
            ':propietario_nombre' => $datos['propNombre'] ?? null,
            ':propietario_municipio' => $datos['propMunicipio'] ?? null,
            ':propietario_sede' => $datos['propSede'] ?? null,
            ':fecha_expedicion' => date('Y-m-d'),
            ':tipo_operacion' => $datos['tipoOperacion'] ?? null,
            ':tipo_empaque' => $datos['tipoEmpaque'] ?? null,
            ':observaciones' => $datos['observaciones'] ?? null
        ];

        error_log("🔍 Parámetros remesa principal: " . print_r($params, true));
        $stmt->execute($params);

        return $this->pdo->lastInsertId();
    }

    private function insertarSitioCargue($idRemesa, $datos) {
        $sql = "INSERT INTO sitios_remesa (
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
            :id_remesa,
            'CARGUE',
            :tipo_identificacion,
            :numero_identificacion,
            :sede,
            :codigo_sede,
            :nombre,
            :direccion,
            :id_municipio,
            :latitud,
            :longitud,
            :fecha_cita,
            :hora_cita,
            :tiempo_horas,
            :tiempo_minutos
        )";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id_remesa' => $idRemesa,
            ':tipo_identificacion' => $datos['cargueTipoId'] ?? null,
            ':numero_identificacion' => $datos['cargueNumId'],
            ':sede' => $datos['sedeCargue'] ?? null,
            ':codigo_sede' => $datos['codigoSedeCargue'] ?? null,
            ':nombre' => $datos['cargueNombre'],
            ':direccion' => $datos['cargueDireccion'],
            ':id_municipio' => $datos['cargueMunicipio'],
            ':latitud' => $datos['cargueLatitud'] ?? null,
            ':longitud' => $datos['cargueLongitud'] ?? null,
            ':fecha_cita' => $datos['cargueFecha'],
            ':hora_cita' => $datos['cargueHora'],
            ':tiempo_horas' => $datos['cargueTiempoHoras'] ?? 0,
            ':tiempo_minutos' => $datos['cargueTiempoMin'] ?? 0
        ]);
    }

    private function insertarSitioDescargue($idRemesa, $datos) {
        $sql = "INSERT INTO sitios_remesa (
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
            :id_remesa,
            'DESCARGUE',
            :tipo_identificacion,
            :numero_identificacion,
            :sede,
            :codigo_sede,
            :nombre,
            :direccion,
            :id_municipio,
            :latitud,
            :longitud,
            :fecha_cita,
            :hora_cita,
            :tiempo_horas,
            :tiempo_minutos
        )";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id_remesa' => $idRemesa,
            ':tipo_identificacion' => $datos['descargueTipoId'] ?? null,
            ':numero_identificacion' => $datos['descargueNumId'],
            ':sede' => $datos['sedeDescargue'] ?? null,
            ':codigo_sede' => $datos['codigoSedeDescargue'] ?? null,
            ':nombre' => $datos['descargueNombre'],
            ':direccion' => $datos['descargueDireccion'],
            ':id_municipio' => $datos['descargueMunicipio'],
            ':latitud' => $datos['descargueLatitud'] ?? null,
            ':longitud' => $datos['descargueLongitud'] ?? null,
            ':fecha_cita' => $datos['descargueFecha'],
            ':hora_cita' => $datos['descargueHora'],
            ':tiempo_horas' => $datos['descargueTiempoHoras'] ?? 0,
            ':tiempo_minutos' => $datos['descargueTiempoMin'] ?? 0
        ]);
    }

    private function insertarProducto($idRemesa, $datos) {
        $sql = "INSERT INTO productos_remesa (
            id_remesa,
            codigo_producto,
            descripcion,
            naturaleza_carga,
            codigo_un,
            capitulo,
            partida,
            subpartida,
            codigo_subpartida,
            codigo_arancel,
            cod_arancel,
            estado_producto,
            grupo_embalaje_envase,
            nombre_tecnico_quimico,
            descripcion_residuos_peligrosos,
            caracteristicas_peligrosidad,
            corrientes_residuos_peligrosos,
            desagregacion,
            unidad_medida_producto,
            cantidad_producto,
            unidad_medida_transporte,
            cantidad_transporte,
            empaque_primario,
            material_primario,
            codigo_primario,
            empaque_externo,
            material_externo,
            codigo_externo,
            peso_contenedor_vacio,
            kilos_contenedor_vacio
        ) VALUES (
            :id_remesa, :codigo_producto, :descripcion, :naturaleza_carga,
            :codigo_un, :capitulo, :partida, :subpartida, :codigo_subpartida,
            :codigo_arancel, :cod_arancel, :estado_producto, :grupo_embalaje_envase,
            :nombre_tecnico_quimico, :descripcion_residuos_peligrosos,
            :caracteristicas_peligrosidad, :corrientes_residuos_peligrosos,
            :desagregacion, :unidad_medida_producto, :cantidad_producto,
            :unidad_medida_transporte, :cantidad_transporte, :empaque_primario,
            :material_primario, :codigo_primario, :empaque_externo,
            :material_externo, :codigo_externo, :peso_contenedor_vacio,
            :kilos_contenedor_vacio
        )";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id_remesa' => $idRemesa,
            ':codigo_producto' => $datos['codigoProducto'],
            ':descripcion' => $datos['descripcionProducto'] ?? null,
            ':naturaleza_carga' => $datos['naturalezaCarga'] ?? null,
            ':codigo_un' => $datos['codigoUN'] ?? null,
            ':capitulo' => $datos['capitulo'] ?? null,
            ':partida' => $datos['partida'] ?? null,
            ':subpartida' => $datos['subpartida'] ?? null,
            ':codigo_subpartida' => $datos['codSubpartida'] ?? null,
            ':codigo_arancel' => $datos['codigoArancel'] ?? null,
            ':cod_arancel' => $datos['codArancel'] ?? null,
            ':estado_producto' => $datos['estadoProducto'] ?? null,
            ':grupo_embalaje_envase' => $datos['grupoEmbalajeEnvase'] ?? null,
            ':nombre_tecnico_quimico' => $datos['nombreTecnicoGrupoQuimico'] ?? null,
            ':descripcion_residuos_peligrosos' => $datos['descripcionDetalladaResiduosPeligrosos'] ?? null,
            ':caracteristicas_peligrosidad' => $datos['caracteristicasPeligrosidad'] ?? null,
            ':corrientes_residuos_peligrosos' => $datos['corrientesResiduosPeligrosos'] ?? null,
            ':desagregacion' => $datos['desagregacion'] ?? null,
            ':unidad_medida_producto' => $datos['unidadMedidaProducto'] ?? null,
            ':cantidad_producto' => $datos['cantidadProducto'] ?? 0,
            ':unidad_medida_transporte' => $datos['unidadMedidaTransporte'] ?? null,
            ':cantidad_transporte' => $datos['cantidadTransporte'] ?? 0,
            ':empaque_primario' => $datos['empaquePrimario'] ?? null,
            ':material_primario' => $datos['materialPrimario'] ?? null,
            ':codigo_primario' => $datos['codigoPrimario'] ?? null,
            ':empaque_externo' => $datos['empaqueExterno'] ?? null,
            ':material_externo' => $datos['materialExterno'] ?? null,
            ':codigo_externo' => $datos['codigoExterno'] ?? null,
            ':peso_contenedor_vacio' => $datos['pesoContenedorVacio'] ?? null,
            ':kilos_contenedor_vacio' => $datos['kilosContenedorVacio'] ?? null
        ]);
    }

    private function insertarSeguroGeneral($idRemesa, $datos) {
        $sql = "INSERT INTO seguros_remesa (
            id_remesa,
            tipo_poliza,
            tomador_poliza,
            numero_poliza,
            fecha_vencimiento,
            id_aseguradora,
            nit_aseguradora
        ) VALUES (
            :id_remesa,
            'Gen',
            :tomador_poliza,
            :numero_poliza,
            :fecha_vencimiento,
            :id_aseguradora,
            :nit_aseguradora
        )";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id_remesa' => $idRemesa,
            ':tomador_poliza' => $datos['tomadorPolizaGeneral'] ?? null,
            ':numero_poliza' => $datos['numeroPolizaGeneral'],
            ':fecha_vencimiento' => $datos['fechaVencimientoGeneral'] ?? null,
            ':id_aseguradora' => $datos['aseguradoraGeneral'] ?? null,
            ':nit_aseguradora' => $datos['nitAseguradoraGeneral'] ?? null
        ]);
    }

    private function insertarSeguroPeligrosa($idRemesa, $datos) {
        $sql = "INSERT INTO seguros_remesa (
            id_remesa,
            tipo_poliza,
            tomador_poliza,
            numero_poliza,
            fecha_vencimiento,
            id_aseguradora,
            nit_aseguradora
        ) VALUES (
            :id_remesa,
            'Pelig',
            :tomador_poliza,
            :numero_poliza,
            :fecha_vencimiento,
            :id_aseguradora,
            :nit_aseguradora
        )";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id_remesa' => $idRemesa,
            ':tomador_poliza' => $datos['tomadorPolizaPeligrosa'] ?? null,
            ':numero_poliza' => $datos['numeroPolizaPeligrosa'],
            ':fecha_vencimiento' => $datos['fechaVencimientoPeligrosa'] ?? null,
            ':id_aseguradora' => $datos['aseguradoraPeligrosa'] ?? null,
            ':nit_aseguradora' => $datos['nitAseguradoraPeligrosa'] ?? null
        ]);
    }

    private function insertarTransbordos($idRemesa, $datos) {
        // Transbordo 1
        if (!empty($datos['municipioTransbordo1'])) {
            $sql = "INSERT INTO trasbordos_remesa (
                id_remesa, id_municipio, codigo_municipio, orden
            ) VALUES (:id_remesa, :id_municipio, :codigo_municipio, 1)";
            
            $stmt = $this->pdo->prepare($sql);
            $idMunicipio = $this->obtenerIdMunicipioPorNombre($datos['municipioTransbordo1']);
            
            $stmt->execute([
                ':id_remesa' => $idRemesa,
                ':id_municipio' => $idMunicipio,
                ':codigo_municipio' => $datos['codigoMunicipioTransbordo1'] ?? null
            ]);
        }
error_log("===========================================el 1 noes ============================");
        // Transbordo 2
        if (!empty($datos['municipioTransbordo2'])) {
            $sql = "INSERT INTO trasbordos_remesa (
                id_remesa, id_municipio, codigo_municipio, orden
            ) VALUES (:id_remesa, :id_municipio, :codigo_municipio, 2)";
            
            $stmt = $this->pdo->prepare($sql);
            $idMunicipio = $this->obtenerIdMunicipioPorNombre($datos['municipioTransbordo2']);
            
            $stmt->execute([
                ':id_remesa' => $idRemesa,
                ':id_municipio' => $idMunicipio,
                ':codigo_municipio' => $datos['codigoMunicipioTransbordo2'] ?? null
            ]);
        }
    }

    // Métodos auxiliares
    private function obtenerIdEmpresaPorNit($nit) {
        $sql = "SELECT id_empresa FROM empresas WHERE nit = :nit LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':nit' => $nit]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['id_empresa'] : null;
    }

    private function obtenerIdUsuarioPorNombre($nombre) {
        $sql = "SELECT id_usuario FROM usuarios WHERE nombre = :nombre LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':nombre' => $nombre]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['id_usuario'] : null;
    }

    private function obtenerIdMunicipioPorNombre($nombre) {
        $sql = "SELECT id_municipio FROM municipios WHERE nombre = :nombre LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':nombre' => $nombre]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['id_municipio'] : null;
    }
}