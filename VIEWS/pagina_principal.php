<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pagina Principal</title>
    <?php require 'PHP/cssStyles.php'; ?>
    <link rel="stylesheet" href="CSS/pagina_principal.css" />
</head>

<body>
    <?php require 'TEMPLATES/header.php'; ?>

    <div class="feed-header">
        <!-- Sección de Crear Publicación -->
        <div class="create-post">
            <button class="btn create" onclick="window.location.href='nueva_publicacion'">
                Crear Publicación
            </button>
        </div>

        <!-- Separador visual -->
        <div class="filter-section">
            <!-- Buscar por título -->
            <input type="text" class="search-input" placeholder="Buscar por título" />

            <!-- Buscar por usuario -->
            <input type="text" class="search-input" placeholder="Buscar por usuario" />

            <!-- Filtrar por fecha -->
            <label for="filter-date" class="filter-label">Filtrar por fecha de publicación:</label>
            <input type="date" id="filter-date" class="filter-date" />

            <!-- Filtrar por tema -->
            <label for="filter-topic" class="filter-label">Filtrar por tema:</label>
            <select id="filter-topic" class="filter-topic">
                <option value="">Seleccionar tema</option>
                <option value="viajes">Viajes</option>
                <option value="tecnologia">Tecnología</option>
                <option value="cultura">Cultura</option>
                <option value="deportes">Deportes</option>
            </select>

            <!-- Botón de Filtrar -->
            <button class="btn filter">Filtrar</button>
        </div>
    </div>

    <div class="info-container">
        <div class="feed-container" id="feed-container">
        </div>
    </div>

    <?php require 'TEMPLATES/footer.php'; ?>
    <script src="JS/pagina_principal.js"></script>
</body>

</html>