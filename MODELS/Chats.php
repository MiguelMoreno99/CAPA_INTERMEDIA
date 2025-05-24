<?php

namespace MODELS;

use Core\Model;

class Chats extends Model {
  public function saveMessage($emisor, $receptor, $texto) {
        $query = "CALL insertar_mensajes(:hash_emisor, :hash_receptor, :texto);";
        
        try {
            $params = [
               'hash_emisor' => $emisor,
               'hash_receptor' => $receptor,
               'texto' => $texto
            ];
            
            return $this->db->query($query, $params);
        } catch (Exception $e) {
            error_log("Error saving message: " . $e->getMessage());
            return false;
        }
    }
    
    public function getConversation($user1, $user2) {
      //echo "estoy dentro de mi MODEL CHATS";
        $query = "CALL obtener_mensajes(:hash_emisor, :hash_receptor);";       
        try {
            $params = [
               'hash_emisor' => $user1,
               'hash_receptor' => $user2

            ];
            
            $this->db->query($query, $params);
            return $this->db->get();
        } catch (\Exception $e) {
        echo "Error al traer mensajes Disponibles: " . $e->getMessage();
      }
      }
}
