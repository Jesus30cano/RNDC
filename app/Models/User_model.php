<?php
require_once __DIR__ . '/../Config/Conexion.php';

class Usuario {
    private $pdo;

    public function __construct() {
        $conexion = new Conexion();
        $conexion->getConnection();
        $this->pdo = $conexion->getConexion();
    }

    public function obtenerUsuarioPorCorreo($correo) {
        $sql = "SELECT id_usuario, nombre, correo, password_hash FROM usuarios WHERE correo = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$correo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
