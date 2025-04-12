use capa_intermedia;

DELIMITER $$ 
CREATE VIEW DICCIONARIO
AS
SELECT distinct
       t.table_name,
       c.ordinal_position,
       (CASE WHEN t.table_type = 'BASE TABLE' THEN 'table'
             WHEN t.table_type = 'VIEW' THEN 'view'
             ELSE t.table_type
        END) AS table_type,
        c.column_name,
        c.column_type,
        c.column_default,
        c.column_key,
        c.is_nullable,
        c.extra,
        c.column_comment
FROM information_schema.tables AS t
INNER JOIN information_schema.columns AS c
ON t.table_name = c.table_name
AND t.table_schema = c.table_schema
WHERE t.table_type IN ('BASE TABLE', 'VIEW')
AND t.table_schema = 'capa_intermedia'
ORDER BY
        t.table_name,
        c.ordinal_position;
DELIMITER ;

SELECT * FROM DICCIONARIO WHERE table_type = 'table';