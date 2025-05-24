use capa_intermedia;

DELIMITER $$ 
CREATE PROCEDURE `insertar_usuario`(
    IN hash_correo_ VARCHAR(255),
    IN correo_ VARCHAR(255),
    IN contra_ VARCHAR(255),
    IN fotoperfil_ MEDIUMTEXT,
    IN tipo_usuario_ tinyint
)
BEGIN
    INSERT INTO Usuarios (hash_correo, correo, contra, foto_perfil, tipo_usuario) 
    VALUES(hash_correo_, correo_, contra_, fotoperfil_, tipo_usuario_);
END$$
DELIMITER ;

DELIMITER $$ 
CREATE PROCEDURE `traer_datos_usuario`(
    IN hash_correo_ VARCHAR(255) 
)
BEGIN
    SELECT hash_correo, correo, contra, foto_perfil, tipo_usuario
    FROM Usuarios
    WHERE hash_correo = hash_correo_;
END$$
DELIMITER ;

DELIMITER $$ 
CREATE PROCEDURE `editar_datos_usuario`(
    IN hash_correo_ VARCHAR(255),
    IN contra_ VARCHAR(255)
)
BEGIN
    UPDATE Usuarios
    SET 
		contra = CASE WHEN contra_ != '' THEN contra_ ELSE contra END
    WHERE hash_correo = hash_correo_;
END$$
DELIMITER ;

DELIMITER $$ 
CREATE PROCEDURE `verificar_usuario`(
   IN hash_correo_ varchar(255), 
    IN contra_ varchar(255)
)
BEGIN
    SELECT EXISTS(
        SELECT 1
        FROM Usuarios
        WHERE hash_correo = hash_correo_ AND contra = contra_
        ) AS is_valid; -- el nombre de mi columna 
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE `obtener_contactos_agregados`(
    IN usuario_hash VARCHAR(255)
    )
BEGIN
    SELECT 
        u.hash_correo,
        u.correo
    FROM Contactos c
    JOIN Usuarios u ON u.hash_correo = c.hash_contacto
    WHERE c.hash_usuario = usuario_hash;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE `obtener_usuarios_disponibles`(
    IN usuario_hash VARCHAR(255)
    )
BEGIN
    SELECT 
        u.hash_correo,
        u.correo
    FROM Usuarios u
    WHERE u.hash_correo NOT IN (
        SELECT hash_contacto FROM Contactos WHERE hash_usuario = usuario_hash
    )
    AND u.hash_correo != usuario_hash;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE `agregar_contacto`(
    IN p_hash_usuario VARCHAR(255),
    IN p_hash_contacto VARCHAR(255)
)
BEGIN
    IF NOT EXISTS (
        SELECT 1 FROM Contactos 
        WHERE hash_usuario = p_hash_usuario AND hash_contacto = p_hash_contacto
    ) THEN
        INSERT INTO Contactos (hash_usuario, hash_contacto)
        VALUES (p_hash_usuario, p_hash_contacto);
    END IF;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE `eliminar_contacto`(
    IN p_hash_usuario VARCHAR(255),
    IN p_hash_contacto VARCHAR(255)
)
BEGIN
    DELETE FROM Contactos
    WHERE hash_usuario = p_hash_usuario AND hash_contacto = p_hash_contacto;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE `obtenerPublicaciones`()
BEGIN
    SELECT 
        P.id_publicaciones,
        P.titulo,
        P.descripcion,
        P.hash_correo,
        U.correo AS autor,
        P.numero_likes,
        P.fecha_publicacion,
        T.nombre_tema AS tema
    FROM Publicaciones P
    LEFT JOIN Usuarios U ON P.hash_correo = U.hash_correo
    LEFT JOIN Tema T ON P.tema_id = T.id_tema
    ORDER BY P.fecha_publicacion DESC;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE `obtenerComentariosPorPublicacion`(IN pub_id TINYINT)
