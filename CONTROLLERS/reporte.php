<?php

namespace CONTROLLERS;

use MODELS\Report;
use Core\Middleware\Middleware;

class Reporte
{
  private $reporte;
  private $res = [];

  public function  __construct()
  {
    $this->reporte = new Report();
  }

  public function cargarVistaReportes()
  {
    Middleware::resolve('admin'); // Solo usuarios admin logueados podrán ver esta vista
    return view('/reportes.php', [
      'heading' => "Reportes",
    ]);
  }

  public function devolverReporteUsuarios()
  {
    $this->res = $this->reporte->obtenerReporteUsuarios();
    header('Content-Type: application/json');
    echo json_encode($this->res);
  }

  public function devolverReportePublicaciones()
  {
    $this->res = $this->reporte->ObtenerReportePublicaciones();
    header('Content-Type: application/json');
    echo json_encode($this->res);
  }
}