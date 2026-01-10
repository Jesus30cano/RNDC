<?php
require_once __DIR__ . '/../Config/conexion.php';

class ManifiestoModel {
    private $pdo;

    public function __construct() {
        $conexion = new Conexion();
        $conexion->getConnection(); // Esto inicializa la conexión
        $this->pdo = $conexion->getConexion(); // Esto obtiene el objeto PDO
    }


    
}