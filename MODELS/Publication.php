<?php

namespace MODELS;

use Core\Model;

class Publication extends Model
{

  public function obtenerTodasLasPublicaciones()
  {
    $query = "CALL obtenerPublicaciones()";

    try {
      $this->db->query($query);
      $publicaciones = $this->db->get();

      foreach ($publicaciones as &$pub) {
        $id = $pub['id_publicaciones'];

        // Multimedia
        $queryMultimedia = "CALL obtenerMediaPorPublicacion(:pub_id)";
        $params = [
          'pub_id' => $id
        ];
        $this->db->query($queryMultimedia, $params);
        $pub['multimedia'] = $this->db->get();

        // IMPORTANTE: limpiar resultados pendientes si existen
        while ($this->db->nextRowset()) {
        }

        // Comentarios
        $queryComentarios = "CALL obtenerComentariosPorPublicacion(:pub_id)";
        $params = [
          'pub_id' => $id
        ];
        $this->db->query($queryComentarios, $params);
        $pub['comentarios'] = $this->db->get();

        // Limpiar resultados pendientes otra vez
        while ($this->db->nextRowset()) {
        }
      }
      return $publicaciones;
    } catch (\Exception $e) {
      echo "Error al obtener todas las publicaciones: " . $e->getMessage();
      return [];
    }
  }
}