<?php
require_once __DIR__ . '/../Config/conexion.php';

class ConsultaManifiestoModel {
    private $pdo;

    public function __construct() {
        $conexion = new Conexion();
        $conexion->getConnection();
        $this->pdo = $conexion->getConexion();
    }

    /**
     * Buscar manifiestos con filtros opcionales
     */
    public function buscarManifiestos($filtros = []) {
        try {
            $sql = "SELECT 
                        m.id_manifiesto,
                        m.consecutivo,
                        m.fecha_expedicion,
                        m.tipo_manifiesto,
                        m.cantidad_remesas,
                        m.kilogramos_total,
                        m.galones_total,
                        m.titular_nombre,
                        e.razon_social as empresa_razon_social,
                        e.nit as empresa_nit,
                        mo.nombre as municipio_origen,
                        md.nombre as municipio_destino,
                        (SELECT v.placa 
                         FROM manifiesto_vehiculo mv 
                         INNER JOIN vehiculos v ON mv.id_vehiculo = v.id_vehiculo 
                         WHERE mv.id_manifiesto = m.id_manifiesto 
                         LIMIT 1
                        ) as placa_vehiculo,
                        (SELECT c.nombre 
                         FROM manifiesto_conductores mc 
                         INNER JOIN conductores c ON mc.id_conductor = c.id_conductor 
                         WHERE mc.id_manifiesto = m.id_manifiesto AND mc.orden = 1
                         LIMIT 1
                        ) as conductor_nombre,
                        (SELECT c.numero_identificacion 
                         FROM manifiesto_conductores mc 
                         INNER JOIN conductores c ON mc.id_conductor = c.id_conductor 
                         WHERE mc.id_manifiesto = m.id_manifiesto AND mc.orden = 1
                         LIMIT 1
                        ) as conductor_cedula
                    FROM manifiestos m
                    LEFT JOIN empresas e ON m.id_empresa = e.id_empresa
                    LEFT JOIN municipios mo ON m.municipio_origen = mo.id_municipio
                    LEFT JOIN municipios md ON m.municipio_destino = md.id_municipio
                    WHERE 1=1";
            
            $params = [];

            // Aplicar filtros
            if (!empty($filtros['consecutivo'])) {
                $sql .= " AND m.consecutivo LIKE :consecutivo";
                $params[':consecutivo'] = '%' . $filtros['consecutivo'] . '%';
            }

            if (!empty($filtros['placa'])) {
                $sql .= " AND EXISTS (
                    SELECT 1 FROM manifiesto_vehiculo mv 
                    INNER JOIN vehiculos v ON mv.id_vehiculo = v.id_vehiculo 
                    WHERE mv.id_manifiesto = m.id_manifiesto 
                    AND v.placa LIKE :placa
                )";
                $params[':placa'] = '%' . $filtros['placa'] . '%';
            }

            if (!empty($filtros['fechaDesde'])) {
                $sql .= " AND m.fecha_expedicion >= :fechaDesde";
                $params[':fechaDesde'] = $filtros['fechaDesde'];
            }

            if (!empty($filtros['fechaHasta'])) {
                $sql .= " AND m.fecha_expedicion <= :fechaHasta";
                $params[':fechaHasta'] = $filtros['fechaHasta'];
            }

            if (!empty($filtros['cedulaConductor'])) {
                $sql .= " AND EXISTS (
                    SELECT 1 FROM manifiesto_conductores mc 
                    INNER JOIN conductores c ON mc.id_conductor = c.id_conductor 
                    WHERE mc.id_manifiesto = m.id_manifiesto 
                    AND c.numero_identificacion LIKE :cedulaConductor
                )";
                $params[':cedulaConductor'] = '%' . $filtros['cedulaConductor'] . '%';
            }

            if (!empty($filtros['municipioOrigen'])) {
                $sql .= " AND mo.nombre LIKE :municipioOrigen";
                $params[':municipioOrigen'] = '%' . $filtros['municipioOrigen'] . '%';
            }

