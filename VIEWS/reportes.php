<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reportes</title>
    <?php require 'PHP/cssStyles.php'; ?>
    <link rel="stylesheet" href="CSS/reportes.css" />
</head>

<body>
    <?php require 'TEMPLATES/header.php'; ?>

    <div class="info-container">
        <div class="report-container">
            <h2>Reporte de Usuarios Registrados</h2>
            <p>Total de usuarios: <span id="total-usuarios">0</span></p>
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Nombre Completo</th>
                        <th>Correo</th>
                        <th>Último Ingreso</th>
                    </tr>
                </thead>
                <tbody id="usuarios-lista">
                    <!-- Aquí se llenará la lista de usuarios -->
                </tbody>
            </table>
        </div>

        <div class="report-container">
            <h2>Reporte de Posts Registrados</h2>
            <p>Total de posts: <span id="total-posts">0</span></p>
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Usuario</th>
                        <th>Fecha de Creación</th>
                    </tr>
                </thead>
                <tbody id="posts-lista">
                    <!-- Aquí se llenará la lista de posts -->
                </tbody>
            </table>
        </div>
    </div>

    <?php require 'TEMPLATES/footer.php'; ?>
    <script src="JS/reportes.js"></script>
</body>

</html>