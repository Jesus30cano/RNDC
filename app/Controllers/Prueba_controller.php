<?php
require_once __DIR__ . '/../Models/Prueba_model.php';

class PruebaController {
    public function index() {
        $usuarioModel = new Usuario();
        $usuarios = $usuarioModel->obtenerUsuarios();
        require __DIR__ . '/../Views/login.php';
    }

    
}

