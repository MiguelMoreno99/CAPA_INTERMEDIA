// Lista de usuarios de ejemplo
let usuarios = [
    { id: 1, nombre: "Carlos Pérez", enContactos: true },
    { id: 2, nombre: "Ana García", enContactos: false },
    { id: 3, nombre: "Luis Fernández", enContactos: true },
    { id: 4, nombre: "María López", enContactos: false }
];

// Referencias a las listas
const misContactosLista = document.getElementById("mis-contactos");
const usuariosLista = document.getElementById("usuarios-disponibles");

// Función para renderizar las listas
function renderizarListas() {
    misContactosLista.innerHTML = "";
    usuariosLista.innerHTML = "";

    let tieneContactos = false;
    let tieneUsuariosDisponibles = false;

    usuarios.forEach(usuario => {
        let li = document.createElement("li");
        li.textContent = usuario.nombre;

        let boton = document.createElement("button");
        boton.textContent = usuario.enContactos ? "Eliminar" : "Agregar";
        boton.className = usuario.enContactos ? "btn remove" : "btn add";

        boton.addEventListener("click", () => {
            usuario.enContactos = !usuario.enContactos;
            renderizarListas();
        });

        li.appendChild(boton);

        if (usuario.enContactos) {
            misContactosLista.appendChild(li);
            tieneContactos = true;
        } else {
            usuariosLista.appendChild(li);
            tieneUsuariosDisponibles = true;
        }
    });

    // Si no hay contactos, mostrar mensaje
    if (!tieneContactos) {
        let mensaje = document.createElement("li");
        mensaje.textContent = "No cuentas con contactos";
        mensaje.style.textAlign = "center";
        mensaje.style.color = "#888";
        misContactosLista.appendChild(mensaje);
    }

    // Si no hay usuarios disponibles, mostrar mensaje
    if (!tieneUsuariosDisponibles) {
        let mensaje = document.createElement("li");
        mensaje.textContent = "No hay usuarios para agregar";
        mensaje.style.textAlign = "center";
        mensaje.style.color = "#888";
        usuariosLista.appendChild(mensaje);
    }
}

// Inicializar la interfaz
renderizarListas();
