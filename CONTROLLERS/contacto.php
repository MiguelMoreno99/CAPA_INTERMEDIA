<?php

namespace CONTROLLERS;

use MODELS\Contact;
use Core\Middleware\Middleware;

class Contacto
{
  private $contacto;
  private $res = [];

  public function  __construct()
  {
    $this->contacto = new Contact();
  }

  public function cargarVistaContactos()
  {
    Middleware::resolve('auth'); // Solo usuarios logueados podrán ver esta vista
    return view('/contactos.php', [
      'heading' => "Contactos",
    ]);
  }

  public function devolverContactosDisponibles()
  {
    $hash_correo = $_SESSION['usuario']['hash_correo'] ?? '';
    $this->res = $this->contacto->obtenerContactosDisponibles($hash_correo);

    // Devuelve la respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($this->res);
  }

  public function devolverContactosUsuario()
  {
    $hash_correo = $_SESSION['usuario']['hash_correo'] ?? '';
    $this->res = $this->contacto->obtenerContactosAgregados($hash_correo);

    // Devuelve la respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($this->res);
  }

  public function agregarContacto()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    $hash_usuario = $_SESSION['usuario']['hash_correo'];
    $hash_contacto = $data['hash_contacto'];
    $this->contacto->agregarContactoUsuario($hash_usuario, $hash_contacto);
  }

  public function eliminarContacto()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    $hash_usuario = $_SESSION['usuario']['hash_correo'];
    $hash_contacto = $data['hash_contacto'];
    $this->contacto->eliminarContactoUsuario($hash_usuario, $hash_contacto);
  }
}