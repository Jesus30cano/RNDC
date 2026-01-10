<?php
require_once __DIR__ . '/../Config/conexion.php';

class ConsultaRemesaModel {
    private $pdo;

    public function __construct() {
        $conexion = new Conexion();
        $conexion->getConnection();
        $this->pdo = $conexion->getConexion();
    }

    /**
     * Buscar remesas con filtros opcionales
     */
    public function buscarRemesas($filtros = []) {
        try {
            $sql = "SELECT 
                        r.id_remesa,
                        r.consecutivo,
                        r.fecha_expedicion,
                        r.tipo_operacion,
                        r.orden_servicio,
                        r.propietario_nombre,
                        r.propietario_num_id,
                        ti.nombre as propietario_tipo_identificacion,
                        e.razon_social as empresa_generadora,
                        e.nit as empresa_nit,
                        mp.nombre as propietario_municipio_nombre,
                        (SELECT GROUP_CONCAT(m.nombre SEPARATOR ', ') 
                         FROM sitios_remesa sr 
                         INNER JOIN municipios m ON sr.id_municipio = m.id_municipio 
                         WHERE sr.id_remesa = r.id_remesa AND sr.tipo = 'CARGUE'
                        ) as municipio_cargue,
                        (SELECT GROUP_CONCAT(m.nombre SEPARATOR ', ') 
                         FROM sitios_remesa sr 
                         INNER JOIN municipios m ON sr.id_municipio = m.id_municipio 
                         WHERE sr.id_remesa = r.id_remesa AND sr.tipo = 'DESCARGUE'
                        ) as municipio_descargue
                    FROM remesas r
                    LEFT JOIN empresas e ON r.id_empresa_generadora = e.id_empresa
                    LEFT JOIN tipos_identificacion ti ON r.propietario_tipo_id = ti.id_tipo
                    LEFT JOIN municipios mp ON r.propietario_municipio = mp.id_municipio
                    WHERE 1=1";
            
            $params = [];

            // Aplicar filtros
            if (!empty($filtros['consecutivo'])) {
                $sql .= " AND r.consecutivo LIKE :consecutivo";
                $params[':consecutivo'] = '%' . $filtros['consecutivo'] . '%';
            }

            if (!empty($filtros['fechaDesde'])) {
                $sql .= " AND r.fecha_expedicion >= :fechaDesde";
                $params[':fechaDesde'] = $filtros['fechaDesde'];
            }

            if (!empty($filtros['fechaHasta'])) {
                $sql .= " AND r.fecha_expedicion <= :fechaHasta";
                $params[':fechaHasta'] = $filtros['fechaHasta'];
            }

            if (!empty($filtros['propietarioId'])) {
                $sql .= " AND r.propietario_num_id LIKE :propietarioId";
                $params[':propietarioId'] = '%' . $filtros['propietarioId'] . '%';
            }

            if (!empty($filtros['propietarioNombre'])) {
                $sql .= " AND r.propietario_nombre LIKE :propietarioNombre";
                $params[':propietarioNombre'] = '%' . $filtros['propietarioNombre'] . '%';
            }

            if (!empty($filtros['empresaNit'])) {
                $sql .= " AND e.nit LIKE :empresaNit";
                $params[':empresaNit'] = '%' . $filtros['empresaNit'] . '%';
            }

            if (!empty($filtros['tipoOperacion'])) {
                $sql .= " AND r.tipo_operacion = :tipoOperacion";
                $params[':tipoOperacion'] = $filtros['tipoOperacion'];
            }

            // Ordenar por fecha más reciente
            $sql .= " ORDER BY r.fecha_expedicion DESC, r.id_remesa DESC";

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
            error_log("Error en buscarRemesas: " . $e->getMessage());
            throw new Exception("Error al buscar remesas: " . $e->getMessage());
        }
    }

