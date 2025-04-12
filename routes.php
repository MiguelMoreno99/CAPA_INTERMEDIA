<?php
use CONTROLLERS\Usuario;
//return [
//    '/' => 'controllers/index.php',
//    '/about' => 'controllers/about.php',
//    '/contact' => 'controllers/contact.php',
//    '/notes' => 'controllers/notes.php',
//    '/note' => 'controllers/note.php',
//    '/note/create' => 'controllers/note-create.php',
//];

$router->get('/', 'CONTROLLERS/pagina_principal.php');
$router->get('/inicio_sesion', [Usuario::class, 'logIn']);
$router->post('/inicio_sesion', [Usuario::class, 'verificarCredenciales']);

$router->get('/mensajes', 'CONTROLLERS/mensajes.php');

//$router->get('/contactos', 'CONTROLLERS/contactos.php')->only('auth');
$router->get('/contactos', 'CONTROLLERS/contactos.php');
$router->get('/mis_publicaciones', 'CONTROLLERS/mis_publicaciones.php');
$router->get('/nueva_publicacion', 'CONTROLLERS/nueva_publicacion.php');

$router->get('/pagina_principal', 'CONTROLLERS/pagina_principal.php');
$router->get('/registro_usuario', [Usuario::class, 'usuarioRegistro']);
$router->post('/registro_usuario', [Usuario::class, 'procesarRegistro']);

$router->get('/reportes', 'CONTROLLERS/reportes.php');
$router->get('/usuario', [Usuario::class, 'usuarioInfo']);

//$router->get('/register', 'controllers/registration/create.php')->only('guest');
//$router->post('/register', 'controllers/registration/store.php');