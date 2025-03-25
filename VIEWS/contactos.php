<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contactos</title>
    <?php require 'PHP/cssStyles.php'; ?>
    <link rel="stylesheet" href="CSS/contactos.css" />
</head>

<body>
    <?php require 'TEMPLATES/header.php'; ?>
    <main class="registro-contenedor">
        <div class="registro-caja">
            <div class="container">
                <h2>Mis Contactos</h2>
                <ul id="mis-contactos" class="contact-list"></ul>

                <h2>Contactos Disponibles</h2>
                <ul id="usuarios-disponibles" class="contact-list"></ul>
            </div>
        </div>
    </main>

    <?php require 'TEMPLATES/footer.php'; ?>
    <script src="JS/contactos.js"></script>
</body>

</html>