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