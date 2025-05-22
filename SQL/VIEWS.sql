use capa_intermedia;

DELIMITER $$
CREATE VIEW vista_reporte_usuarios AS
SELECT 
    u.hash_correo,
    u.correo,
    COUNT(p.id) AS cantidad_publicaciones
FROM 
    Usuario u
LEFT JOIN 
    Publicacion p ON u.hash_correo = p.hash_correo
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
    COUNT(c.id) AS cantidad_comentarios
FROM 
    Publicacion p
JOIN 
    Usuario u ON p.hash_correo = u.hash_correo
LEFT JOIN 
    Comentario c ON p.id = c.publicacion_id
GROUP BY 
    p.id, p.titulo, u.hash_correo, u.correo, p.fecha_publicacion;
        $$
DELIMITER ;

SELECT * FROM vista_reporte_usuarios;
SELECT * FROM vista_reporte_publicaciones;