<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mensajes Directos</title>
  <link rel="stylesheet" href="CSS/GENERAL/general_styles.css" />
  <link rel="stylesheet" href="CSS/GENERAL/header.css" />
  <link rel="stylesheet" href="CSS/GENERAL/footer.css" />
  <link rel="stylesheet" href="CSS/mensajes.css" />
</head>

<body>
  <?php require 'TEMPLATES/header.php'; ?>
  <div class="dm-container">
    <div class="sidebar">
      <h2>Chats</h2>

      <div class="search-container">
        <input type="text" id="Usuario" placeholder="Buscar usuario..." />
        <button class="btn btn-search">Buscar</button>
      </div>

      <ul class="chat-list">
        <li class="chat-item">Usuario 1</li>
        <li class="chat-item">Usuario 2</li>
        <li class="chat-item">
          Usuario 3
          <label class="messageNotification"></label>
        </li>
      </ul>
    </div>

    <div class="chat-window">
      <div class="chat-header">
        <div class="user-info">
          <h3>Usuario 1</h3>
        </div>
      </div>

      <div class="chat-messages">
        <div class="message received">Ejemplo 1</div>
        <div class="message sent">Ejemplo 2</div>
      </div>

      <div class="message-input">
        <input type="text" placeholder="Escribe un mensaje..." id="message-box" />
        <button class="btn send-btn" id="btn send-btn">Enviar</button>
      </div>
    </div>
  </div>

  <?php require 'TEMPLATES/footer.php'; ?>
  <script src="JS/mensajes.js"></script>
</body>

</html>