<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mis Publicaciones</title>
  <link rel="stylesheet" href="CSS/GENERAL/general_styles.css" />
  <link rel="stylesheet" href="CSS/mis_publicaciones.css" />
  <link rel="stylesheet" href="CSS/GENERAL/header.css" />
  <link rel="stylesheet" href="CSS/GENERAL/footer.css" />
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

      <!-- Botón de Filtrar -->
      <button class="btn filter">Filtrar</button>
    </div>
  </div>
  <div class="feed-container">
    <div class="post">
      <div class="post-header">
        <img src="IMG/perfil.webp" alt="Usuario" />
        <div>
          <h3>Juan Pérez</h3>
          <span>Publicado el 25/02/2025</span>
        </div>
      </div>
      <h2 class="post-title">Mi nuevo viaje</h2>
      <p class="post-description">
        Compartiendo algunas fotos de mi viaje reciente. ¡Espero les guste!
      </p>

      <!-- Carrusel de imágenes/videos -->
      <div class="carousel">
        <button class="prev" onclick="changeSlide(-1, 0)">&#10094;</button>
        <div class="carousel-container">
          <div class="carousel-slide">
            <img src="IMG/SocializeLogo2.jpg" alt="Imagen 1" />
          </div>
          <div class="carousel-slide">
            <img src="IMG/SocializeLogo2.jpg" alt="Imagen 2" />
          </div>
          <div class="carousel-slide">
            <video controls>
              <source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4" />
              Tu navegador no soporta videos.
            </video>
          </div>
        </div>
        <button class="next" onclick="changeSlide(1, 0)">&#10095;</button>
      </div>

      <div class="post-footer">
        <button class="btn like-btn">👍 Me gusta <span>10</span></button>
        <button class="btn comment-btn">💬 Comentar</button>
        <button class="btn edit-btn">✏️ Editar Post</button>
      </div>
      <div class="comments-section">
        <input type="text" placeholder="Escribe un comentario..." class="comment-input" />
        <div class="comment">
          <img src="IMG/perfil.webp" alt="Usuario" />
          <p><strong>María:</strong> ¡Qué hermosas fotos!</p>
        </div>
      </div>
    </div>

    <!-- Formulario de edición -->
    <div class="edit-post-form">
      <div class="post">
        <div class="post-header">
          <img src="IMG/perfil.webp" alt="Usuario" />
          <div>
            <h3>Juan Pérez</h3>
            <span>Publicado el 25/02/2025</span>
          </div>
        </div>
        <h2 class="post-title">
          Título:
          <input type="text" id="edit-title" name="edit-title" value="Mi nuevo viaje" />
        </h2>

        <p class="post-description">
          Descripción:
          <textarea id="edit-description" name="edit-description">
Compartiendo algunas fotos de mi viaje reciente. ¡Espero les guste!</textarea>
        </p>

        <!-- Carrusel de imágenes/videos -->
        <div class="carousel">
          <label for="edit-images">Subir nuevas fotos:</label>
          <input type="file" id="edit-media" name="edit-media" accept="image/*,video/*" multiple
            onchange="previewImages(event)" />
          <div class="carousel-container" id="edit-carousel-container">
            <!-- Aquí se mostrarán las imágenes seleccionadas -->
          </div>
          <div class="buttons-edit-carousel">
            <button class="prev" onclick="changeSlide(-1, 1)">
              &#10094;
            </button>
            <button class="next" onclick="changeSlide(1, 1)">&#10095;</button>
          </div>
        </div>
        <div class="post-footer">
          <button class="btn editPost-btn">Editar Post</button>
          <button class="btn deletePost-btn">Eliminar Post</button>
          <button class="btn cancel-btn">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
  <?php require 'TEMPLATES/footer.php'; ?>
  <script src="JS/mis_publicaciones.js"></script>
</body>

</html>