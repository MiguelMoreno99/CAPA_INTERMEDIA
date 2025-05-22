// Llenar reporte de usuarios
const totalUsuarios = document.getElementById("total-usuarios");
const usuariosLista = document.getElementById("usuarios-lista");
// Llenar reporte de posts
const totalPosts = document.getElementById("total-posts");
const postsLista = document.getElementById("posts-lista");

// Lista de usuarios
let reporteUsuarios = [];
let reportePublicaciones = [];

inicializar();

async function obtenerReporteUsuarios() {
  try {
    const response = await fetch('/api/reporte_usuarios'); // Nueva ruta
    if (!response.ok) throw new Error('Error al obtener el reporte de usuarios');

    reporteUsuarios = await response.json();
    console.log(reporteUsuarios); // Verifica que llegan los datos

  } catch (error) {
    console.error(error);
  }
}

async function obtenerReportePublicaciones() {
  try {
    const response = await fetch('/api/reporte_publicaciones'); // Nueva ruta
    if (!response.ok) throw new Error('Error al obtener el reporte de publicaciones');

    reportePublicaciones = await response.json();
    console.log(reportePublicaciones); // Verifica que llegan los datos

  } catch (error) {
    console.error(error);
  }
}

async function inicializar() {
  await obtenerReporteUsuarios();
  await obtenerReportePublicaciones();
  renderizarUsuarios();
  renderizarPublicaciones();
}

function renderizarUsuarios() {
  totalUsuarios.textContent = reporteUsuarios.length;

  usuariosLista.innerHTML = ""; // Limpiar tabla si se actualiza

  reporteUsuarios.forEach(usuario => {
    const row = document.createElement("tr");

    const gravatarImg = `
      <a href="https://www.gravatar.com/${usuario.hash_correo}" target="_blank">
        <img src="https://www.gravatar.com/avatar/${usuario.hash_correo}" alt="Avatar" width="40" height="40" style="border-radius: 50%;">
      </a>`;

    row.innerHTML = `
      <td>${gravatarImg}</td>
      <td>${usuario.correo}</td>
      <td>${usuario.cantidad_publicaciones}</td>
    `;

    usuariosLista.appendChild(row);
  });
}

function renderizarPublicaciones() {
  totalPosts.textContent = reportePublicaciones.length;

  postsLista.innerHTML = ""; // Limpiar tabla si se actualiza

  reportePublicaciones.forEach(post => {
    const gravatarImg = `
      <a href="https://www.gravatar.com/${post.hash_correo}" target="_blank">
        <img src="https://www.gravatar.com/avatar/${post.hash_correo}" alt="Avatar" width="40" height="40" style="border-radius: 50%;">
      </a>`;

    const row = document.createElement("tr");
    row.innerHTML = `
      <td>${gravatarImg}</td>
      <td>${post.correo}</td>
      <td>${post.titulo}</td>
      <td>${post.fecha_publicacion}</td>
      <td>${post.cantidad_comentarios}</td>
    `;

    postsLista.appendChild(row);
  });
}