// Referencias a las listas
const misContactosLista = document.getElementById("mis-contactos");
const usuariosLista = document.getElementById("usuarios-disponibles");

// Lista de usuarios
let contactosAgregados = [];
let contactosDisponibles = [];

// Inicializar la interfaz
inicializar();

// Función para renderizar las listas
function renderizarListas() {
    misContactosLista.innerHTML = "";
    usuariosLista.innerHTML = "";

    let tieneContactos = false;
    let tieneUsuariosDisponibles = false;

    // Contactos agregados
    contactosAgregados.forEach(contacto => {
        const li = document.createElement("li");
        li.style.display = "flex";
        li.style.alignItems = "center";
        li.style.gap = "10px";
        li.style.padding = "8px";
        li.style.borderBottom = "1px solid #ccc";

        const linkImg = document.createElement("a");
        linkImg.href = `https://gravatar.com/${contacto.hash_correo}`;
        linkImg.target = "_blank";
        linkImg.title = "Ver perfil en Gravatar";

        const img = document.createElement("img");
        img.src = `https://www.gravatar.com/avatar/${contacto.hash_correo}`;
        img.alt = "Avatar";
        img.width = 40;
        img.height = 40;
        img.style.borderRadius = "50%";

        linkImg.appendChild(img);

        const correoSpan = document.createElement("span");
        correoSpan.textContent = contacto.correo;

        const boton = document.createElement("button");
        boton.textContent = "Eliminar";
        boton.className = "btn remove";
        boton.addEventListener("click", async () => {
            await eliminarContacto(contacto.hash_correo);

            // Mover el contacto a la otra lista
            contactosDisponibles.push(contacto);
            contactosAgregados = contactosAgregados.filter(c => c.hash_correo !== contacto.hash_correo);

            renderizarListas();
        });

        li.appendChild(linkImg);
        li.appendChild(correoSpan);
        li.appendChild(boton);
        misContactosLista.appendChild(li);
        tieneContactos = true;
    });

    // Contactos disponibles
    contactosDisponibles.forEach(contacto => {
        const li = document.createElement("li");
        li.style.display = "flex";
        li.style.alignItems = "center";
        li.style.gap = "10px";
        li.style.padding = "8px";
        li.style.borderBottom = "1px solid #ccc";

        const linkImg = document.createElement("a");
        linkImg.href = `https://gravatar.com/${contacto.hash_correo}`;
        linkImg.target = "_blank";
        linkImg.title = "Ver perfil en Gravatar";

        const img = document.createElement("img");
        img.src = `https://www.gravatar.com/avatar/${contacto.hash_correo}`;
        img.alt = "Avatar";
        img.width = 40;
        img.height = 40;
        img.style.borderRadius = "50%";

        linkImg.appendChild(img);

        const correoSpan = document.createElement("span");
        correoSpan.textContent = contacto.correo;

        const boton = document.createElement("button");
        boton.textContent = "Agregar";
        boton.className = "btn add";
        boton.addEventListener("click", async () => {
            await agregarContacto(contacto.hash_correo);

            // Mover el contacto a la otra lista
            contactosAgregados.push(contacto);
            contactosDisponibles = contactosDisponibles.filter(c => c.hash_correo !== contacto.hash_correo);

            renderizarListas();
        });

        li.appendChild(linkImg);
        li.appendChild(correoSpan);
        li.appendChild(boton);
        usuariosLista.appendChild(li);
        tieneUsuariosDisponibles = true;
    });

    // Si no hay contactos agregados
    if (!tieneContactos) {
        let mensaje = document.createElement("li");
        mensaje.textContent = "No cuentas con contactos";
        mensaje.style.textAlign = "center";
        mensaje.style.color = "#888";
        misContactosLista.appendChild(mensaje);
    }

    // Si no hay contactos disponibles
    if (!tieneUsuariosDisponibles) {
        let mensaje = document.createElement("li");
        mensaje.textContent = "No hay usuarios para agregar";
        mensaje.style.textAlign = "center";
        mensaje.style.color = "#888";
        usuariosLista.appendChild(mensaje);
    }
}

async function obtenerContactosAgregados() {
    try {
        const response = await fetch('/api/contactos_agregados'); // Nueva ruta
        if (!response.ok) throw new Error('Error al obtener contactos agregados');

        contactosAgregados = await response.json();
        console.log(contactosAgregados); // Verifica que llegan los datos

    } catch (error) {
        console.error(error);
    }
}

async function obtenerContactosDisponibles() {
    try {
        const response = await fetch('/api/contactos_disponibles'); // Nueva ruta
        if (!response.ok) throw new Error('Error al obtener contactos disponibles');

        contactosDisponibles = await response.json();
        console.log(contactosDisponibles); // Verifica que llegan los datos

    } catch (error) {
        console.error(error);
    }
}

async function agregarContacto(hash_correo) {
    try {
        const response = await fetch('/api/agregar_contacto', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ hash_contacto: hash_correo })
        });
        if (!response.ok) throw new Error("Error al agregar contacto");
        console.log("Contacto agregado correctamente");
    } catch (error) {
        console.error(error);
    }
}

async function eliminarContacto(hash_correo) {
    try {
        const response = await fetch('/api/eliminar_contacto', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ hash_contacto: hash_correo })
        });
        if (!response.ok) throw new Error("Error al eliminar contacto");
        console.log("Contacto eliminado correctamente");
    } catch (error) {
        console.error(error);
    }
}

async function inicializar() {
    await obtenerContactosAgregados();
    await obtenerContactosDisponibles();
    renderizarListas();
}