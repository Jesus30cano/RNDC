<?php
// Iniciar sesión siempre desde el index
session_start();

// Cargar controlador y acción por defecto
$controlador = isset($_GET['c']) ? $_GET['c'] : 'login';
$accion      = isset($_GET['a']) ? $_GET['a'] : 'index';

// Capitalizar correctamente el nombre del controlador
$nombreControlador = ucfirst(strtolower($controlador)) . 'Controller';

// Ruta del controlador (nota: tu carpeta se llama "Controllers")
$rutaControlador = __DIR__ . "/app/Controllers/" . $nombreControlador . ".php";

// Verificamos si existe
if (file_exists($rutaControlador)) {
    require_once $rutaControlador;

    // Instanciamos la clase
    $objControlador = new $nombreControlador();

    // Verificamos si el método existe
    if (method_exists($objControlador, $accion)) {
        $objControlador->$accion();
    } else {
        die("❌ Acción '$accion' no encontrada en el controlador '$nombreControlador'.");
    }
} else {
    die("❌ Controlador '$nombreControlador' no encontrado en: $rutaControlador");
}
?>