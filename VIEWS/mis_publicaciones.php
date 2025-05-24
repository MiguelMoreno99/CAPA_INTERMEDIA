<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mis Publicaciones</title>
    <?php require 'PHP/cssStyles.php'; ?>
    <link rel="stylesheet" href="CSS/mis_publicaciones.css" />
</head>

<body>
    <?php require 'TEMPLATES/header.php'; ?>

    <div class="feed-header">
        <div class="filter-section">
            <!-- Buscar por título -->
            <input type="text" class="search-input" placeholder="Buscar por título" />

            <!-- Filtrar por fecha -->
            <label for="filter-date" class="filter-label">Filtrar por fecha de publicación:</label>
            <input type="date" id="filter-date" class="filter-date" />

            <!-- Filtrar por tema -->
            <label for="filter-topic" class="filter-label">Filtrar por tema:</label>
            <select id="filter-topic" class="filter-topic">
                <option value="">Seleccionar tema</option>
                <option value="Viajes">Viajes</option>
                <option value="Tecnología">Tecnología</option>
                <option value="Cultura">Cultura</option>
                <option value="Deportes">Deportes</option>
            </select>

            <!-- Botón de Filtrar -->
            <button class="btn filter">Filtrar</button>
        </div>
    </div>

    <div class="info-container">
        <div class="feed-container" id="feed-container">
        </div>
    </div>
    <div id="edit-modal" class="modal hidden">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h3>Editar publicación</h3>
    <input type="text" id="edit-titulo" placeholder="Nuevo título">
    <textarea id="edit-descripcion" placeholder="Nueva descripción"></textarea>
    <button class="btn guardar-cambios">Guardar cambios</button>
  </div>
</div>
    <?php require 'TEMPLATES/footer.php'; ?>
    <script src="JS/mis_publicaciones.js"></script>
</body>

</html>