<?php
require_once __DIR__ . '/../Config/conexion.php';

class Usuario {
    private $pdo;

    public function __construct() {
        $conexion = new Conexion();
        $conexion->getConnection(); // Esto inicializa la conexión
        $this->pdo = $conexion->getConexion(); // Esto obtiene el objeto PDO
    }

    public function obtenerUsuarioPorCorreo($correo) {
        try {
            $sql = "SELECT id_usuario, nombre, email, password_hash FROM usuarios WHERE email = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$correo]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener usuario: " . $e->getMessage());
            return false;
        }
    }

    public function actualizarUltimoAcceso($idUsuario) {
        try {
            $sql = "UPDATE usuarios SET ultimo_acceso = NOW() WHERE id_usuario = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$idUsuario]);
        } catch (PDOException $e) {
            error_log("Error al actualizar último acceso: " . $e->getMessage());
            return false;
        }
    }

    // Método adicional: Crear un usuario (para pruebas)
    public function crearUsuario($nombre, $email, $password) {
        try {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO usuarios (nombre, email, password_hash) VALUES (?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$nombre, $email, $passwordHash]);
        } catch (PDOException $e) {
            error_log("Error al crear usuario: " . $e->getMessage());
            return false;
        }
    }
}