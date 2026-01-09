<?php
require_once __DIR__ . '/../Models/dashboardModel.php';

class DashboardController {
    
    public function index() {
        
        require __DIR__ . '/../Views/dashboard.php';
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