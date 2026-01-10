<?php
require_once __DIR__ . '/../Models/ConsultaRemesaModel.php';

class ConsultaRemesaController {
    private $model;

    public function __construct() {
        $this->model = new ConsultaRemesaModel();
    }

    /**
     * Vista principal de consulta
     */
    public function index() {
        require __DIR__ . '/../Views/consultaRemesa.php';
    }

    /**
     * Buscar remesas con filtros (AJAX)
     */
    public function buscar() {
        try {
            error_log("📥 Recibiendo solicitud de búsqueda de remesas");
            
            // Obtener datos del POST
            $json = file_get_contents('php://input');
            $filtros = json_decode($json, true);

            error_log("🔍 Filtros recibidos: " . print_r($filtros, true));

            // Si no hay filtros, mostrar todas las remesas
            if (empty($filtros) || !is_array($filtros)) {
                $filtros = [];
            }

            // Buscar remesas
            $remesas = $this->model->buscarRemesas($filtros);

            error_log("✅ Remesas encontradas: " . count($remesas));

            $this->jsonResponse([
                'success' => true,
                'remesas' => $remesas,
                'total' => count($remesas)
            ]);

        } catch (Exception $e) {
            error_log("❌ Error en buscar: " . $e->getMessage());
            $this->jsonResponse([
                'success' => false,
                'message' => 'Error al buscar remesas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener detalle completo de una remesa (AJAX)
     */
    public function detalle() {
        try {
            error_log("📥 Recibiendo solicitud de detalle de remesa");
            
            // Obtener datos del POST
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            if (empty($data['id_remesa'])) {
                throw new Exception('ID de remesa no proporcionado');
            }

            $idRemesa = (int)$data['id_remesa'];
            error_log("🔍 Buscando remesa ID: " . $idRemesa);

            // Obtener detalle
            $remesa = $this->model->obtenerDetalleRemesa($idRemesa);

            if (!$remesa) {
                throw new Exception('Remesa no encontrada');
            }

            error_log("✅ Remesa encontrada: " . $remesa['consecutivo']);

            $this->jsonResponse([
                'success' => true,
                'remesa' => $remesa
            ]);

        } catch (Exception $e) {
            error_log("❌ Error en detalle: " . $e->getMessage());
            $this->jsonResponse([
                'success' => false,
                'message' => 'Error al obtener detalle: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener estadísticas de remesas (AJAX)
     */
    public function estadisticas() {
        try {
            $json = file_get_contents('php://input');
            $filtros = json_decode($json, true);

            if (empty($filtros) || !is_array($filtros)) {
                $filtros = [];
            }

            $stats = $this->model->obtenerEstadisticas($filtros);

            $this->jsonResponse([
                'success' => true,
                'estadisticas' => $stats
            ]);

        } catch (Exception $e) {
            error_log("❌ Error en estadísticas: " . $e->getMessage());
            $this->jsonResponse([
                'success' => false,
                'message' => 'Error al obtener estadísticas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Exportar remesas a CSV
     */
    public function exportarCSV() {
        try {
            $json = file_get_contents('php://input');
            $filtros = json_decode($json, true);

            if (empty($filtros) || !is_array($filtros)) {
                $filtros = [];
            }

            $remesas = $this->model->buscarRemesas($filtros);

            // Generar CSV
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="remesas_' . date('Y-m-d') . '.csv"');

            $output = fopen('php://output', 'w');
            
            // BOM para UTF-8
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

            // Encabezados
            fputcsv($output, [
                'Consecutivo',
                'Fecha Expedición',
                'Propietario',
                'Empresa Generadora',
                'Municipio Cargue',
                'Municipio Descargue',
                'Tipo Operación',
                'Orden Servicio'
            ]);

            // Datos
            foreach ($remesas as $remesa) {
                fputcsv($output, [
                    $remesa['consecutivo'] ?? '',
                    $remesa['fecha_expedicion'] ?? '',
                    $remesa['propietario_nombre'] ?? '',
                    $remesa['empresa_generadora'] ?? '',
                    $remesa['municipio_cargue'] ?? '',
                    $remesa['municipio_descargue'] ?? '',
                    $remesa['tipo_operacion'] ?? '',
                    $remesa['orden_servicio'] ?? ''
                ]);
            }

            fclose($output);
            exit;

        } catch (Exception $e) {
            error_log("❌ Error en exportarCSV: " . $e->getMessage());
            http_response_code(500);
            echo "Error al exportar: " . $e->getMessage();
            exit;
        }
    }

    /**
     * Respuesta JSON estándar
     */
    private function jsonResponse($data, $statusCode = 200) {
        error_log("📤 Enviando respuesta JSON:");
        error_log("  - Status code: " . $statusCode);
        error_log("  - Data: " . json_encode($data));
        
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
}