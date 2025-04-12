<?php
//session_start();
$usuario = $_SESSION['usuario'] ?? null;

if (!$usuario) {
    // Redirect to login or show error if no session
    header("Location: /login");
    exit;
}
?>
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
                <h1><?= htmlspecialchars($usuario['correo']) ?></h1>
                <img class="profilePreview2" id="profilePreview2" src="<?= htmlspecialchars($usuario['foto_perfil']) ?>"
                    alt="Foto de perfil 2" />
            </div>

            <!-- Información del usuario -->
            <div class="Info-Container">
                <div class="divInfo">
                    <form id="info_usuarioForm" method="POST" action="/usuario">
                        <div class="form-grupo">
                            <label for="nombre">Nombre(s):</label>
                            <input type="text" id="nombre" name="nombre"
                                value="<?= htmlspecialchars($usuario['nombre']) ?>" autocomplete="username" />
                            <div class="error-message"></div>
                        </div>

                        <div class="form-grupo">
                            <label for="apellido_paterno">Apellido(s):</label>
                            <input type="text" id="apellido" name="apellido"
                                value="<?= htmlspecialchars($usuario['apellido']) ?>" autocomplete="username" />
                            <div class="error-message"></div>
                        </div>

                        <div class="form-grupo">
                            <label for="nombre_usuario">Nombre usuario:</label>
                            <input type="text" id="nombre_usuario" name="nombre_usuario"
                                value="<?= htmlspecialchars($usuario['nombre_usuario']) ?>" autocomplete="username" />
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