use capa_intermedia;

DELIMITER $$
CREATE VIEW vista_reporte_usuarios AS
SELECT 
    u.hash_correo,
    u.correo,
    COUNT(p.id_publicaciones) AS cantidad_publicaciones
FROM 
    Usuarios u
LEFT JOIN 
    Publicaciones p ON u.hash_correo = p.hash_correo
GROUP BY 
    u.hash_correo, u.correo;
    $$
DELIMITER ;

DELIMITER $$
CREATE VIEW vista_reporte_publicaciones AS
SELECT 
    p.titulo,
    u.hash_correo,
    u.correo,
    p.fecha_publicacion,
    COUNT(c.id_comentario_publicacion) AS cantidad_comentarios
FROM 
    Publicaciones p
JOIN 
    Usuarios u ON p.hash_correo = u.hash_correo
LEFT JOIN 
    Comentario_publicaciones c ON p.id_publicaciones = c.publicacion_id
GROUP BY 
    p.id_publicaciones, p.titulo, u.hash_correo, u.correo, p.fecha_publicacion;
        $$
DELIMITER ;

SELECT * FROM vista_reporte_usuarios;
SELECT * FROM vista_reporte_publicaciones;