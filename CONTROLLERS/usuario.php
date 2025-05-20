<?php

namespace CONTROLLERS;

use MODELS\User;
use SessionHandler;

class Usuario
{
  public $datos_usuario = [];
  private $usuario;
  private $res = [];

  public function  __construct()
  {
    $this->usuario = new User();
  }

  public function cargarVistaUsuarioInfo()
  {
    return view('/usuario.php', [
      'heading' => "Usuario"
    ]);
  }

  public function cargarVistaRegistro()
  {
    return view('/registro_usuario.php', [
      'heading' => "Registro de Usuario",
    ]);
  }

  public function cargarVistaReportes()
  {
    return view('/reportes.php', [
      'heading' => "Reportes",
    ]);
  }

  public function cargarVistaNuevaPublicacion()
  {
    return view('/nueva_publicacion.php', [
      'heading' => "Nueva publicación",
    ]);
  }

  public function cargarVistaMisPublicaciones()
  {
    return view('/mis_publicaciones.php', [
      'heading' => "Mis Publicaciones",
    ]);
  }

  public function cargarVistaPaginaPrincial()
  {
    return view('/pagina_principal.php', [
      'heading' => "Página Principal",
    ]);
  }

  public function cargarVistaMensajes()
  {
    return view('/mensajes.php', [
      'heading' => "Mensajes",
    ]);
  }

  public function cargarVistaContactos()
  {
    return view('/contactos.php', [
      'heading' => "Contactos",
    ]);
  }

  public function cargarVistaLogin()
  {
    session_unset();
    session_destroy();
    return view('/inicio_sesion.php', [
      'heading' => "Inicio de sesión",
    ]);
  }

  public function procesarRegistro()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $hash_correo = $_POST['hash_correo'] ?? '';
      $correo = $_POST['correo_usuario'] ?? '';
      $contra = $_POST['contrasenia_usuario'] ?? '';
      $foto = $_FILES['imagen_usuario'] ?? null;
      $rol = $_POST['rol'] ?? '0';

      // TODO: Handle file upload
      $ruta_foto = 'IMG/perfil.webp'; // Default fallback

      if ($foto && $foto['tmp_name']) {
        $nombreArchivo = uniqid() . '_' . basename($foto['name']);
        $rutaDestino = 'UserAssets/' . $nombreArchivo;

        if (move_uploaded_file($foto['tmp_name'], $rutaDestino)) {
          $ruta_foto = $rutaDestino;
        }
      }

      $this->res = $this->usuario->listUser($hash_correo);
      if (!empty($this->res)) {
        echo "<script>alert('Error, Ya hay un usuario con ese correo');</script>";
        $this->cargarVistaRegistro();
      } else {
        $this->usuario->insertUser(
          $hash_correo,
          $correo,
          $contra,
          $ruta_foto,
          $rol
        );

        safeSessionStart();
        $this->datos_usuario = $this->usuario->listUser($hash_correo);
        $_SESSION['usuario'] = $this->datos_usuario;
        echo "<script>alert('Registro completado de manera exitosa');</script>";
        $this->cargarVistaLogin();
      }
    }
  }

  public function procesarCambiosUsuario()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $hash_correo = $_SESSION['usuario']['hash_correo'] ?? '';
      $contra = $_POST['contrasenia_usuario'] ?? '';

      $this->usuario->updateUser(
        $hash_correo,
        $contra
      );

      $this->datos_usuario = $this->usuario->listUser($hash_correo);
      $_SESSION['usuario'] = $this->datos_usuario;

      echo "<script>alert('Usuario modificado exitosamente');</script>";
      $this->cargarVistaUsuarioInfo();
    }
  }

  public function verificarCredenciales()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (isset($_POST['correo_usuario']) && isset($_POST['contrasenia_usuario'])) {
        $hash_correo = $_POST['hash_correo'] ?? '';
        $contra = $_POST['contrasenia_usuario'];

        $this->res = $this->usuario->verifyUser($hash_correo, $contra);
        if (empty($this->res)) {
          echo "<script>alert('Error, Verifique sus Credenciales');</script>";
          $this->cargarVistaLogin();
        } else {
          echo "<script>alert('Inicio de sesión exitoso');</script>";
          safeSessionStart();
          $this->datos_usuario = $this->usuario->listUser($hash_correo);
          $_SESSION['usuario'] = $this->datos_usuario;
          $this->cargarVistaUsuarioInfo();
        }
      }
    }
  }
}