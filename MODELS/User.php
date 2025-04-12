<?php

namespace MODELS;

use Core\Model;

class User extends Model
{

  public function insertUser(
    $correo,
    $contra,
    $nombre,
    $apellido,
    $nombre_usuario,
    $foto_perfil,
    $usuario_admin,
    $id_usuario = null
  ) {
    $query = "CALL insertar_usuario(:correo, :contra, :nombre, :apellido, :nombre_usuario, :foto_perfil, :usuario_administrador, :id_usuario)";

    $hash = password_hash($contra, PASSWORD_DEFAULT);
    echo "<script>console.log('$hash');</script>";

    $params = [
      'correo' => $correo,
      'contra' => $hash,
      'nombre' => $nombre,
      'apellido' => $apellido,
      'nombre_usuario' => $nombre_usuario,
      'foto_perfil' => $foto_perfil,
      'usuario_administrador' => $usuario_admin,
      'id_usuario' => $id_usuario
    ];

    try {
      $this->db->query($query, $params);
    } catch (\Exception $e) {
      echo "Error al agregar usuario: " . $e->getMessage();
    }
  }

  public function listUser($correo)
  {
    $query = "CALL traer_datos_usuario(:correo)";
    $params = ['correo' => $correo];
    try {
      $this->db->query($query, $params);
      return $this->db->find();
    } catch (\Exception $e) {
      echo "Error al traer usuario: " . $e->getMessage();
    }
  }

  public function verifyUser($correo, $contra)
  {
    $query = "CALL traer_datos_usuario(:correo)";
    $params = ['correo' => $correo];

    try {
      $this->db->query($query, $params);
      $usuario = $this->db->find();

      if ($usuario && password_verify($contra, $usuario['contra'])) {
        // Contraseña válida
        return $usuario;
      } else {
        // Contraseña inválida
        return null;
      }
    } catch (\Exception $e) {
      echo "Error al verificar usuario: " . $e->getMessage();
    }
  }
}