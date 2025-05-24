const chatList = document.getElementById("chat-list");
let socket;
let selectedReceptor = null;
const chatUsername = document.getElementById("chat-username");
const messageBox = document.getElementById("message-box");
const sendBtn = document.getElementById("btn send-btn");
const chatMessages = document.querySelector(".chat-messages");

let contactosAgregados = [];

document.addEventListener("DOMContentLoaded", () => {

  obtenerContactosAgregados();
  socket = new WebSocket("ws://localhost:8080");

  socket.onmessage = (event) => {
    const data = JSON.parse(event.data);
    if (data.type === "chat" && data.data.receptor === emisor) {
      appendMessage(data.data.texto, "received");
    }
  };

  sendBtn.addEventListener("click", () => {
    console.log(emisor);
    console.log(selectedReceptor);
    const texto = messageBox.value.trim();
    if (!texto || !selectedReceptor) return;

    const message = {
      type: "chat",
      data: {
        emisor: emisor,
        receptor: selectedReceptor,
        texto: texto,
      },
    };

    socket.send(JSON.stringify(message));
    appendMessage(texto, "sent");
    messageBox.value = "";
  });
});


function selectReceptor(hash_correo, correo) {
  if (selectedReceptor === correo) return;
  selectedReceptor = hash_correo;
  const chatUsername = document.getElementById("chat-username");
  chatUsername.textContent = correo;

  chatMessages.innerHTML = "";
  fetchMessagesForChat(emisor, hash_correo);

}

function appendMessage(text, type) {
  const div = document.createElement("div");
  div.className = `message ${type}`;
  div.textContent = text;
  chatMessages.appendChild(div);
}


async function obtenerContactosAgregados() {
  try {
    const response = await fetch("/api/contactos_agregados");
    if (!response.ok) throw new Error("Error al obtener contactos");

    contactosAgregados = await response.json();
    renderizarContactos();
  } catch (error) {
    console.error(error);
  }
}

async function fetchMessagesForChat(emisor, receptor) {
  try {
    const response = await fetch(`/api/cargar_mensajes?emisor=${emisor}&receptor=${receptor}`);
    const history = await response.json();
    console.log(history);
    history.forEach(msg => {
      appendMessage(msg.texto, msg.emisor === emisor ? 'sent' : 'received');
    });
  } catch (error) {
    console.error("Fetch error:", error);
  }

}

function renderizarContactos() {
  chatList.innerHTML = "";

  if (contactosAgregados.length === 0) {
    const li = document.createElement("li");
    li.className = "chat-item";
    li.textContent = "No tienes contactos.";
    chatList.appendChild(li);
    return;
  }

  contactosAgregados.forEach((contacto) => {
    const li = document.createElement("li");
    li.className = "chat-item";
    li.textContent = contacto.correo;

    const notification = document.createElement("label");
    notification.className = "messageNotification";

    li.addEventListener("click", () => {
      selectReceptor(contacto.hash_correo, contacto.correo);
    });

    li.appendChild(notification);
    chatList.appendChild(li);
  });

}

function toggleCifrado() {
  var button = document.getElementById("cifrado-btn");
  button.classList.toggle("active");
  if (button.classList.contains("active")) {
    button.textContent = "Activado";
  } else {
    button.textContent = "Desactivado";
  }
}
