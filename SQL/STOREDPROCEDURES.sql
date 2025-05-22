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

-- insert INTO capa_intermedia.contactos VALUES ("2f4acf8f31f887a483c9dd33ab6051d334cfdbb98816333dee1e3a1201ea9d27","c27002e38eb28ea4464f7a09dbbcae616d427bddab221431fb72407caae1be2b");

-- CALL obtener_contactos_agregados("2f4acf8f31f887a483c9dd33ab6051d334cfdbb98816333dee1e3a1201ea9d27");
-- CALL obtener_contactos_agregados("c27002e38eb28ea4464f7a09dbbcae616d427bddab221431fb72407caae1be2b");

-- CALL obtener_usuarios_disponibles("2f4acf8f31f887a483c9dd33ab6051d334cfdbb98816333dee1e3a1201ea9d27");
-- CALL obtener_usuarios_disponibles("c27002e38eb28ea4464f7a09dbbcae616d427bddab221431fb72407caae1be2b");

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
CREATE PROCEDURE `obtenerMediaPorPublicacion`(IN pub_id TINYINT)
BEGIN
    SELECT 
        tipo,
        CONCAT('data:', 
               CASE tipo
                   WHEN 'imagen' THEN 'image/jpeg'
                   WHEN 'video' THEN 'video/mp4'
               END,
               ';base64,', TO_BASE64(contenido)) AS url
    FROM Contenido_Media
    WHERE publicacion_id = pub_id;
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

-- INSERT INTO Tema (nombre_tema) VALUES ('Viajes');
-- INSERT INTO Tema (nombre_tema) VALUES ('Deportes');
-- INSERT INTO Tema (nombre_tema) VALUES ('Tecnología');
-- INSERT INTO Tema (nombre_tema) VALUES ('Cultura');

-- INSERT INTO Publicaciones (titulo, tema_id, descripcion, hash_correo,numero_likes)
-- VALUES ('Mi nuevo viaje a la playa', 1, 'Les comparto fotos de mi último viaje', '2f4acf8f31f887a483c9dd33ab6051d334cfdbb98816333dee1e3a1201ea9d27',10);
-- INSERT INTO Contenido_Media (publicacion_id, tipo, contenido)
-- VALUES (1,'imagen',LOAD_FILE('D:/XAMPP/htdocs/CAPA_INTERMEDIA/IMG/SocializeLogo.jpg'));
-- INSERT INTO Contenido_Media (publicacion_id, tipo, contenido)
-- VALUES (1,'imagen',LOAD_FILE('D:/XAMPP/htdocs/CAPA_INTERMEDIA/IMG/SocializeLogo2.jpg'));
-- INSERT INTO Contenido_Media (publicacion_id, tipo, contenido)
-- VALUES (1,'imagen',LOAD_FILE('D:/XAMPP/htdocs/CAPA_INTERMEDIA/IMG/SocializeLogo.jpg'));
-- INSERT INTO Contenido_Media (publicacion_id, tipo, contenido)
-- VALUES (1,'video',LOAD_FILE('D:/XAMPP/htdocs/CAPA_INTERMEDIA/IMG/video.mp4'));
-- INSERT INTO Comentario_Publicaciones (publicacion_id, comentario_texto, hash_correo)
-- VALUES (1, '¡Qué padre viaje! Espero poder ir pronto.', '2f4acf8f31f887a483c9dd33ab6051d334cfdbb98816333dee1e3a1201ea9d27');

-- INSERT INTO Publicaciones (titulo, tema_id, descripcion, hash_correo,numero_likes)
-- VALUES ('Mi nuevo deporte Favorito', 2, 'Les comparto fotos de deporte', 'ec6178702dca2b7e6a29b2ce120124b822ff0cd3310b8c6003500e23dccf9420',2);
-- INSERT INTO Contenido_Media (publicacion_id, tipo, contenido)
-- VALUES (2,'imagen',LOAD_FILE('D:/XAMPP/htdocs/CAPA_INTERMEDIA/IMG/SocializeLogo2.jpg'));
-- INSERT INTO Contenido_Media (publicacion_id, tipo, contenido)
-- VALUES (2,'imagen',LOAD_FILE('D:/XAMPP/htdocs/CAPA_INTERMEDIA/IMG/SocializeLogo.jpg'));
-- INSERT INTO Comentario_Publicaciones (publicacion_id, comentario_texto, hash_correo)
-- VALUES (2, '¡Qué padre deporte!.', 'c27002e38eb28ea4464f7a09dbbcae616d427bddab221431fb72407caae1be2b');
-- INSERT INTO Comentario_Publicaciones (publicacion_id, comentario_texto, hash_correo)
-- VALUES (2, '¡Qué padre viaje! Espero poder ir pronto.', '2f4acf8f31f887a483c9dd33ab6051d334cfdbb98816333dee1e3a1201ea9d27');

-- INSERT INTO Publicaciones (titulo, tema_id, descripcion, hash_correo,numero_likes)
-- VALUES ('Otro viaje a la playa', 1, 'Les comparto fotos de mi otro viaje', '2f4acf8f31f887a483c9dd33ab6051d334cfdbb98816333dee1e3a1201ea9d27',3);
-- INSERT INTO Contenido_Media (publicacion_id, tipo, contenido)
-- VALUES (3,'imagen',LOAD_FILE('D:/XAMPP/htdocs/CAPA_INTERMEDIA/IMG/SocializeLogo2.jpg'));
-- INSERT INTO Contenido_Media (publicacion_id, tipo, contenido)
-- VALUES (3,'imagen',LOAD_FILE('D:/XAMPP/htdocs/CAPA_INTERMEDIA/IMG/SocializeLogo.jpg'));
-- INSERT INTO Contenido_Media (publicacion_id, tipo, contenido)
-- VALUES (3,'imagen',LOAD_FILE('D:/XAMPP/htdocs/CAPA_INTERMEDIA/IMG/SocializeLogo2.jpg'));
-- INSERT INTO Contenido_Media (publicacion_id, tipo, contenido)
-- VALUES (3,'video',LOAD_FILE('D:/XAMPP/htdocs/CAPA_INTERMEDIA/IMG/video.mp4'));
-- INSERT INTO Comentario_Publicaciones (publicacion_id, comentario_texto, hash_correo)
-- VALUES (3, '¡Qué padre viaje!', 'ec6178702dca2b7e6a29b2ce120124b822ff0cd3310b8c6003500e23dccf9420');
-- INSERT INTO Comentario_Publicaciones (publicacion_id, comentario_texto, hash_correo)
-- VALUES (3, '¡Espero poder ir pronto.', 'c27002e38eb28ea4464f7a09dbbcae616d427bddab221431fb72407caae1be2b');
-- INSERT INTO Comentario_Publicaciones (publicacion_id, comentario_texto, hash_correo)
-- VALUES (3, '¡AAAAAAAAA.', 'ec6178702dca2b7e6a29b2ce120124b822ff0cd3310b8c6003500e23dccf9420');

-- SHOW VARIABLES LIKE 'max_allowed_packet';

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