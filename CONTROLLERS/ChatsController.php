<?php

namespace CONTROLLERS;

use MODELS\Contact;
use MODELS\Chats;
use Core\Middleware\Middleware;

class ChatsController {
  private $chatsModel;
  public function __construct() {
    $this->chatsModel = new Chats();
  }

  public function chat_history(){
    $hash_correo = $_GET['emisor'] ?? null;
    $hash_receptor = $_GET['receptor'] ?? null;

    if (!$hash_correo || !$hash_receptor) {
        http_response_code(400);
        echo json_encode(['error' => 'Faltan parámetros emisor o receptor']);
        return;
    }

    $this->res = $this->chatsModel->getConversation($hash_correo, $hash_receptor);
    
    // Devuelve la respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($this->res);
  }
}
