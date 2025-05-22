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

  public function devolverPublicaciones()
  {
    $this->res = $this->publicacion->obtenerTodasLasPublicaciones();
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
}
