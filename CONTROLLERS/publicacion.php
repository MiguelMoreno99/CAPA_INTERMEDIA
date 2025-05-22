<?php

namespace CONTROLLERS;

use MODELS\Publication;
use SessionHandler;

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
}