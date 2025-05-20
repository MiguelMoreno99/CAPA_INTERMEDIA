<?php

namespace MODELS;

use Core\Model;

class User extends Model
{

  public function insertUser(
    $hash_correo,
    $correo,
    $contra,
    $foto_perfil,
    $tipo_usuario
  ) {

    $query = "CALL insertar_usuario(:hash_correo, :correo, :contra, :foto_perfil, :tipo_usuario)";

    $hash = password_hash($contra, PASSWORD_DEFAULT);

    $params = [
      'hash_correo' => $hash_correo,
      'correo' => $correo,
      'contra' => $hash,
      'foto_perfil' => $foto_perfil,
      'tipo_usuario' => $tipo_usuario
    ];

    try {
      $this->db->query($query, $params);
    } catch (\Exception $e) {
      echo "Error al agregar usuario: " . $e->getMessage();
    }
  }

  public function updateUser(
    $hash_correo,
    $contra
  ) {
    $query = "CALL editar_datos_usuario(:hash_correo, :contra)";

    $hash = password_hash($contra, PASSWORD_DEFAULT);

    $params = [
      'hash_correo' => $hash_correo,
      'contra' => $hash
    ];

    try {
      $this->db->query($query, $params);
    } catch (\Exception $e) {
      echo "Error al modificar usuario: " . $e->getMessage();
    }
  }

  public function listUser($hash_correo)
  {
    $query = "CALL traer_datos_usuario(:hash_correo)";
    $params = ['hash_correo' => $hash_correo];
    try {
      $this->db->query($query, $params);
      return $this->db->find();
    } catch (\Exception $e) {
      echo "Error al traer usuario: " . $e->getMessage();
    }
  }

  public function verifyUser($hash_correo, $contra)
  {
    $query = "CALL traer_datos_usuario(:hash_correo)";
    $params = ['hash_correo' => $hash_correo];

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