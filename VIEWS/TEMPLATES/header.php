<header class="main-header">
    <div class="logo">
        <img src="IMG/SocializeLogo.jpg" alt="Logo" />
    </div>
    <nav class="nav-opciones">
        <ul>
            <?php
      if (isset($_SESSION['usuario'])) {
        echo '
                    <li><a href="usuario">Mi Perfil</a></li>';

        // Solo para administradores
        if ($_SESSION['usuario']['usuario_administrador'] == 1) {
          echo '<li><a href="reportes">Reportes</a></li>';
        }

        echo '
                    <li><a href="mensajes">Chats</a></li>
                    <li><a href="contactos">Contactos</a></li>
                    <li><a href="pagina_principal">Feed</a></li>
                    <li><a href="mis_publicaciones">Mis Publicaciones</a></li>
                    <li><a href="inicio_sesion">Cerrar sesión</a></li>
                ';
      } else {
        // Usuario sin sesión
        echo '
                    <li><a href="inicio_sesion">Iniciar Sesión</a></li>
                    <li><a href="registro_usuario">Registrarse</a></li>
                ';
      }
      ?>
        </ul>
    </nav>
</header>