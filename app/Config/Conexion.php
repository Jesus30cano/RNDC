<?php
class Conexion {
    private $host = "localhost";
    private $db   = "rndc_db"; 
    private $user = "root";         
    private $pass = "admin123";           
    private $pdo;

    public function getConnection() {
        try {
            $this->pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->db};charset=utf8",
                $this->user,
                $this->pass
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            error_log("Conexión MySQL exitosa");
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public function getConexion() {
        return $this->pdo;
    }
}
?>
