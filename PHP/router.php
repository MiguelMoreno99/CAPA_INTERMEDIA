<?php
// Capturar la URL solicitada
$request_uri = trim($_SERVER['REQUEST_URI'], '/');

// Definir rutas disponibles
$routes = [
    '' => 'CONTROLLERS/pagina_principal.php',
    'inicio_sesion' => 'CONTROLLERS/inicio_sesion.php',
    'mensajes' => 'CONTROLLERS/mensajes.php',
    'mis_publicaciones' => 'CONTROLLERS/mis_publicaciones.php',
    'nueva_publicacion' => 'CONTROLLERS/nueva_publicacion.php',
    'pagina_principal' => 'CONTROLLERS/pagina_principal.php',
    'registro_usuario' => 'CONTROLLERS/registro_usuario.php',
    'reportes' => 'CONTROLLERS/reportes.php',
    'usuario' => 'CONTROLLERS/usuario.php',
];

// Verificar si la ruta existe
if (array_key_exists($request_uri, $routes)) {
    require $routes[$request_uri];
} else {
    http_response_code(404);
    require 'CONTROLLERS/404.php';
}