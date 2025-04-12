<?php
namespace CONTROLLERS;

use MODELS\User;

class Usuario{
  public $datos_usuario = [];
  private $usuario;
  private $res = [];

  public function  __construct(){
    $this->usuario = new User();
  }

  public function usuarioInfo(){
    return view('/usuario.php',[
      'heading' => "Usuario"
    ]);
  } 

  public function usuarioRegistro(){
    return view('/registro_usuario.php',[
      'heading' => "Registro de Usuario",
    ]);
  } 

  public function logIn(){
    session_unset();
    session_destroy();
    return view('/inicio_sesion.php',[
      'heading' => "Inicio de sesión",
    ]);
  }

  public function procesarRegistro(){
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
          $nombre = $_POST['nombre'] ?? '';
          $apellido = $_POST['apellido_paterno'] ?? '';
          $correo = $_POST['correo_usuario'] ?? '';
          $contra = $_POST['contrasenia_usuario'] ?? '';
          $nombre_usuario = $_POST['nombre_usuario'] ?? '';
            //$confirm_contra = $_POST['confirm_contrasenia'] ?? '';
          $rol = $_POST['rol'] ?? '0'; //usuario normal se manda como 0
          $foto = $_FILES['imagen_usuario'] ?? null;
          //agregar una validacion para ver que no haya campos vacios

            // TODO: Handle file upload
          $ruta_foto = 'IMG/perfil.webp'; // Default fallback

          if($foto && $foto['tmp_name']) {
              $nombreArchivo = uniqid() . '_' . basename($foto['name']);
              $rutaDestino = 'UserAssets/' . $nombreArchivo;

              if(move_uploaded_file($foto['tmp_name'], $rutaDestino)){
                  $ruta_foto = $rutaDestino;
              }
            }

            //funcion para incrementar el id del usuario

          
            //print($contra);
          $this->usuario->insertUser(
              $correo,
              $contra,
              $nombre,
              $apellido,
              $nombre_usuario,
              $ruta_foto,
              $rol
                //poner el id si se ocupa
            );

             // Redirect or return success view
            return view('/pagina_principal.php', [
                'heading' => 'Página Principal'
            ]); 
        }

        // In case of direct access or failure
        return view('/registro_usuario.php', [
            'heading' => 'Registro de Usuario',
            'error' => 'Método inválido.'
        ]);
  }

  public function verificarCredenciales(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
      if(isset($_POST['correo_usuario']) && isset($_POST['contrasenia_usuario'])){
        $correo = $_POST['correo_usuario'];
        $contra = $_POST['contrasenia_usuario'];

        $this->res = $this->usuario->verifyUser($correo, $contra);
        $value = array_values($this->res)[0];
        //echo $value;
        if($value == 1){
          safeSessionStart(); 
          $this->datos_usuario = $this->usuario->listUser($correo);
          $_SESSION['usuario'] = $this->datos_usuario;
          //print_r($this->datos_usuario);
            return view('/pagina_principal.php',[
            'heading' => "Página Principal",
          ]); 
        }
        else{
          $this->logIn();
        }  
      }
    }
  }

  /* public function traerInfoUsuario(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
      if(isset($_POST['correo_usuario'])){
        $correo = $_POST['correo_usuario']
      }
    }
  } */


}
//sumar el id de usuario

//require 'VIEWS/usuario.php';