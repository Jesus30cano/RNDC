<?php
require_once __DIR__ . '/../Config/Conexion.php';

class Usuario {
    private $pdo;

    public function __construct() {
        $conexion = new Conexion();
        $conexion->getConnection();
        $this->pdo = $conexion->getConexion();
    }

    public function obtenerUsuarios() {
        $sql = "SELECT id_usuario, nombre, email FROM usuarios";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
