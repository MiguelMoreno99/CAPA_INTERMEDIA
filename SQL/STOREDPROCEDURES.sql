use capa_intermedia;

DELIMITER $$ 
CREATE PROCEDURE `insertar_usuario`(
    IN correo_ VARCHAR(50),
    IN contra_ VARCHAR(255),
    IN nombre_ VARCHAR(30), 
    IN apellido_ VARCHAR(30),
    IN nombreusuario_ VARCHAR(30),
    IN fotoperfil_ MEDIUMTEXT,
    IN usuarioadministrador_ tinyint,
    IN idusuario_ INT
)
BEGIN
    INSERT INTO Usuarios (correo, contra, nombre, apellido, nombre_usuario, foto_perfil, usuario_administrador, id_usuario) 
    VALUES(correo_, contra_, nombre_, apellido_, nombreusuario_, fotoperfil_, usuarioadministrador_, idusuario_);
END$$
DELIMITER ;

DELIMITER $$ 
CREATE PROCEDURE `traer_datos_usuario`(
  IN correo_ VARCHAR(50) 
)
BEGIN
    SELECT correo, contra, nombre, apellido, nombre_usuario, foto_perfil, usuario_administrador
    FROM usuarios
    WHERE correo = correo_;
END$$
DELIMITER ;

DELIMITER $$ 
CREATE PROCEDURE `editar_datos_usuario`(
   IN correo_ VARCHAR(50),
    IN contra_ VARCHAR(255),
    IN nombre_ VARCHAR(30), 
    IN apellido_ VARCHAR(30),
    IN nombre_usuario_ VARCHAR(30),
    IN foto_perfil_ MEDIUMTEXT
)
BEGIN
    UPDATE usuarios
    SET 
		contra = CASE WHEN contra_ != '' THEN contra_ ELSE contra END,
        nombre = CASE WHEN nombre_ != '' THEN nombre_ ELSE nombre END,
        apellido = CASE WHEN apellido_ != '' THEN apellido_ ELSE apellido END,
        nombre_usuario = CASE WHEN nombre_usuario_ != '' THEN nombre_usuario_ ELSE nombre_usuario END,
        foto_perfil = CASE WHEN foto_perfil_ != '' THEN foto_perfil_ ELSE foto_perfil END
    WHERE correo = correo_;
END$$
DELIMITER ;

DELIMITER $$ 
CREATE PROCEDURE `verificar_usuario`(
   IN correo_ varchar(50), 
    IN contra_ varchar(10)
)
BEGIN
    SELECT EXISTS(
        SELECT 1
        FROM usuarios
        WHERE correo = correo_ AND contra = contra_
        ) AS is_valid; -- el nombre de mi columna 
END$$
DELIMITER ;