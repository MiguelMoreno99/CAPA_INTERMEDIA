#ESTO SE PONE DENTRO DEL ARCHIVO C:\xampp\apache\conf\httpd.conf
#PARA LO DE LAS RUTAS SIN LAS EXTENCIONES Y SIN EL NOMBRE DE LA CARPETA A UTILIZAR

DocumentRoot "C:/xampp/htdocs"
<Directory "C:/xampp/htdocs">
    AllowOverride None
    Require all granted
    Options FollowSymLinks
</Directory>

<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/CAPA_INTERMEDIA"
    DirectoryIndex index.php
    <Directory "C:/xampp/htdocs/CAPA_INTERMEDIA">
        AllowOverride None
        Require all granted
        Options FollowSymLinks
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule ^(.*)$ index.php [QSA,L]
    </Directory>
</VirtualHost>



##ESTO ES PARA QUE SE PUEDAN SUBIR IMAGENES Y VIDEOS DE MUCHO MAS TAMAÑO

Ubica o agrega esto en el archivo my.ini [mysqld]:

max_allowed_packet=1024M

Reinicia el servidor MySQL desde el panel de XAMPP para que los cambios surtan efecto.

Verifica que el valor se actualizó correctamente con este comando en MySQL:

SHOW VARIABLES LIKE 'max_allowed_packet';