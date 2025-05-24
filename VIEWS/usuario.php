<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Perfil</title>
    <?php require 'PHP/cssStyles.php'; ?>
    <link rel="stylesheet" href="/CSS/usuario.css" />
</head>

<body>
    <?php require 'TEMPLATES/header.php'; ?>

    <main class="registro-contenedor">
        <div class="registro-caja">
            <!-- Cabecera del perfil -->
            <div class="Perfil-Container" id="Perfil-Container">
                <!-- Foto y Correo del perfil -->
                <div class="Foto-Container" id="Foto-Container">
                    <h1 id="correoUsuario"><?= htmlspecialchars($_SESSION['usuario']['correo']) ?></h1>
                </div>
                <!-- Cambio de contraseña -->
                <form id="actualizar_usuarioForm" method="POST" action="/usuario" enctype="multipart/form-data">
                    <div class="Contrasenia-Container" id="Contrasenia-Container">
                        <h1>Actualiza tu contraseña:</h1>
                        <div class="form-grupo">
                            <label for="contrasenia">Contraseña:</label>
                            <input type="password" id="contrasenia" placeholder="Nueva contraseña" name="contrasenia"
                                autocomplete="new-password" />
                            <div class="error-message"></div>
                        </div>
                        <div class="form-grupo">
                            <label for="confirmarContrasenia">Confirmar Contraseña:</label>
                            <input type="password" id="confirmarContrasenia" placeholder="Confirmar contraseña"
                                name="confirmarContrasenia" autocomplete="new-password" />
                            <div class="error-message"></div>
                        </div>
                        <div class="form-grupo">
                            <button type="submit" id="guardar_cambiosBtn" class="btn">Actualizar Contraseña</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Información del usuario -->
            <div class="Info-Container" id="Info-Container">
            </div>
        </div>
    </main>

    <?php require 'TEMPLATES/footer.php'; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <script src="JS/usuario.js"></script>
</body>

</html>