<?php

namespace MODELS;

use Core\Model;

class Report extends Model
{
  public function obtenerReporteUsuarios()
  {
    $query = "SELECT * FROM vista_reporte_usuarios";

    try {
      $this->db->query($query);
      return $this->db->get();
    } catch (\Exception $e) {
      echo "Error al traer reporte de usuarios " . $e->getMessage();
    }
  }

  public function ObtenerReportePublicaciones()
  {
    $query = "SELECT * FROM vista_reporte_publicaciones";

    try {
      $this->db->query($query);
      return $this->db->get();
    } catch (\Exception $e) {
      echo "Error al traer reporte publicaciones " . $e->getMessage();
    }
  }
}