    /**
     * Obtener detalle completo de una remesa
     */
    public function obtenerDetalleRemesa($idRemesa) {
        try {
            // Información principal
            $sql = "SELECT 
                        r.*,
                        e.razon_social as empresa_generadora,
                        e.nit as empresa_nit,
                        e.telefono as empresa_telefono,
                        e.email as empresa_email,
                        ti.nombre as propietario_tipo_identificacion,
                        mp.nombre as propietario_municipio_nombre,
                        mp.departamento as propietario_departamento
                    FROM remesas r
                    LEFT JOIN empresas e ON r.id_empresa_generadora = e.id_empresa
                    LEFT JOIN tipos_identificacion ti ON r.propietario_tipo_id = ti.id_tipo
                    LEFT JOIN municipios mp ON r.propietario_municipio = mp.id_municipio
                    WHERE r.id_remesa = :id_remesa";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id_remesa' => $idRemesa]);
            $remesa = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$remesa) {
                return null;
            }

            // Obtener sitios de cargue
            $remesa['sitios_cargue'] = $this->obtenerSitiosRemesa($idRemesa, 'CARGUE');

            // Obtener sitios de descargue
            $remesa['sitios_descargue'] = $this->obtenerSitiosRemesa($idRemesa, 'DESCARGUE');

            // Obtener productos
            $remesa['productos'] = $this->obtenerProductosRemesa($idRemesa);

            // Obtener seguros
            $remesa['seguros'] = $this->obtenerSegurosRemesa($idRemesa);

            // Obtener trasbordos
            $remesa['trasbordos'] = $this->obtenerTrasbordosRemesa($idRemesa);

            return $remesa;

        } catch (PDOException $e) {
            error_log("Error en obtenerDetalleRemesa: " . $e->getMessage());
            throw new Exception("Error al obtener detalle de remesa: " . $e->getMessage());
        }
    }

    /**
     * Obtener sitios de una remesa (cargue o descargue)
     */
    private function obtenerSitiosRemesa($idRemesa, $tipo) {
        $sql = "SELECT 
                    sr.*,
                    m.nombre as municipio,
                    m.departamento,
                    ti.nombre as tipo_identificacion_nombre
                FROM sitios_remesa sr
                LEFT JOIN municipios m ON sr.id_municipio = m.id_municipio
                LEFT JOIN tipos_identificacion ti ON sr.tipo_identificacion = ti.id_tipo
                WHERE sr.id_remesa = :id_remesa AND sr.tipo = :tipo
                ORDER BY sr.id_sitio";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id_remesa' => $idRemesa,
            ':tipo' => $tipo
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener productos de una remesa
     */
    private function obtenerProductosRemesa($idRemesa) {
        $sql = "SELECT 
                    pr.*,
                    um1.nombre as unidad_medida_producto_nombre,
                    um2.nombre as unidad_medida_transporte_nombre
                FROM productos_remesa pr
                LEFT JOIN unidades_medida um1 ON pr.unidad_medida_producto = um1.id_unidad
                LEFT JOIN unidades_medida um2 ON pr.unidad_medida_transporte = um2.id_unidad
                WHERE pr.id_remesa = :id_remesa
                ORDER BY pr.id_producto";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_remesa' => $idRemesa]);
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Agregar nombre de unidad al resultado
        foreach ($productos as &$producto) {
            $producto['unidad_medida'] = $producto['unidad_medida_producto_nombre'] ?? 'N/A';
        }

        return $productos;
    }

    /**
     * Obtener seguros de una remesa
     */
    private function obtenerSegurosRemesa($idRemesa) {
        $sql = "SELECT 
                    sr.*,
                    a.nombre as aseguradora_nombre
                FROM seguros_remesa sr
                LEFT JOIN aseguradoras a ON sr.id_aseguradora = a.id_aseguradora
                WHERE sr.id_remesa = :id_remesa
                ORDER BY sr.id_seguro";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_remesa' => $idRemesa]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener trasbordos de una remesa
     */
    private function obtenerTrasbordosRemesa($idRemesa) {
        $sql = "SELECT 
                    tr.*,
                    m.nombre as municipio_nombre,
                    m.departamento
                FROM trasbordos_remesa tr
                LEFT JOIN municipios m ON tr.id_municipio = m.id_municipio
                WHERE tr.id_remesa = :id_remesa
                ORDER BY tr.orden";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_remesa' => $idRemesa]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener estadísticas de remesas
     */
    public function obtenerEstadisticas($filtros = []) {
        try {
            $sql = "SELECT 
                        COUNT(*) as total_remesas,
                        COUNT(DISTINCT id_empresa_generadora) as total_empresas,
                        COUNT(DISTINCT propietario_num_id) as total_propietarios
                    FROM remesas
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