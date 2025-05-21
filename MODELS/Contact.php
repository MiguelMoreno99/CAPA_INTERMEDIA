<?php

namespace MODELS;

use Core\Model;

class Contact extends Model
{
  public function obtenerContactosDisponibles($hash_correo)
  {
    $query = "CALL obtener_usuarios_disponibles(:hash_correo)";
    $params = ['hash_correo' => $hash_correo];
    try {
      $this->db->query($query, $params);
      return $this->db->get();
    } catch (\Exception $e) {
      echo "Error al traer Contactos Disponibles: " . $e->getMessage();
    }
  }

  public function obtenerContactosAgregados($hash_correo)
  {
    $query = "CALL obtener_contactos_agregados(:hash_correo)";
    $params = ['hash_correo' => $hash_correo];
    try {
      $this->db->query($query, $params);
      return $this->db->get();
    } catch (\Exception $e) {
      echo "Error al traer  Contactos Agregados: " . $e->getMessage();
    }
  }

  public function agregarContactoUsuario($hash_usuario, $hash_contacto)
  {
    $query = "CALL agregar_contacto(:hash_usuario, :hash_contacto)";
    $params = [
      'hash_usuario' => $hash_usuario,
      'hash_contacto' => $hash_contacto
    ];
    try {
      $this->db->query($query, $params);
    } catch (\Exception $e) {
      echo "Error al agregar Contacto: " . $e->getMessage();
    }
  }

  public function eliminarContactoUsuario($hash_usuario, $hash_contacto)
  {
    $query = "CALL eliminar_contacto(:hash_usuario, :hash_contacto)";
    $params = [
      'hash_usuario' => $hash_usuario,
      'hash_contacto' => $hash_contacto
    ];
    try {
      $this->db->query($query, $params);
    } catch (\Exception $e) {
      echo "Error al agregar Contacto: " . $e->getMessage();
    }
  }
}