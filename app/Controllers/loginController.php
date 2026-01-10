<?php
require_once __DIR__ . '/../Models/userModel.php';

class LoginController {
    
    public function index() {
        error_log("🏠 LoginController::index() - Mostrando vista de login");
        require __DIR__ . '/../Views/login.php';
    }

    public function authenticate() {
        error_log("=== 🔐 INICIO DE AUTENTICACIÓN ===");
        error_log("Método HTTP: " . $_SERVER['REQUEST_METHOD']);
        
        // Verificar que sea una petición POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            error_log("❌ ERROR: Método no permitido - " . $_SERVER['REQUEST_METHOD']);
            $this->jsonResponse(['success' => false, 'message' => 'Método no permitido'], 405);
            return;
        }

        // Obtener datos JSON del body
        $json = file_get_contents('php://input');
        error_log("📥 JSON recibido (raw): " . $json);
        
        $data = json_decode($json, true);
        error_log("📦 Datos parseados: " . print_r($data, true));

        // Validar que vengan los datos requeridos
        if (empty($data['username']) || empty($data['password'])) {
            error_log("❌ ERROR: Faltan username o password");
            error_log("Username vacío: " . (empty($data['username']) ? 'SI' : 'NO'));
            error_log("Password vacío: " . (empty($data['password']) ? 'SI' : 'NO'));
            
            $this->jsonResponse([
                'success' => false, 
                'message' => 'Usuario y contraseña son requeridos'
            ], 400);
            return;
        }

        $username = trim($data['username']);
        $password = trim($data['password']);
        $remember = isset($data['remember']) ? $data['remember'] : false;

        error_log("👤 Username: " . $username);
        error_log("🔑 Password length: " . strlen($password));
        error_log("💾 Remember me: " . ($remember ? 'SI' : 'NO'));

        try {
            error_log("📊 Instanciando modelo Usuario...");
            $usuarioModel = new Usuario();
            
            error_log("🔍 Buscando usuario en BD...");
            $usuario = $usuarioModel->obtenerUsuarioPorCorreo($username);

            if (!$usuario) {
                error_log("❌ Usuario NO encontrado en BD para: " . $username);
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Usuario o contraseña incorrectos'
                ], 401);
                return;
            }

            error_log("✅ Usuario encontrado:");
            error_log("  - ID: " . $usuario['id_usuario']);
            error_log("  - Nombre: " . $usuario['nombre']);
            error_log("  - Email: " . $usuario['email']);
            error_log("  - Hash (primeros 30 chars): " . substr($usuario['password_hash'], 0, 30) . "...");

            // Verificar la contraseña
            error_log("🔐 Verificando contraseña...");
            $passwordValido = password_verify($password, $usuario['password_hash']);
            error_log("🔐 Resultado de password_verify: " . ($passwordValido ? 'VÁLIDO ✅' : 'INVÁLIDO ❌'));

            if (!$passwordValido) {
                error_log("❌ Contraseña incorrecta para usuario: " . $username);
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Usuario o contraseña incorrectos'
                ], 401);
                return;
            }

            error_log("🎉 Contraseña válida - Creando sesión...");

            // Login exitoso - crear sesión SOLO SI NO EXISTE
            if (session_status() === PHP_SESSION_NONE) {
                error_log("🔄 Iniciando nueva sesión...");
                session_start();
            } else {
                error_log("ℹ️ Sesión ya existente, usando la actual");
            }
            
            $_SESSION['user_id'] = $usuario['id_usuario'];
            $_SESSION['user_name'] = $usuario['nombre'];
            $_SESSION['user_email'] = $usuario['email'];
            $_SESSION['logged_in'] = true;

            error_log("✅ Variables de sesión establecidas:");
            error_log("  - user_id: " . $_SESSION['user_id']);
            error_log("  - user_name: " . $_SESSION['user_name']);
            error_log("  - user_email: " . $_SESSION['user_email']);

            // Si el usuario marcó "recordarme", extender la sesión
            if ($remember) {
                error_log("💾 Configurando 'remember me' (30 días)...");
                ini_set('session.gc_maxlifetime', 2592000);
                session_set_cookie_params(2592000);
            }

            $redirectUrl = '/RNDC/index.php?c=dashboard&a=index';
            error_log("🚀 Preparando respuesta exitosa - Redirect: " . $redirectUrl);

            // Respuesta exitosa
            $this->jsonResponse([
                'success' => true,
                'message' => 'Login exitoso',
                'redirectUrl' => $redirectUrl,
                'user' => [
                    'name' => $usuario['nombre'],
                    'email' => $usuario['email']
                ]
            ], 200);

            error_log("=== ✅ FIN DE AUTENTICACIÓN EXITOSA ===");

        } catch (Exception $e) {
            error_log("💥 EXCEPCIÓN CAPTURADA:");
            error_log("  - Mensaje: " . $e->getMessage());
            error_log("  - Archivo: " . $e->getFile());
            error_log("  - Línea: " . $e->getLine());
            error_log("  - Stack trace: " . $e->getTraceAsString());
            
            $this->jsonResponse([
                'success' => false,
                'message' => 'Error en el servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    public function logout() {
        error_log("🚪 LoginController::logout() - Cerrando sesión");
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        
        error_log("✅ Sesión destruida - Redirigiendo a login");
        header('Location: /RNDC/index.php?c=login&a=index');
        exit;
    }

    private function jsonResponse($data, $statusCode = 200) {
        error_log("📤 Enviando respuesta JSON:");
        error_log("  - Status code: " . $statusCode);
        error_log("  - Data: " . json_encode($data));
        
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}