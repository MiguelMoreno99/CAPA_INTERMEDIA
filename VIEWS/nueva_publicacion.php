<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nueva Publicación</title>
    <?php require 'PHP/cssStyles.php'; ?>
    <link rel="stylesheet" href="CSS/nueva_publicacion.css" />
</head>

<body>
    <?php require 'TEMPLATES/header.php'; ?>

    <div class="info-container">
        <div class="feed-container">
            <form class="edit-post-form" id="crear-post-form" method="POST" action="/mis_publicaciones"
                enctype="multipart/form-data">
                <div class="post">
                    <div class="post-header">
                        <a href="https://www.gravatar.com/<?= htmlspecialchars($_SESSION['usuario']['hash_correo']) ?>"
                            target="_blank">
                            <img src="https://www.gravatar.com/avatar/<?= htmlspecialchars($_SESSION['usuario']['hash_correo']) ?>"
                                alt="Usuario" />
                        </a>
                        <div>
                            <h3><?= htmlspecialchars($_SESSION['usuario']['correo']) ?></h3>
                        </div>
                    </div>

                    <div class="form-grupo">
                        <h2 class="post-title">
                            Título:
                        </h2>
                        <input type="text" id="edit-title" name="titulo" />
                        <div class="error-message"></div>
                    </div>

                    <div class="form-grupo">
                        <h4 class="post-title">
                            Categoría:
                        </h4>
                        <select id="filter-topic" class="filter-topic" name="tema">
                            <option value="">Seleccionar Categoría</option>
                            <option value="1">Viajes</option>
                            <option value="3">Tecnología</option>
                            <option value="4">Cultura</option>
                            <option value="2">Deportes</option>
                        </select>
                        <div class="error-message"></div>
                    </div>

                    <div class="form-grupo">
                        <p class="post-description" id="post-description">
                            Descripción:
                        </p>
                        <textarea id="edit-description" name="descripcion"></textarea>
                        <div class="error-message"></div>
                    </div>

                    <!-- Carrusel de imágenes/videos -->
                    <div class="carousel">
                        <label for="edit-media">Subir nuevas fotos y/o videos (Opcional): </label>
                        <input type="file" id="edit-media" name="media[]" accept="image/*,video/*" multiple
                            onchange="previewImages(event)" />
                        <div class="carousel-container" id="edit-carousel-container"></div>

                        <div class="buttons-edit-carousel" style="display: none;">
                            <button type="button" class="prev" onclick="changeSlide(-1, 0)">&#10094;</button>
                            <button type="button" class="next" onclick="changeSlide(1, 0)">&#10095;</button>
                        </div>
                    </div>

                    <div class="post-footer">
                        <button class="btn crearPost-btn" id="crearPostBtn" type="submit">Crear Post</button>
                        <button class="btn cancel-btn" type="button" onclick="window.history.back();">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php require 'TEMPLATES/footer.php'; ?>
    <script src="JS/nueva_publicacion.js"></script>
</body>

</html>