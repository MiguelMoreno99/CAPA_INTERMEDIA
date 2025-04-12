create database capa_intermedia;
use capa_intermedia;

CREATE TABLE Usuarios (
    correo VARCHAR(255) PRIMARY KEY COMMENT 'Identificador unico del usuario',
    contra VARCHAR(10) NOT NULL COMMENT 'Guarda la contrase;a del usuario',
    nombre VARCHAR(50) NOT NULL COMMENT 'Nombre del usuario',
    apellido VARCHAR(50) NOT NULL COMMENT 'Primer apellido del usuario',
    nombre_usuario VARCHAR(50) UNIQUE NOT NULL COMMENT 'Nombre que el usuario usa en la aplicacion debe de ser unico',
    foto_perfil MEDIUMTEXT COMMENT 'Foto de perfil guardado en medium text ya que se guardaria el codigo base64',
    usuario_administrador BOOLEAN DEFAULT FALSE COMMENT 'Es un valor booleano que indica si el usuario es administrador o no',
    bloqueado BOOLEAN DEFAULT FALSE COMMENT 'Es un valor booleano que indica si el contacto esta bloqueado o no solo los admins pueden bloquear otros usuarios',
    id_usuario INT  -- no se puede poner el auto increment si es tabla
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
    usuario_correo VARCHAR(255) COMMENT 'El usuario que creo la publicacion',
    numero_likes INT DEFAULT 0 COMMENT 'A cuantos usuarios les ha gustado la publicacion',
    fecha_publicacion DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha y hora en la que se creo la publicacion',
    FOREIGN KEY (tema_id) REFERENCES Tema(id_tema) ON DELETE SET NULL,
    FOREIGN KEY (usuario_correo) REFERENCES Usuarios(correo) ON DELETE CASCADE
)COMMENT 'Almacena la informacion de las publicaciones a excepcion del contenido multimedia que tiene su propia tabla';

CREATE TABLE Contenido_Media (
    id_publicacion_media tinyint AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificador unico de cada archivo de media',
    publicacion_id TINYINT COMMENT 'Referencia a la publicacion de la que pertenece',
    tipo ENUM('imagen', 'video') NOT NULL COMMENT 'Que tipo de archivo es ',
    contenido LONGBLOB NOT NULL COMMENT 'Almacena en formato binario el archivo de multimedia',
    FOREIGN KEY (publicacion_id) REFERENCES Publicaciones(id_publicaciones) ON DELETE CASCADE
) COMMENT='Almacena el contenido multimedia de las publicaciones';

CREATE TABLE Comentario_Publicaciones (
    id_comentario_publicacion tinyint AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificador unico de cada comentario',
    publicacion_id TINYINT COMMENT 'Referencia a la publicacion de la que pertenece',
    contenido LONGBLOB NOT NULL COMMENT 'Almacena el texto del comentario',
    usuario_correo VARCHAR(255),
    fecha_comentario DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha y hora en la que se hizo el comentario',
    FOREIGN KEY (publicacion_id) REFERENCES Publicaciones(id_publicaciones) ON DELETE CASCADE,
    FOREIGN KEY (usuario_correo) REFERENCES Usuarios(correo) -- No se si tambien ponerle ON DELETE CASCADE 
) COMMENT='Almacena el contenido multimedia de las publicaciones';

CREATE TABLE Mensajes (
    id_mensajes INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificador unico de mensajes',
    emisor VARCHAR(255) COMMENT 'Persona que envia el mensaje es una fk a la tabla de usuario',
    receptor VARCHAR(255) COMMENT 'Persona que recibe el mensaje es una fk a la tabla de usuario',
    texto TEXT COMMENT 'Contenido del mensaje',
    fecha_envio DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha y hora en la que se envio el mensaje',
    FOREIGN KEY (emisor) REFERENCES Usuarios(correo) ON DELETE CASCADE,
    FOREIGN KEY (receptor) REFERENCES Usuarios(correo) ON DELETE CASCADE
) COMMENT 'Almacena los mensajes entre usuarios';

CREATE TABLE Contactos (
    usuario VARCHAR(255) COMMENT 'Hace referencia al correo del usuario propietario de la cuenta',
    contacto VARCHAR(255) COMMENT 'Hace referencia al correo del usuario que el usuario propietario guarda como contacto',
    PRIMARY KEY (usuario, contacto),
    FOREIGN KEY (usuario) REFERENCES Usuarios(correo) ON DELETE CASCADE,
    FOREIGN KEY (contacto) REFERENCES Usuarios(correo) ON DELETE CASCADE
)COMMENT 'Almacena la informacion de los contactos, cuenta con una PK compuesta del porpietario de la cuenta y el contacto';

CREATE TABLE Favoritos (
    usuario VARCHAR(255) COMMENT 'El usuario propietario de la cuenta',
    publicacion_id TINYINT COMMENT'La publicacion que se guarda',
    PRIMARY KEY (usuario, publicacion_id),
    FOREIGN KEY (usuario) REFERENCES Usuarios(correo) ON DELETE CASCADE,
    FOREIGN KEY (publicacion_id) REFERENCES Publicaciones(id_publicaciones) ON DELETE CASCADE
)COMMENT 'Almacena las publicaciones que el usuario propietario clasifica como favoritos';