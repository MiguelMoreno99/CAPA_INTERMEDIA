<?php

namespace MODELS;

use Core\Model;

class Publication extends Model
{

  public function obtenerTodasLasPublicaciones()
  {
    $query = "CALL obtenerPublicaciones()";
    $hash_correo = $_SESSION['usuario']['hash_correo'] ?? '';

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

        // Ver si es favorito
        $queryFavorito = "CALL esFavorito(:hash_usuario, :publicacion_id)";
        $params = [
          'hash_usuario' => $hash_correo,
          'publicacion_id' => $id
        ];
        $this->db->query($queryFavorito, $params);
        $favorito = $this->db->get()[0]['es_favorito'] ?? 0; // 1 si es favorito, 0 si no
        $pub['es_favorito'] = $favorito;

        // Limpia el resto de resultados pendientes del procedimiento
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

  public function obtenerPublicacionesFiltradas($titulo, $correo, $fecha, $tema)
  {
    $hash_correo = $_SESSION['usuario']['hash_correo'];
    $query = "CALL obtenerPublicacionesFiltradas(:titulo, :correo, :fecha, :tema)";
    $params = [
      'titulo' => $titulo,
      'correo' => $correo,
      'fecha' => $fecha,
      'tema' => $tema
    ];

    try {
      $this->db->query($query, $params);
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

        // Ver si es favorito
        $queryFavorito = "CALL esFavorito(:hash_usuario, :publicacion_id)";
        $params = [
          'hash_usuario' => $hash_correo,
          'publicacion_id' => $id
        ];
        $this->db->query($queryFavorito, $params);
        $favorito = $this->db->get()[0]['es_favorito'] ?? 0; // 1 si es favorito, 0 si no
        $pub['es_favorito'] = $favorito;

        // Limpia el resto de resultados pendientes del procedimiento
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

  public function obtenerTodasLasPublicacionesFeed()
  {
    $hash_correo = $_SESSION['usuario']['hash_correo'];
    $query = "CALL obtenerPublicacionesFeed(:hash_usuario)";
    $params = [
      'hash_usuario' => $hash_correo
    ];

    try {
      $this->db->query($query, $params);
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

        // Ver si es favorito
        $queryFavorito = "CALL esFavorito(:hash_usuario, :publicacion_id)";
        $params = [
          'hash_usuario' => $hash_correo,
          'publicacion_id' => $id
        ];
        $this->db->query($queryFavorito, $params);
        $favorito = $this->db->get()[0]['es_favorito'] ?? 0; // 1 si es favorito, 0 si no
        $pub['es_favorito'] = $favorito;

        // Limpia el resto de resultados pendientes del procedimiento
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

  public function obtenerPublicacionesFiltradasFeed($titulo, $correo, $fecha, $tema)
  {
    $hash_correo = $_SESSION['usuario']['hash_correo'];
    $query = "CALL obtenerPublicacionesFiltradasFeed(:titulo, :correo, :fecha, :tema, :hash_usuario)";
    $params = [
      'titulo' => $titulo,
      'correo' => $correo,
      'fecha' => $fecha,
      'tema' => $tema,
      'hash_usuario' => $hash_correo
    ];

    try {
      $this->db->query($query, $params);
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

        // Ver si es favorito
        $queryFavorito = "CALL esFavorito(:hash_usuario, :publicacion_id)";
        $params = [
          'hash_usuario' => $hash_correo,
          'publicacion_id' => $id
        ];
        $this->db->query($queryFavorito, $params);
        $favorito = $this->db->get()[0]['es_favorito'] ?? 0; // 1 si es favorito, 0 si no
        $pub['es_favorito'] = $favorito;

        // Limpia el resto de resultados pendientes del procedimiento
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

  public function cambiarFavorito($hash_correo, $id_publicacion)
  {
    $query = "CALL toggleFavorito(:hash_usuario, :publicacion_id)";
    $params = [
      'hash_usuario' => $hash_correo,
      'publicacion_id' => $id_publicacion
    ];

    try {
      $this->db->query($query, $params);
      return $this->db->find();
    } catch (\Exception $e) {
      echo "Error al modificar Favorito y traer likes: " . $e->getMessage();
    }
  }

  public function enviarComentario($hash_correo, $id_publicacion, $comentario)
  {
    $query = "CALL crearComentario(:hash_usuario, :publicacion_id, :comentario)";
    $params = [
      'hash_usuario' => $hash_correo,
      'publicacion_id' => $id_publicacion,
      'comentario' => $comentario
    ];

    try {
      $this->db->query($query, $params);
    } catch (\Exception $e) {
      echo "Error al crear el comentario: " . $e->getMessage();
    }
  }

  public function crearPublicacion($titulo, $tema, $descripcion, $hash_correo)
  {
    $query = "CALL insertarPublicacion(:titulo, :tema, :descripcion, :hash_correo)";
    $params = [
      'titulo' => $titulo,
      'tema' => $tema,
      'descripcion' => $descripcion,
      'hash_correo' => $hash_correo
    ];
    try {
      $this->db->query($query, $params);
      return $this->db->find();
    } catch (\Exception $e) {
      echo "Error al crear publicacion y traer id: " . $e->getMessage();
    }
  }

  public function cargarContenidoMultimedia($publicacion_id, $tipo, $ruta_archivo)
  {
    $query = "CALL insertarContenidoMedia(:publicacion_id, :tipo, :ruta_archivo)";
    $params = [
      'publicacion_id' => $publicacion_id,
      'tipo' => $tipo,
      'ruta_archivo' => $ruta_archivo
    ];
    try {
      $this->db->query($query, $params);
    } catch (\Exception $e) {
      echo "Error al cargar contenido media: " . $e->getMessage();
    }
  }

  public function updatePost($titulo_, $descripcion_, $id_publicacion_){
    $query ="CALL editar_publicacion(:titulo_, :descripcion_, :id_publicacion_)";
     $params = [
      'titulo_' => $titulo_,
      'descripcion_' => $descripcion_,
      'id_publicacion_' => $id_publicacion_
    ];
    try {
      $this->db->query($query, $params);
    } catch (\Exception $e) {
      echo "Error al cargar contenido media: " . $e->getMessage();
    }

  }
}