BEGIN
    SELECT 
        C.hash_correo,
        U.correo AS correo,
        C.comentario_texto,
        C.fecha_comentario
    FROM Comentario_Publicaciones C
    LEFT JOIN Usuarios U ON C.hash_correo = U.hash_correo
    WHERE C.publicacion_id = pub_id
    ORDER BY C.fecha_comentario ASC;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE `toggleFavorito` (
    IN p_hash_usuario VARCHAR(255),
    IN p_publicacion_id TINYINT
)
BEGIN
    -- Verificar si ya está en favoritos
    IF EXISTS (
        SELECT 1
        FROM Favoritos
        WHERE hash_usuario = p_hash_usuario AND publicacion_id = p_publicacion_id
    ) THEN
        -- Si ya existe, eliminarlo (quitar favorito)
        DELETE FROM Favoritos
        WHERE hash_usuario = p_hash_usuario AND publicacion_id = p_publicacion_id;

         -- Restar 1 a la cantidad de favoritos
        UPDATE Publicaciones
        SET numero_likes = GREATEST(0, numero_likes - 1)
        WHERE id_publicaciones = p_publicacion_id;
    ELSE
        -- Si no existe, insertarlo (marcar como favorito)
        INSERT INTO Favoritos (hash_usuario, publicacion_id)
        VALUES (p_hash_usuario, p_publicacion_id);

        -- Sumar 1 a la cantidad de favoritos
        UPDATE Publicaciones
        SET numero_likes = numero_likes + 1
        WHERE id_publicaciones = p_publicacion_id;
    END IF;

        -- Devolver el nuevo número de likes
    SELECT numero_likes
    FROM Publicaciones
    WHERE id_publicaciones = p_publicacion_id;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE `esFavorito` (
    IN p_hash_usuario VARCHAR(255),
    IN p_publicacion_id TINYINT
)
BEGIN
    SELECT EXISTS (
        SELECT 1
        FROM Favoritos
        WHERE hash_usuario = p_hash_usuario AND publicacion_id = p_publicacion_id
    ) AS es_favorito;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE `crearComentario` (
    IN p_hash_usuario VARCHAR(255),
    IN p_publicacion_id INT,
    IN p_contenido TEXT
)
BEGIN
    INSERT INTO Comentario_Publicaciones (hash_correo, publicacion_id, comentario_texto)
    VALUES (p_hash_usuario, p_publicacion_id, p_contenido);
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE `obtenerPublicacionesFiltradas`(
    IN p_titulo VARCHAR(255),
    IN p_correo VARCHAR(255),
    IN p_fecha DATE,
    IN p_tema VARCHAR(50)
)
BEGIN
    SELECT 
        P.id_publicaciones,
        P.titulo,
        P.descripcion,
        P.hash_correo,
        U.correo AS autor,
        P.numero_likes,
        P.fecha_publicacion,
        T.nombre_tema AS tema
    FROM Publicaciones P
    LEFT JOIN Usuarios U ON P.hash_correo = U.hash_correo
    LEFT JOIN Tema T ON P.tema_id = T.id_tema
    WHERE
        (p_titulo IS NULL OR P.titulo LIKE CONCAT('%', p_titulo, '%'))
        AND (p_correo IS NULL OR U.correo LIKE CONCAT('%', p_correo, '%'))
        AND (p_fecha IS NULL OR DATE(P.fecha_publicacion) = p_fecha)
        AND (p_tema IS NULL OR T.nombre_tema = p_tema)
    ORDER BY P.fecha_publicacion DESC;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE `obtenerPublicacionesFiltradasFeed`(
    IN p_titulo VARCHAR(255),
    IN p_correo VARCHAR(255),
    IN p_fecha DATE,
    IN p_tema VARCHAR(50),
    IN p_hash_correo VARCHAR(255)
)
BEGIN
    SELECT 
        P.id_publicaciones,
        P.titulo,
        P.descripcion,
        P.hash_correo,
        U.correo AS autor,
        P.numero_likes,
        P.fecha_publicacion,
        T.nombre_tema AS tema
    FROM Publicaciones P
    LEFT JOIN Usuarios U ON P.hash_correo = U.hash_correo
    LEFT JOIN Tema T ON P.tema_id = T.id_tema
    WHERE
        (p_titulo IS NULL OR P.titulo LIKE CONCAT('%', p_titulo, '%'))
        AND (p_correo IS NULL OR U.correo LIKE CONCAT('%', p_correo, '%'))
        AND (p_fecha IS NULL OR DATE(P.fecha_publicacion) = p_fecha)
        AND (p_tema IS NULL OR T.nombre_tema = p_tema)
        AND (p_hash_correo IS NULL OR P.hash_correo = p_hash_correo)
    ORDER BY P.fecha_publicacion DESC;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE `obtenerPublicacionesFeed`(
    IN p_hash_correo VARCHAR(255)
)
BEGIN
    SELECT 
        P.id_publicaciones,
        P.titulo,
        P.descripcion,
        P.hash_correo,
        U.correo AS autor,
        P.numero_likes,
        P.fecha_publicacion,
        T.nombre_tema AS tema
    FROM Publicaciones P
    LEFT JOIN Usuarios U ON P.hash_correo = U.hash_correo
    LEFT JOIN Tema T ON P.tema_id = T.id_tema
    WHERE (p_hash_correo IS NULL OR P.hash_correo = p_hash_correo)
    ORDER BY P.fecha_publicacion DESC;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE `insertarPublicacion` (
    IN p_titulo VARCHAR(255),
    IN p_tema_id TINYINT,
    IN p_descripcion TEXT,
    IN p_hash_correo VARCHAR(255)
)
BEGIN
    INSERT INTO Publicaciones (titulo, tema_id, descripcion, hash_correo)
    VALUES (p_titulo, p_tema_id, p_descripcion, p_hash_correo);
    
    -- Devolver el ID generado
    SELECT LAST_INSERT_ID() AS id_publicacion;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE `insertarContenidoMedia` (
    IN p_publicacion_id TINYINT,
    IN p_tipo VARCHAR(10),
    IN p_ruta_archivo TEXT
)
BEGIN
    INSERT INTO Contenido_Media (publicacion_id, tipo, url_media)
    VALUES (
        p_publicacion_id,
        p_tipo,
        p_ruta_archivo
    );
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE `obtenerMediaPorPublicacion`(IN pub_id TINYINT)
BEGIN
    SELECT 
        tipo,
        url_media AS url
    FROM Contenido_Media
    WHERE publicacion_id = pub_id;
END$$
DELIMITER ;
-- EDITAR PUBLICACION
DELIMITER $$
CREATE PROCEDURE `editar_publicacion`(
IN titulo_ VARCHAR(255),
IN tema_id_ TINYINT,
IN descripcion_ TEXT, 
IN id_publicaciones_ TINYINT
)
BEGIN
   UPDATE publicaciones SET
        titulo = CASE WHEN titulo_ IS NOT NULL AND titulo_ != '' THEN tituloe_ ELSE titulo END,
        tema_id = CASE WHEN tema_id_ IS NOT NULL AND titulo_ != '' THEN tema_id_ ELSE tema_id END,
        descripcion = CASE WHEN descripcion_ IS NOT NULL AND descripcion_ != '' THEN descripcion_ ELSE descripcion END
		WHERE id_publicaciones = id_publicaciones_;
END$$
DELIMITER ;