            if (!empty($filtros['municipioDestino'])) {
                $sql .= " AND md.nombre LIKE :municipioDestino";
                $params[':municipioDestino'] = '%' . $filtros['municipioDestino'] . '%';
            }

            if (!empty($filtros['tipoManifiesto'])) {
                $sql .= " AND m.tipo_manifiesto = :tipoManifiesto";
                $params[':tipoManifiesto'] = $filtros['tipoManifiesto'];
            }

            // Ordenar por fecha más reciente
            $sql .= " ORDER BY m.fecha_expedicion DESC, m.id_manifiesto DESC";

            // Limitar resultados (opcional)
            if (isset($filtros['limit'])) {
                $sql .= " LIMIT :limit";
            }

            $stmt = $this->pdo->prepare($sql);
            
            // Bind de parámetros
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }

            if (isset($filtros['limit'])) {
                $stmt->bindValue(':limit', (int)$filtros['limit'], PDO::PARAM_INT);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error en buscarManifiestos: " . $e->getMessage());
            throw new Exception("Error al buscar manifiestos: " . $e->getMessage());
        }
    }

    /**
     * Obtener detalle completo de un manifiesto
     */
    public function obtenerDetalleManifiesto($idManifiesto) {
        try {
            // Información principal del manifiesto
            $sql = "SELECT 
                        m.*,
                        e.razon_social as empresa_razon_social,
                        e.nit as empresa_nit,
                        e.direccion as empresa_direccion,
                        e.telefono as empresa_telefono,
                        mo.nombre as municipio_origen_nombre,
                        mo.departamento as municipio_origen_departamento,
                        md.nombre as municipio_destino_nombre,
                        md.departamento as municipio_destino_departamento,
                        mi.nombre as municipio_intermedio_nombre,
                        ti.nombre as titular_tipo_identificacion_nombre
                    FROM manifiestos m
                    LEFT JOIN empresas e ON m.id_empresa = e.id_empresa
                    LEFT JOIN municipios mo ON m.municipio_origen = mo.id_municipio
                    LEFT JOIN municipios md ON m.municipio_destino = md.id_municipio
                    LEFT JOIN municipios mi ON m.municipio_intermedio = mi.id_municipio
                    LEFT JOIN tipos_identificacion ti ON m.titular_tipo_identificacion = ti.id_tipo
                    WHERE m.id_manifiesto = :id_manifiesto";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id_manifiesto' => $idManifiesto]);
            $manifiesto = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$manifiesto) {
                return null;
            }

            // Obtener vehículos
            $manifiesto['vehiculos'] = $this->obtenerVehiculosManifiesto($idManifiesto);

            // Obtener conductores
            $manifiesto['conductores'] = $this->obtenerConductoresManifiesto($idManifiesto);

            // Obtener remesas asociadas
            $manifiesto['remesas'] = $this->obtenerRemesasManifiesto($idManifiesto);

            // Obtener valores
            $manifiesto['valores'] = $this->obtenerValoresManifiesto($idManifiesto);

            return $manifiesto;

        } catch (PDOException $e) {
            error_log("Error en obtenerDetalleManifiesto: " . $e->getMessage());
            throw new Exception("Error al obtener detalle de manifiesto: " . $e->getMessage());
        }
    }

    /**
     * Obtener vehículos de un manifiesto
     */
    private function obtenerVehiculosManifiesto($idManifiesto) {
        $sql = "SELECT 
                    v.placa,
                    v.configuracion,
                    v.peso_vacio,
                    v.poliza_soat,
                    v.vencimiento_soat,
                    v.tenedor_nombre,
                    r.placa as remolque_placa,
                    r.configuracion as remolque_configuracion,
                    mv.configuracion_resultante
                FROM manifiesto_vehiculo mv
                INNER JOIN vehiculos v ON mv.id_vehiculo = v.id_vehiculo
                LEFT JOIN remolques r ON mv.id_remolque1 = r.id_remolque
                WHERE mv.id_manifiesto = :id_manifiesto";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_manifiesto' => $idManifiesto]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener conductores de un manifiesto
     */
    private function obtenerConductoresManifiesto($idManifiesto) {
        $sql = "SELECT 
                    c.nombre,
                    c.numero_identificacion,
                    c.telefono,
                    c.categoria_licencia,
                    c.numero_licencia,
                    c.vencimiento_licencia,
                    ti.nombre as tipo_identificacion,
                    m.nombre as municipio,
                    mc.orden
                FROM manifiesto_conductores mc
                INNER JOIN conductores c ON mc.id_conductor = c.id_conductor
                LEFT JOIN tipos_identificacion ti ON c.id_tipo_identificacion = ti.id_tipo
                LEFT JOIN municipios m ON c.municipio = m.id_municipio
                WHERE mc.id_manifiesto = :id_manifiesto
                ORDER BY mc.orden";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_manifiesto' => $idManifiesto]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener remesas de un manifiesto
     */
    private function obtenerRemesasManifiesto($idManifiesto) {
        $sql = "SELECT 
                    r.consecutivo,
                    r.fecha_expedicion,
                    r.propietario_nombre,
                    r.tipo_operacion,
                    mr.horas_pacto_cargue,
                    mr.minutos_pacto_cargue,
                    mr.horas_pacto_descargue,
                    mr.minutos_pacto_descargue,
                    mr.orden,
                    (SELECT GROUP_CONCAT(m.nombre SEPARATOR ', ') 
                     FROM sitios_remesa sr 
                     INNER JOIN municipios m ON sr.id_municipio = m.id_municipio 
                     WHERE sr.id_remesa = r.id_remesa AND sr.tipo = 'CARGUE'
                    ) as municipios_cargue,
                    (SELECT GROUP_CONCAT(m.nombre SEPARATOR ', ') 
                     FROM sitios_remesa sr 
                     INNER JOIN municipios m ON sr.id_municipio = m.id_municipio 
                     WHERE sr.id_remesa = r.id_remesa AND sr.tipo = 'DESCARGUE'
                    ) as municipios_descargue
                FROM manifiesto_remesas mr
                INNER JOIN remesas r ON mr.id_remesa = r.id_remesa
                WHERE mr.id_manifiesto = :id_manifiesto
                ORDER BY mr.orden";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_manifiesto' => $idManifiesto]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener valores de un manifiesto
     */
    private function obtenerValoresManifiesto($idManifiesto) {
        $sql = "SELECT * FROM valores_manifiesto 
                WHERE id_manifiesto = :id_manifiesto";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_manifiesto' => $idManifiesto]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener estadísticas de manifiestos
     */
    public function obtenerEstadisticas($filtros = []) {
        try {
            $sql = "SELECT 
                        COUNT(*) as total_manifiestos,
                        COUNT(DISTINCT id_empresa) as total_empresas,
                        SUM(cantidad_remesas) as total_remesas,
                        SUM(kilogramos_total) as total_kilogramos,
                        SUM(galones_total) as total_galones
                    FROM manifiestos
                    WHERE 1=1";

            $params = [];

            if (!empty($filtros['fechaDesde'])) {
                $sql .= " AND fecha_expedicion >= :fechaDesde";
                $params[':fechaDesde'] = $filtros['fechaDesde'];
            }

            if (!empty($filtros['fechaHasta'])) {
                $sql .= " AND fecha_expedicion <= :fechaHasta";
                $params[':fechaHasta'] = $filtros['fechaHasta'];
            }

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error en obtenerEstadisticas: " . $e->getMessage());
            throw new Exception("Error al obtener estadísticas: " . $e->getMessage());
        }
    }
}