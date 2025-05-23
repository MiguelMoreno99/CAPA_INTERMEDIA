<?php

namespace CONTROLLERS;

use MODELS\Publication;
use Core\Middleware\Middleware;

class Publicacion
{
  private $publicacion;
  private $res = [];

  public function  __construct()
  {
    $this->publicacion = new Publication();
  }

  public function cargarVistaPaginaPrincial()
  {
    Middleware::resolve('auth'); // Solo usuarios logueados podrán ver esta vista
    return view('/pagina_principal.php', [
      'heading' => "Página Principal",
    ]);
  }

  public function cargarVistaNuevaPublicacion()
  {
    Middleware::resolve('auth'); // Solo no usuarios logueados podrán ver esta vista
    return view('/nueva_publicacion.php', [
      'heading' => "Nueva publicación",
    ]);
  }

  public function cargarVistaMisPublicaciones()
  {
    Middleware::resolve('auth'); // Solo no usuarios logueados podrán ver esta vista
    return view('/mis_publicaciones.php', [
      'heading' => "Mis Publicaciones",
    ]);
  }

  public function devolverPublicaciones()
  {
    $this->res = $this->publicacion->obtenerTodasLasPublicaciones();
    header('Content-Type: application/json');
    echo json_encode($this->res);
  }

  public function devolverPublicacionesFiltradas()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    $titulo = isset($data['titulo']) && $data['titulo'] !== '' ? $data['titulo'] : null;
    $correo = isset($data['correo']) && $data['correo'] !== '' ? $data['correo'] : null;
    $fecha  = isset($data['fecha'])  && $data['fecha']  !== '' ? $data['fecha']  : null;
    $tema   = isset($data['tema'])   && $data['tema']   !== '' ? $data['tema']   : null;

    $this->res = $this->publicacion->obtenerPublicacionesFiltradas($titulo, $correo, $fecha, $tema);
    header('Content-Type: application/json');
    echo json_encode($this->res);
  }

  public function devolverPublicacionesFeed()
  {
    $this->res = $this->publicacion->obtenerTodasLasPublicacionesFeed();
    header('Content-Type: application/json');
    echo json_encode($this->res);
  }

  public function devolverPublicacionesFiltradasFeed()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    $titulo = isset($data['titulo']) && $data['titulo'] !== '' ? $data['titulo'] : null;
    $correo = null;
    $fecha  = isset($data['fecha'])  && $data['fecha']  !== '' ? $data['fecha']  : null;
    $tema   = isset($data['tema'])   && $data['tema']   !== '' ? $data['tema']   : null;

    $this->res = $this->publicacion->obtenerPublicacionesFiltradasFeed($titulo, $correo, $fecha, $tema);
    header('Content-Type: application/json');
    echo json_encode($this->res);
  }

  public function toggleFavorito()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    $id_publicacion = $data['id_publicacion'];
    $hash_correo = $_SESSION['usuario']['hash_correo'] ?? '';

    $this->res = $this->publicacion->cambiarFavorito(
      $hash_correo,
      $id_publicacion
    );

    // Devuelve la respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($this->res);
  }

  public function comentarPublicacion()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    $comentario = trim($data['comentario'] ?? '');
    $post_id = $data['post_id'] ?? null;
    $usuario = $_SESSION['usuario']['hash_correo'] ?? null;

    if (!$comentario || !$post_id || !$usuario) {
      echo json_encode(['exito' => false, 'mensaje' => 'Datos inválidos']);
      return;
    }

    try {
      $this->res = $this->publicacion->enviarComentario(
        $usuario,
        $post_id,
        $comentario
      );
      echo json_encode(['exito' => true]);
    } catch (\Exception $e) {
      echo json_encode(['exito' => false, 'mensaje' => 'Error al enviar y guardar comentario']);
    }
  }

  public function procesarNuevaPublicacion()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $titulo = $_POST['titulo'] ?? '';
      $tema = $_POST['tema'] ?? '';
      $descripcion = $_POST['descripcion'] ?? '';
      $hash_correo = $_SESSION['usuario']['hash_correo'] ?? '';

      $this->res = $this->publicacion->crearPublicacion($titulo, $tema, $descripcion, $hash_correo);
      $id_publicacion = $this->res['id_publicacion'] ?? null;

      // Procesar archivos multimedia
      $archivos = $_FILES['media'];
      if (!empty($archivos['tmp_name']) && is_array($archivos['tmp_name'])) {
        for ($i = 0; $i < count($archivos['tmp_name']); $i++) {
          if ($archivos['error'][$i] === UPLOAD_ERR_OK) {
            $tmpName = $archivos['tmp_name'][$i];
            $nombreOriginal = basename($archivos['name'][$i]);
            $nombreArchivo = uniqid() . '_' . $nombreOriginal;
            $rutaDestino = 'UserAssets/' . $nombreArchivo;

            // Mover archivo a carpeta
            if (move_uploaded_file($tmpName, $rutaDestino)) {
              // Detectar tipo
              $tipoMime = mime_content_type($rutaDestino);
              $tipo = str_starts_with($tipoMime, 'image/') ? 'imagen' : 'video';

              // Insertar ruta en la base de datos
              $this->publicacion->cargarContenidoMultimedia($id_publicacion, $tipo, $rutaDestino);
            }
          }
        }
      }
      $this->cargarVistaMisPublicaciones();
    }
  }
}