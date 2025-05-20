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
            <div class="Perfil-Container" id="Perfil-Container">
                <h1 id="correoUsuario"><?= htmlspecialchars($usuario['correo']) ?></h1>
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