<?php
// Usuario
use CONTROLLERS\Usuario;

$router->get('/', [Usuario::class, 'cargarVistaLogin']);
$router->get('/inicio_sesion', [Usuario::class, 'cargarVistaLogin']);
$router->get('/usuario', [Usuario::class, 'cargarVistaUsuarioInfo']);
$router->get('/registro_usuario', [Usuario::class, 'cargarVistaRegistro']);

$router->post('/usuario', [Usuario::class, 'procesarCambiosUsuario']);
$router->post('/registro_usuario', [Usuario::class, 'procesarRegistro']);
$router->post('/inicio_sesion', [Usuario::class, 'verificarCredenciales']);

$router->get('/reportes', [Usuario::class, 'cargarVistaReportes']);
$router->get('/nueva_publicacion', [Usuario::class, 'cargarVistaNuevaPublicacion']);
$router->get('/mis_publicaciones', [Usuario::class, 'cargarVistaMisPublicaciones']);
$router->get('/mensajes', [Usuario::class, 'cargarVistaMensajes']);


// Contacto
use CONTROLLERS\Contacto;

$router->get('/contactos', [Contacto::class, 'cargarVistaContactos']);
//API Contactos
$router->get('/api/contactos_disponibles', [Contacto::class, 'devolverContactosDisponibles']);
$router->get('/api/contactos_agregados', [Contacto::class, 'devolverContactosUsuario']);
$router->post('/api/agregar_contacto', [Contacto::class, 'agregarContacto']);
$router->post('/api/eliminar_contacto', [Contacto::class, 'eliminarContacto']);

// Publicacion
use CONTROLLERS\Publicacion;

$router->get('/pagina_principal', [Publicacion::class, 'cargarVistaPaginaPrincial']);
//API Publicaciones
$router->get('/api/publicaciones', [Publicacion::class, 'devolverPublicaciones']);