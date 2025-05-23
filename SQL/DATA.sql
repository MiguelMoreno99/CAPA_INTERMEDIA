INSERT INTO Tema (nombre_tema) VALUES ('Viajes');
INSERT INTO Tema (nombre_tema) VALUES ('Deportes');
INSERT INTO Tema (nombre_tema) VALUES ('Tecnología');
INSERT INTO Tema (nombre_tema) VALUES ('Cultura');

CALL insertarPublicacion ('Mi nuevo viaje a la playa', 1, 'Les comparto fotos de mi último viaje', '2f4acf8f31f887a483c9dd33ab6051d334cfdbb98816333dee1e3a1201ea9d27');
CALL insertarPublicacion ('Mi nuevo deporte Favorito', 2, 'Les comparto fotos de deporte', 'ec6178702dca2b7e6a29b2ce120124b822ff0cd3310b8c6003500e23dccf9420');
CALL insertarPublicacion ('Otro viaje a la playa', 1, 'Les comparto fotos de mi otro viaje', '2f4acf8f31f887a483c9dd33ab6051d334cfdbb98816333dee1e3a1201ea9d27');

CALL insertarContenidoMedia (1,'imagen','IMG/SocializeLogo2.jpg');
CALL insertarContenidoMedia (1,'imagen','IMG/SocializeLogo.jpg');
CALL insertarContenidoMedia (2,'imagen','IMG/SocializeLogo.jpg');
CALL insertarContenidoMedia (2,'imagen','IMG/SocializeLogo2.jpg');
CALL insertarContenidoMedia (2,'imagen','IMG/SocializeLogo.jpg');
CALL insertarContenidoMedia (3,'video','IMG/video.mp4');

SHOW VARIABLES LIKE 'max_allowed_packet';