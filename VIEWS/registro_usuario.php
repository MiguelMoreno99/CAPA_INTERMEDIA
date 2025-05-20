<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registro de Usuario</title>
    <?php require 'PHP/cssStyles.php'; ?>
    <link rel="stylesheet" href="CSS/registro_usuario.css" />
</head>

<body>
    <?php require 'TEMPLATES/header.php'; ?>
    <main class="registro-contenedor">
        <div class="registro-caja">
            <h2>Registro de Usuario</h2>
            <h4>Debes de contar con una cuenta activa de GRAVATAR para poder continuar</h4>

            <form id="registro_usuarioForm" method="POST" action="/registro_usuario" enctype="multipart/form-data">
                <div class="form-grupo">
                    <label for="correo_usuario">Correo electrónico:</label>
                    <input type="email" id="correo_usuario" name="correo_usuario" autocomplete="username"
                        placeholder="Correo Electronico" />
                    <input type="hidden" id="hash_correo" name="hash_correo" />
                    <div class="error-message"></div>
                </div>
                <div class="form-grupo">
                    <label for="contrasenia_usuario">Contraseña:</label>
                    <input type="password" id="contrasenia_usuario" name="contrasenia_usuario"
                        autocomplete="new-password" placeholder="Contraseña" />
                    <div class="error-message"></div>
                </div>
                <div class="form-grupo">
                    <label for="confirmar_contrasenia">Confirmar contraseña:</label>
                    <input type="password" id="confirmar_contrasenia" name="confirmar_contrasenia"
                        autocomplete="new-password" placeholder="Confirmar Contraseña" />
                    <div class="error-message"></div>
                </div>
                <div class="form-grupo">
                    <div class="radio-grupo" id="radio-grupo">
                        <label for="adminRadioInput">
                            <input type="radio" id="adminRadioInput" name="rol" value="1" />
                            Usuario Administrador
                        </label>
                        <label for="usuarioRadioInput">
                            <input type="radio" id="usuarioRadioInput" name="rol" value="0" />
                            Usuario Normal
                        </label>
                    </div>
                    <div class="error-message"></div>
                </div>
                <div class="form-grupo">
                    <img class="profilePreview" id="profilePreview" src="IMG/perfil.webp" alt="Foto de perfil" />
                    <input type="file" id="foto" name="imagen_usuario" accept="image/*" placeholder="Foto Perfil" />
                    <div class="error-message"></div>
                </div>
                <button type="submit" id="registerBtn" class="btn">
                    Registrarse
                </button>
            </form>
            <div class="form-grupo">
                <br><br><label>¿No tienes una cuenta de GRAVATAR?</label>
                <a href="https://bit.ly/45io7lK">Da clic aquí</a>
            </div>
        </div>
    </main>

    <?php require 'TEMPLATES/footer.php'; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <script src="JS/registro_usuario.js"></script>
</body>

</html>