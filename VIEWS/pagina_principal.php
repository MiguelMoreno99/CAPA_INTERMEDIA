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
        <div class="feed-container">
            <div class="post">
                <div class="post-header">
                    <img src="IMG/perfil.webp" alt="Usuario" />
                    <div>
                        <h3>Juan Pérez</h3>
                        <span>Publicado el 25/02/2025</span>
                    </div>
                    <div class="post-topic">
                        <h5>Tema:</h5>
                        <span>Viajes</span>
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
                </div>
                <div class="comments-section">
                    <input type="text" placeholder="Escribe un comentario..." class="comment-input" />
                    <div class="comment">
                        <img src="IMG/perfil.webp" alt="Usuario" />
                        <p><strong>María:</strong> ¡Qué hermosas fotos!</p>
                    </div>
                </div>
            </div>

            <div class="post">
                <div class="post-header">
                    <img src="IMG/perfil.webp" alt="Usuario" />
                    <div>
                        <h3>Miguel Gonzalez</h3>
                        <span>Publicado el 05/01/2025</span>
                    </div>
                    <div class="post-topic">
                        <h5>Tema:</h5>
                        <span>Deportes</span>
                    </div>
                </div>
                <h2 class="post-title">Ganadores Sorteo</h2>
                <p class="post-description">Gracias a todos los que participaron!</p>

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
                    <button class="btn like-btn">👍 Me gusta <span>4</span></button>
                    <button class="btn comment-btn">💬 Comentar</button>
                </div>
                <div class="comments-section">
                    <input type="text" placeholder="Escribe un comentario..." class="comment-input" />
                    <div class="comment">
                        <img src="IMG/perfil.webp" alt="Usuario" />
                        <p><strong>Juan:</strong> Saludos a la tía</p>
                    </div>
                    <div class="comment">
                        <img src="IMG/perfil.webp" alt="Usuario" />
                        <p><strong>Alex:</strong> ¡Saludos!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require 'TEMPLATES/footer.php'; ?>
    <script src="JS/pagina_principal.js"></script>
</body>

</html>