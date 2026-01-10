<?php
require_once __DIR__ . '/../Config/conexion.php';

class ManifiestoModel {
    private $pdo;

    public function __construct() {
        $conexion = new Conexion();
        $conexion->getConnection();
        $this->pdo = $conexion->getConexion();
    }

    /**
     * Generar consecutivo automático para manifiesto
     */
    public function generarConsecutivo() {
        try {
            $year = date('Y');
            $sql = "SELECT COUNT(*) as total FROM manifiestos WHERE YEAR(fecha_expedicion) = :year";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':year' => $year]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $numero = str_pad($result['total'] + 1, 6, '0', STR_PAD_LEFT);
            return "MAN-{$year}-{$numero}";
        } catch (PDOException $e) {
            error_log("Error generando consecutivo: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Obtener ID de municipio por nombre
     */
    public function obtenerIdMunicipio($nombre) {
        try {
            $sql = "SELECT id_municipio FROM municipios WHERE nombre = :nombre LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':nombre' => $nombre]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['id_municipio'] : null;
        } catch (PDOException $e) {
            error_log("Error obteniendo municipio: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Obtener ID de empresa por NIT
     */
    public function obtenerIdEmpresa($nit) {
        try {
            $sql = "SELECT id_empresa FROM empresas WHERE nit = :nit LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':nit' => $nit]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['id_empresa'] : null;
        } catch (PDOException $e) {
            error_log("Error obteniendo empresa: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Obtener ID de vehículo por placa
     */
    public function obtenerIdVehiculo($placa) {
        try {
            $sql = "SELECT id_vehiculo FROM vehiculos WHERE placa = :placa LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':placa' => $placa]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['id_vehiculo'] : null;
        } catch (PDOException $e) {
            error_log("Error obteniendo vehículo: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Obtener o crear conductor
     */
    public function obtenerOCrearConductor($datos) {
        try {
            // Buscar conductor existente
            $sql = "SELECT id_conductor FROM conductores WHERE numero_identificacion = :num_id LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':num_id' => $datos['numero_identificacion']]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result) {
                return $result['id_conductor'];
            }

            // Crear nuevo conductor
            $municipioId = $this->obtenerIdMunicipio($datos['municipio']);
            
            $sql = "INSERT INTO conductores (nombre, id_tipo_identificacion, numero_identificacion, 
                    telefono, municipio, categoria_licencia, numero_licencia, vencimiento_licencia) 
                    VALUES (:nombre, :tipo_id, :num_id, :telefono, :municipio, :categoria, :num_lic, :venc_lic)";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':nombre' => $datos['nombre'],
                ':tipo_id' => $datos['tipo_identificacion'],
                ':num_id' => $datos['numero_identificacion'],
                ':telefono' => $datos['telefono'] ?? null,
                ':municipio' => $municipioId,
                ':categoria' => $datos['categoria_licencia'],
                ':num_lic' => $datos['numero_licencia'],
                ':venc_lic' => $datos['vencimiento_licencia']
            ]);
            
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error con conductor: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Guardar manifiesto completo (con transacción)
     */
    public function guardarManifiesto($datos) {
        try {
            $this->pdo->beginTransaction();

            // 1. Generar consecutivo
            $consecutivo = $this->generarConsecutivo();
            if (!$consecutivo) {
                throw new Exception("Error generando consecutivo");
            }

            // 2. Obtener IDs necesarios
            $idEmpresa = $this->obtenerIdEmpresa($datos['nitEmpresa']);
            $municipioOrigen = $this->obtenerIdMunicipio($datos['municipioOrigen']);
            $municipioDestino = $this->obtenerIdMunicipio($datos['municipioDestino']);
            $municipioTitular = $this->obtenerIdMunicipio($datos['municipioTitular']);

            // 3. Insertar manifiesto principal
            $sql = "INSERT INTO manifiestos (
                consecutivo, id_empresa, id_usuario, informacion_viaje, 
                radicado_viaje_consolidado, manifiesto_anterior, tipo_manifiesto,
                fecha_expedicion, viajes_dia, municipio_origen, municipio_destino,
                via_utilizada, titular_tipo_identificacion, titular_numero_identificacion,
                titular_sede, titular_nombre, titular_direccion, titular_municipio,
                titular_telefono, firma_electronica, cantidad_remesas,
                kilogramos_total, tiempo_cargue_horas, tiempo_cargue_minutos,
                tiempo_descargue_horas, tiempo_descargue_minutos, recomendaciones
            ) VALUES (
                :consecutivo, :id_empresa, :id_usuario, :info_viaje,
                :radicado, :man_anterior, :tipo_man,
                :fecha_exp, :viajes_dia, :mun_origen, :mun_destino,
                :via, :titular_tipo_id, :titular_num_id,
                :titular_sede, :titular_nombre, :titular_dir, :titular_mun,
                :titular_tel, :firma_elec, :cant_remesas,
                :kg_total, :t_cargue_h, :t_cargue_m,
                :t_desc_h, :t_desc_m, :recomendaciones
            )";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':consecutivo' => $consecutivo,
                ':id_empresa' => $idEmpresa,
                ':id_usuario' => $datos['id_usuario'],
                ':info_viaje' => $datos['informacionViaje'] ?? null,
                ':radicado' => $datos['radicadoViajeConsolidado'] ?? null,
                ':man_anterior' => $datos['manifiestoAnterior'] ?? null,
                ':tipo_man' => $datos['tipoManifiesto'],
                ':fecha_exp' => $datos['fechaExpedicion'],
                ':viajes_dia' => $datos['viajesDia'] ?? 1,
                ':mun_origen' => $municipioOrigen,
                ':mun_destino' => $municipioDestino,
                ':via' => $datos['viaUtilizar'],
                ':titular_tipo_id' => $datos['tipoIdentificacion'],
                ':titular_num_id' => $datos['numeroIdentificacion'],
                ':titular_sede' => $datos['sede'],
                ':titular_nombre' => $datos['nombreTitular'],
                ':titular_dir' => $datos['direccionTitular'],
                ':titular_mun' => $municipioTitular,
                ':titular_tel' => $datos['telefonoTitular'] ?? null,
                ':firma_elec' => ($datos['firmaElectronica'] === 'si') ? 1 : 0,
                ':cant_remesas' => $datos['cantidadRemesas'] ?? 0,
                ':kg_total' => $datos['kilogramos'] ?? 0,
                ':t_cargue_h' => $datos['horasCargue'] ?? 0,
                ':t_cargue_m' => $datos['minutosCargue'] ?? 0,
                ':t_desc_h' => $datos['horasDescargue'] ?? 0,
                ':t_desc_m' => $datos['minutosDescargue'] ?? 0,
                ':recomendaciones' => $datos['recomendaciones'] ?? null
            ]);

            $idManifiesto = $this->pdo->lastInsertId();

            // 4. Guardar vehículo del manifiesto
            $idVehiculo = $this->obtenerIdVehiculo($datos['placaVehiculo']);
            if ($idVehiculo) {
                $sql = "INSERT INTO manifiesto_vehiculo (id_manifiesto, id_vehiculo, configuracion_resultante) 
                        VALUES (:id_man, :id_veh, :config)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([
                    ':id_man' => $idManifiesto,
                    ':id_veh' => $idVehiculo,
                    ':config' => $datos['configuracionResultante'] ?? null
                ]);
            }

            // 5. Guardar conductores
            // Conductor 1
            $conductor1 = [
                'nombre' => $datos['conductor1Nombre'],
                'tipo_identificacion' => 1, // Asumiendo CC
                'numero_identificacion' => $datos['conductor1NumId'],
                'telefono' => $datos['conductor1Telefono'],
                'municipio' => $datos['conductor1Municipio'],
                'categoria_licencia' => $datos['conductor1Categoria'],
                'numero_licencia' => $datos['conductor1Licencia'],
                'vencimiento_licencia' => $datos['conductor1VencLic']
            ];
            $idConductor1 = $this->obtenerOCrearConductor($conductor1);
            
            if ($idConductor1) {
                $sql = "INSERT INTO manifiesto_conductores (id_manifiesto, id_conductor, orden) 
                        VALUES (:id_man, :id_cond, 1)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([':id_man' => $idManifiesto, ':id_cond' => $idConductor1]);
            }

            // Conductor 2 (opcional)
            if (!empty($datos['conductor2NumId'])) {
                $conductor2 = [
                    'nombre' => $datos['conductor2Nombre'],
                    'tipo_identificacion' => 1,
                    'numero_identificacion' => $datos['conductor2NumId'],
                    'telefono' => null,
                    'municipio' => $datos['conductor1Municipio'], // Usar mismo municipio
                    'categoria_licencia' => $datos['conductor2Categoria'],
                    'numero_licencia' => $datos['conductor2Licencia'],
                    'vencimiento_licencia' => $datos['conductor2VencLic']
                ];
                $idConductor2 = $this->obtenerOCrearConductor($conductor2);
                
                if ($idConductor2) {
                    $sql = "INSERT INTO manifiesto_conductores (id_manifiesto, id_conductor, orden) 
                            VALUES (:id_man, :id_cond, 2)";
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->execute([':id_man' => $idManifiesto, ':id_cond' => $idConductor2]);
                }
            }

            // 6. Guardar valores del manifiesto
            $sql = "INSERT INTO valores_manifiesto (
                id_manifiesto, valor_viaje, valor_vacio_1, valor_vacio_2,
                retencion_fuente, retencion_ica_porcentaje, retencion_ica_valor,
                anticipo, neto_pagar, saldo_pagar, lugar_pago, fecha_pago,
                responsable_pago, incluye_cargue, incluye_descargue
            ) VALUES (
                :id_man, :valor, :vacio1, :vacio2,
                :ret_fuente, :ret_ica_porc, :ret_ica_val,
                :anticipo, :neto, :saldo, :lugar, :fecha,
                :responsable, :cargue, :descargue
            )";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':id_man' => $idManifiesto,
                ':valor' => $datos['valorViaje'] ?? 0,
                ':vacio1' => $datos['trayectoVacio1'] ?? 0,
                ':vacio2' => $datos['trayectoVacio2'] ?? 0,
                ':ret_fuente' => $datos['retencionFuente'] ?? 0,
                ':ret_ica_porc' => $datos['retencionICA'] ?? 0,
                ':ret_ica_val' => $datos['retencionICAValor'] ?? 0,
                ':anticipo' => $datos['valorAnticipo'] ?? 0,
                ':neto' => $datos['netoPagar'] ?? 0,
                ':saldo' => $datos['saldoPagar'] ?? 0,
                ':lugar' => $datos['lugarPago'] ?? null,
                ':fecha' => $datos['fechaPago'] ?? null,
                ':responsable' => $datos['responsablePago'] ?? null,
                ':cargue' => ($datos['cargue'] === 'si') ? 1 : 0,
                ':descargue' => ($datos['descargue'] === 'si') ? 1 : 0
            ]);

            // 7. Guardar remesas del manifiesto
            if (!empty($datos['remesas']) && is_array($datos['remesas'])) {
                foreach ($datos['remesas'] as $index => $remesa) {
                    $idRemesa = $this->obtenerIdRemesaPorConsecutivo($remesa['consecutivo']);
                    if ($idRemesa) {
                        $sql = "INSERT INTO manifiesto_remesas (
                            id_manifiesto, id_remesa, horas_pacto_cargue, minutos_pacto_cargue,
                            horas_pacto_descargue, minutos_pacto_descargue, orden
                        ) VALUES (:id_man, :id_rem, :h_cargue, :m_cargue, :h_desc, :m_desc, :orden)";
                        
                        $stmt = $this->pdo->prepare($sql);
                        $stmt->execute([
                            ':id_man' => $idManifiesto,
                            ':id_rem' => $idRemesa,
                            ':h_cargue' => $remesa['horasCargue'] ?? 0,
                            ':m_cargue' => $remesa['minutosCargue'] ?? 0,
                            ':h_desc' => $remesa['horasDescargue'] ?? 0,
                            ':m_desc' => $remesa['minutosDescargue'] ?? 0,
                            ':orden' => $index + 1
                        ]);
                    }
                }
            }

            $this->pdo->commit();
            return ['success' => true, 'consecutivo' => $consecutivo, 'id' => $idManifiesto];

        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Error guardando manifiesto: " . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Obtener ID de remesa por consecutivo
     */
    public function obtenerIdRemesaPorConsecutivo($consecutivo) {
        try {
            $sql = "SELECT id_remesa FROM remesas WHERE consecutivo = :consecutivo LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':consecutivo' => $consecutivo]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['id_remesa'] : null;
        } catch (PDOException $e) {
            error_log("Error obteniendo remesa: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Listar remesas disponibles
     */
    public function listarRemesas() {
        try {
            $sql = "SELECT r.id_remesa, r.consecutivo, r.fecha_expedicion, r.propietario_nombre,
                    e.razon_social as empresa_nombre
                    FROM remesas r
                    LEFT JOIN empresas e ON r.id_empresa_generadora = e.id_empresa
                    ORDER BY r.fecha_expedicion DESC";
            
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error listando remesas: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtener detalle de remesa
     */
    public function obtenerDetalleRemesa($consecutivo) {
        try {
            $sql = "SELECT r.*, 
                    sc.direccion as cargue_dir, mc.nombre as cargue_mun,
                    sd.direccion as descargue_dir, md.nombre as descargue_mun,
                    p.descripcion as producto_desc, p.cantidad_producto
                    FROM remesas r
                    LEFT JOIN sitios_remesa sc ON r.id_remesa = sc.id_remesa AND sc.tipo = 'CARGUE'
                    LEFT JOIN municipios mc ON sc.id_municipio = mc.id_municipio
                    LEFT JOIN sitios_remesa sd ON r.id_remesa = sd.id_remesa AND sd.tipo = 'DESCARGUE'
                    LEFT JOIN municipios md ON sd.id_municipio = md.id_municipio
                    LEFT JOIN productos_remesa p ON r.id_remesa = p.id_remesa
                    WHERE r.consecutivo = :consecutivo
                    LIMIT 1";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':consecutivo' => $consecutivo]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error obteniendo detalle remesa: " . $e->getMessage());
            return null;
        }
    }
}