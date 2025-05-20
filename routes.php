<?php

use CONTROLLERS\Usuario;

$router->get('/', [Usuario::class, 'cargarVistaLogin']);

$router->get('/usuario', [Usuario::class, 'cargarVistaUsuarioInfo']);
$router->post('/usuario', [Usuario::class, 'procesarCambiosUsuario']);

$router->get('/registro_usuario', [Usuario::class, 'cargarVistaRegistro']);
$router->post('/registro_usuario', [Usuario::class, 'procesarRegistro']);

$router->get('/reportes', [Usuario::class, 'cargarVistaReportes']);

$router->get('/nueva_publicacion', [Usuario::class, 'cargarVistaNuevaPublicacion']);

$router->get('/mis_publicaciones', [Usuario::class, 'cargarVistaMisPublicaciones']);

$router->get('/pagina_principal', [Usuario::class, 'cargarVistaPaginaPrincial']);

$router->get('/mensajes', [Usuario::class, 'cargarVistaMensajes']);

$router->get('/contactos', [Usuario::class, 'cargarVistaContactos']);

$router->get('/inicio_sesion', [Usuario::class, 'cargarVistaLogin']);
$router->post('/inicio_sesion', [Usuario::class, 'verificarCredenciales']);
