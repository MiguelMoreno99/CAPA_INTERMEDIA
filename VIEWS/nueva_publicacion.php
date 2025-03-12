<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mis Publicaciones</title>
    <?php require 'PHP/cssStyles.php'; ?>
    <link rel="stylesheet" href="CSS/nueva_publicacion.css" />
</head>

<body>
    <?php require 'TEMPLATES/header.php'; ?>
    <div class="feed-container">
        <!-- Formulario de edición -->
        <div class="edit-post-form">
            <div class="post">
                <div class="post-header">
                    <img src="IMG/perfil.webp" alt="Usuario" />
                    <div>
                        <h3>Juan Pérez</h3>
                    </div>
                </div>
                <h2 class="post-title">
                    Título:
                    <input type="text" id="edit-title" name="edit-title" value="Mi nuevo viaje" />
                </h2>

                <p class="post-description">
                    Descripción:
                    <textarea id="edit-description" name="edit-description">
            Compartiendo algunas fotos de mi viaje reciente. ¡Espero les guste!
          </textarea>
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
                        <button class="prev" onclick="changeSlide(-1, 0)">
                            &#10094;
                        </button>
                        <button class="next" onclick="changeSlide(1, 0)">&#10095;</button>
                    </div>
                </div>
                <div class="post-footer">
                    <button class="btn crearPost-btn">Crear Post</button>
                    <button class="btn cancel-btn" onclick="window.history.back();">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php require 'TEMPLATES/footer.php'; ?>
    <script src="JS/nueva_publicacion.js"></script>
</body>

</html>