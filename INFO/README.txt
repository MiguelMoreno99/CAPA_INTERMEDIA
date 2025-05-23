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
Ubica php.ini

upload_max_filesize = 200M
post_max_size = 200M
max_execution_time = 300
max_input_time = 300
memory_limit = 512M

Reinicia el servidor MySQL desde el panel de XAMPP para que los cambios surtan efecto.
