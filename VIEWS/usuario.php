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
            <div class="Perfil-Container">
                <h1>usuario@email.com</h1>
                <img class="profilePreview" id="profilePreview" src="IMG/perfil.webp" alt="Foto de perfil" />
                <span class="edit-icon" onclick="document.getElementById('foto').click();">✏️</span>
                <input type="file" id="foto" name="imagen_usuario" accept="image/*" onchange="loadFile(event)" hidden />
            </div>

            <!-- Información del usuario -->
            <div class="Info-Container">
                <div class="divInfo">
                    <form id="info_usuarioForm">
                        <div class="form-grupo">
                            <label for="nombre">Nombre(s):</label>
                            <input type="text" id="nombre" name="nombre_usuario" value="Juan Alberto"
                                autocomplete="username" />
                            <div class="error-message"></div>
                        </div>

                        <div class="form-grupo">
                            <label for="apellido_paterno">Apellido paterno:</label>
                            <input type="text" id="apellido_paterno" name="apellido_paterno" value="Pérez"
                                autocomplete="username" />
                            <div class="error-message"></div>
                        </div>

                        <div class="form-grupo">
                            <label for="apellido_materno">Apellido materno:</label>
                            <input type="text" id="apellido_materno" name="apellido_materno" value="Rodriguez"
                                autocomplete="username" />
                            <div class="error-message"></div>
                        </div>

                        <div class="form-grupo">
                            <label for="password">Nueva Contraseña:</label>
                            <input type="password" id="password" name="contrasenia_usuario"
                                autocomplete="new-password" />
                            <div class="error-message"></div>
                        </div>

                        <div class="form-grupo">
                            <label for="confirm_password">Confirmar Contraseña:</label>
                            <input type="password" id="confirm_password" name="confirm_contrasenia"
                                autocomplete="new-password" />
                            <div class="error-message"></div>
                        </div>

                        <button type="submit" class="btn guardar_cambios" id="guardar_cambiosBtn">Guardar
                            Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <?php require 'TEMPLATES/footer.php'; ?>
    <script src="JS/usuario.js"></script>
</body>

</html>