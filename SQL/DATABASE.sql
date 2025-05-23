create database capa_intermedia;
use capa_intermedia;

CREATE TABLE Usuarios (
    hash_correo VARCHAR(255) PRIMARY KEY COMMENT 'Identificador unico del usuario y Hash del correo para utilizarlo con la API de gravatar',
    correo VARCHAR(255) COMMENT 'correo unico del usuario',
    contra VARCHAR(255) NOT NULL COMMENT 'Guarda la contrasenia encriptada del usuario',
    foto_perfil MEDIUMTEXT COMMENT 'Foto de perfil guardado en medium text ya que se guardaria el codigo base64',
    tipo_usuario BOOLEAN DEFAULT FALSE COMMENT 'Es un valor booleano que indica si el usuario es administrador o no'
)COMMENT 'Guarda toda la informacion del usuario'; 

CREATE TABLE Tema (
    id_tema tinyint AUTO_INCREMENT PRIMARY KEY COMMENT 'Id se autoincrementa es un tinyint',
    nombre_tema VARCHAR(100) NOT NULL UNIQUE COMMENT 'Que tema es, debe de ser unico'
)COMMENT 'Tabla para estandarizar el nombre de los temas disponibles';

CREATE TABLE Publicaciones (
    id_publicaciones TINYINT AUTO_INCREMENT PRIMARY KEY COMMENT 'Id se autoincrementa',
    titulo VARCHAR(255) NOT NULL COMMENT 'titulo de la publicacion',
    tema_id TINYINT COMMENT 'El tema al cual pertenece la publicacion', 
    descripcion TEXT COMMENT 'Descripcion de la publicacion',
    hash_correo VARCHAR(255) COMMENT 'El usuario que creo la publicacion',
    numero_likes INT DEFAULT 0 COMMENT 'A cuantos usuarios les ha gustado la publicacion',
    fecha_publicacion DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha y hora en la que se creo la publicacion',
    FOREIGN KEY (tema_id) REFERENCES Tema(id_tema) ON DELETE SET NULL,
    FOREIGN KEY (hash_correo) REFERENCES Usuarios(hash_correo) ON DELETE CASCADE
)COMMENT 'Almacena la informacion de las publicaciones a excepcion del contenido multimedia que tiene su propia tabla';

CREATE TABLE Contenido_Media (
    id_publicacion_media tinyint AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificador unico de cada archivo de media',
    publicacion_id TINYINT COMMENT 'Referencia a la publicacion de la que pertenece',
    tipo ENUM('imagen', 'video') NOT NULL COMMENT 'Que tipo de archivo es ',
    url_media MEDIUMTEXT NOT NULL COMMENT 'Almacena url del archivo de multimedia',
    FOREIGN KEY (publicacion_id) REFERENCES Publicaciones(id_publicaciones) ON DELETE CASCADE
) COMMENT='Almacena el contenido multimedia de las publicaciones';

CREATE TABLE Comentario_Publicaciones (
    id_comentario_publicacion tinyint AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificador unico de cada comentario',
    publicacion_id TINYINT COMMENT 'Referencia a la publicacion de la que pertenece',
    comentario_texto VARCHAR(255) NOT NULL COMMENT 'Almacena el texto del comentario',
    hash_correo VARCHAR(255) COMMENT 'El usuario que creo el comentario',
    fecha_comentario DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha y hora en la que se hizo el comentario',
    FOREIGN KEY (publicacion_id) REFERENCES Publicaciones(id_publicaciones) ON DELETE CASCADE,
    FOREIGN KEY (hash_correo) REFERENCES Usuarios(hash_correo)
) COMMENT='Almacena el contenido multimedia de las publicaciones';

CREATE TABLE Mensajes (
    id_mensajes INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificador unico de mensajes',
    hash_emisor VARCHAR(255) COMMENT 'Persona que envia el mensaje es una fk a la tabla de usuario',
    hash_receptor VARCHAR(255) COMMENT 'Persona que recibe el mensaje es una fk a la tabla de usuario',
    texto TEXT COMMENT 'Contenido del mensaje',
    fecha_envio DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha y hora en la que se envio el mensaje',
    FOREIGN KEY (hash_emisor) REFERENCES Usuarios(hash_correo) ON DELETE CASCADE,
    FOREIGN KEY (hash_receptor) REFERENCES Usuarios(hash_correo) ON DELETE CASCADE
) COMMENT 'Almacena los mensajes entre usuarios';

CREATE TABLE Contactos (
    hash_usuario VARCHAR(255) COMMENT 'Hace referencia al correo del usuario propietario de la cuenta',
    hash_contacto VARCHAR(255) COMMENT 'Hace referencia al correo del usuario que el usuario propietario guarda como contacto',
    PRIMARY KEY (hash_usuario, hash_contacto),
    FOREIGN KEY (hash_usuario) REFERENCES Usuarios(hash_correo) ON DELETE CASCADE,
    FOREIGN KEY (hash_contacto) REFERENCES Usuarios(hash_correo) ON DELETE CASCADE
)COMMENT 'Almacena la informacion de los contactos, cuenta con una PK compuesta del porpietario de la cuenta y el contacto';

CREATE TABLE Favoritos (
    hash_usuario VARCHAR(255) COMMENT 'El usuario propietario de la cuenta',
    publicacion_id TINYINT COMMENT'La publicacion que se guarda',
    PRIMARY KEY (hash_usuario, publicacion_id),
    FOREIGN KEY (hash_usuario) REFERENCES Usuarios(hash_correo) ON DELETE CASCADE,
    FOREIGN KEY (publicacion_id) REFERENCES Publicaciones(id_publicaciones) ON DELETE CASCADE
)COMMENT 'Almacena las publicaciones que el usuario propietario clasifica como favoritos';