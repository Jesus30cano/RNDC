<?php
require_once __DIR__ . '/../Models/remesaModel.php';

class RemesaController {
    private $model;

    public function __construct() {
        $this->model = new RemesaModel();
    }

    /**
     * Muestra el formulario de remesa
     */
    public function index() {
        require __DIR__ . '/../Views/remesa.php';
    }

    /**
     * Guarda una nueva remesa
     */
    public function guardar() {
        try {
            // Validar que sea una petición POST
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Método no permitido'
                ], 405);
                return;
            }

            // Obtener los datos JSON del body
            $json = file_get_contents('php://input');
            $datos = json_decode($json, true);

            // Validar que se recibieron datos
            if (empty($datos)) {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'No se recibieron datos'
                ], 400);
                return;
            }

            // Validar campos obligatorios
            $camposObligatorios = [
                'consecutivo',
                'nitEmpresa',
                'usuario',
                'propTipoId',
                'propNumId',
                'propNombre',
                'tipoOperacion',
                'tipoEmpaque'
            ];

            $errores = [];
            foreach ($camposObligatorios as $campo) {
                if (empty($datos[$campo])) {
                    $errores[] = "El campo '$campo' es obligatorio";
                }
            }

            if (!empty($errores)) {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Faltan campos obligatorios',
                    'errores' => $errores
                ], 400);
                return;
            }

            // Log de los datos recibidos
            error_log("📥 Guardando remesa:");
            error_log("  - Consecutivo: " . $datos['consecutivo']);
            error_log("  - NIT Empresa: " . $datos['nitEmpresa']);
            error_log("  - Usuario: " . $datos['usuario']);

            // Guardar la remesa usando el modelo
            $resultado = $this->model->guardarRemesa($datos);

            // Responder según el resultado
            if ($resultado['success']) {
                error_log("✅ Remesa guardada exitosamente - ID: " . $resultado['id_remesa']);
                $this->jsonResponse($resultado, 201);
            } else {
                error_log("❌ Error al guardar remesa: " . $resultado['message']);
                $this->jsonResponse($resultado, 500);
            }

        } catch (Exception $e) {
            error_log("💥 Excepción en guardar(): " . $e->getMessage());
            error_log("   Stack trace: " . $e->getTraceAsString());
            
            $this->jsonResponse([
                'success' => false,
                'message' => 'Error interno del servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Envía una respuesta JSON
     */
    private function jsonResponse($data, $statusCode = 200) {
        error_log("📤 Enviando respuesta JSON:");
        error_log("  - Status code: " . $statusCode);
        error_log("  - Data: " . json_encode($data, JSON_PRETTY_PRINT));
        
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
}