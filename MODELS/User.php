<?php
namespace MODELS;

use Core\Model;

class User extends Model
{
  public function insertUser($correo, $contra, $nombre, $apellido, 
  $nombre_usuario, $foto_perfil, $usuario_admin, $id_usuario = null) {
    $query = "CALL insertar_usuario(:correo, :contra, :nombre, :apellido, :nombre_usuario, :foto_perfil, :usuario_administrador, :id_usuario)";

    $params = [
        'correo' => $correo ,
        'contra' => $contra, 
        'nombre' => $nombre,
        'apellido' => $apellido,
        'nombre_usuario' => $nombre_usuario,
        'foto_perfil' => $foto_perfil,
        'usuario_administrador' => $usuario_admin,
        'id_usuario' => $id_usuario 
    ];
    
    try {
        $this->db->query($query, $params); //si no jala es por esto
        echo "<script>console.log('Usuario agregado exitosamente');</script>";
    } catch (Exception $e) {
        echo "Error al agregar usuario: " . $e->getMessage();
    }
  }

  public function listUser($correo){
    $query = "CALL traer_datos_usuario(:correo)";
    $params = ['correo' => $correo];
    try{
      $this->db->query($query, $params);
      return $this->db->find();  
    }catch(Exception $e){
      echo "Error al traer usuario: " . $e->getMessage();
    }
    
  }

  public function verifyUser($correo, $contra){
    $query = "CALL verificar_usuario(:correo, :contra)";
    $params = ['correo' => $correo, 'contra' => $contra];
    try{
      $this->db->query($query, $params);
      return $this->db->find();  
    }catch(Exception $e){
      echo "Error al verificar ussuario: " . $e->getMessage();
    }
  }
    
}
