<?php
// Usuario
use CONTROLLERS\Usuario;

$router->get('/', [Usuario::class, 'cargarVistaLogin']);

$router->get('/usuario', [Usuario::class, 'cargarVistaUsuarioInfo']);
$router->post('/usuario', [Usuario::class, 'procesarCambiosUsuario']);

$router->get('/registro_usuario', [Usuario::class, 'cargarVistaRegistro']);
$router->post('/registro_usuario', [Usuario::class, 'procesarRegistro']);

$router->get('/inicio_sesion', [Usuario::class, 'cargarVistaLogin']);
$router->post('/inicio_sesion', [Usuario::class, 'verificarCredenciales']);

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

$router->get('/nueva_publicacion', [Publicacion::class, 'cargarVistaNuevaPublicacion']);
$router->get('/mis_publicaciones', [Publicacion::class, 'cargarVistaMisPublicaciones']);
$router->post('/mis_publicaciones', [Publicacion::class, 'procesarNuevaPublicacion']);
//API Publicaciones
$router->get('/api/publicaciones', [Publicacion::class, 'devolverPublicaciones']);
$router->get('/api/publicacionesFeed', [Publicacion::class, 'devolverPublicacionesFeed']);
$router->post('/api/toggle_favorito', [Publicacion::class, 'toggleFavorito']);
$router->post('/api/crear_comentario', [Publicacion::class, 'comentarPublicacion']);
$router->post('/api/publicaciones_filtradas', [Publicacion::class, 'devolverPublicacionesFiltradas']);
$router->post('/api/publicaciones_filtradasFeed', [Publicacion::class, 'devolverPublicacionesFiltradasFeed']);
$router->post('/api/editar_publicacion', [Publicacion::class, 'editarPublicaciones']);

//Reporte
use CONTROLLERS\Reporte;

$router->get('/reportes', [Reporte::class, 'cargarVistaReportes']);
//API Reportes
$router->get('/api/reporte_usuarios', [Reporte::class, 'devolverReporteUsuarios']);
$router->get('/api/reporte_publicaciones', [Reporte::class, 'devolverReportePublicaciones']);

//PENDIENTE HACER MENSAJES
use CONTROLLERS\ChatsController;

$router->get('/mensajes', [Usuario::class, 'cargarVistaMensajes']);
$router->get('/api/cargar_mensajes', [ChatsController::class, 'chat_history']);
