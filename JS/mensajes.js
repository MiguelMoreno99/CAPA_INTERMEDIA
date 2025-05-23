// Script temporal para el boton de cifrado
const chatList = document.getElementById("chat-list");

let contactosAgregados = [];

document.addEventListener("DOMContentLoaded", () => {
  obtenerContactosAgregados();
});


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
    const chatUsername = document.getElementById("chat-username");
    chatUsername.textContent = contacto.correo;
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
