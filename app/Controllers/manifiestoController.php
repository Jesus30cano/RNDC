<?php
require_once __DIR__ . '/../Models/ManifiestoModel.php';

class ManifiestoController {
    private $model;
    
    public function __construct() {
        $this->model = new ManifiestoModel();
    }

    /**
     * Vista principal del formulario
     */
    public function index() {
        // Verificar sesión
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?c=login&a=index');
            exit;
        }
        
        require __DIR__ . '/../Views/manifiesto.php';
    }

    /**
     * Guardar manifiesto
     */
    public function guardar() {
        try {
            // Verificar sesión
            if (!isset($_SESSION['user_id'])) {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Sesión no válida'
                ], 401);
            }

            // Obtener datos JSON
            $json = file_get_contents('php://input');
            $datos = json_decode($json, true);

            if (!$datos) {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Datos inválidos'
                ], 400);
            }

            // Agregar ID de usuario de la sesión
            $datos['id_usuario'] = $_SESSION['user_id'];

            // Log para debug
            error_log("📝 Guardando manifiesto con datos: " . json_encode($datos, JSON_PRETTY_PRINT));

            // Guardar en la base de datos
            $resultado = $this->model->guardarManifiesto($datos);

            if ($resultado['success']) {
                $this->jsonResponse([
                    'success' => true,
                    'consecutivo' => $resultado['consecutivo'],
                    'id_manifiesto' => $resultado['id'],
                    'message' => 'Manifiesto guardado exitosamente'
                ]);
            } else {
                $this->jsonResponse([
                    'success' => false,
                    'message' => $resultado['message'] ?? 'Error desconocido'
                ], 500);
            }

        } catch (Exception $e) {
            error_log("❌ Error en guardar: " . $e->getMessage());
            $this->jsonResponse([
                'success' => false,
                'message' => 'Error del servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Listar remesas disponibles (AJAX)
     */
    public function listarRemesas() {
        try {
            $remesas = $this->model->listarRemesas();
            $this->jsonResponse([
                'success' => true,
                'remesas' => $remesas
            ]);
        } catch (Exception $e) {
            $this->jsonResponse([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener detalle de una remesa (AJAX)
     */
    public function detalleRemesa() {
        try {
            $consecutivo = $_GET['consecutivo'] ?? null;
            
            if (!$consecutivo) {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Consecutivo no proporcionado'
                ], 400);
            }

            $detalle = $this->model->obtenerDetalleRemesa($consecutivo);
            
            if ($detalle) {
                $this->jsonResponse([
                    'success' => true,
                    'remesa' => $detalle
                ]);
            } else {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Remesa no encontrada'
                ], 404);
            }
        } catch (Exception $e) {
            $this->jsonResponse([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Respuesta JSON estandarizada
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