let publicacionesDisponibles = [];
let postId = 0;
let titulo = document.querySelectorAll('.search-input')[0].value.trim();
let fecha = document.getElementById('filter-date').value;
let tema = document.getElementById('filter-topic').value;

document.addEventListener('DOMContentLoaded', async () => {
  await obtenerPublicaciones();
});

function inicializarCarruseles() {
  const posts = document.querySelectorAll(".post");

  posts.forEach((post) => {
    post.dataset.currentSlide = 0;

    const prevBtn = post.querySelector(".prev");
    const nextBtn = post.querySelector(".next");

    if (prevBtn && nextBtn) {
      prevBtn.addEventListener("click", () => changeSlide(-1, post));
      nextBtn.addEventListener("click", () => changeSlide(1, post));
    }
  });
}

function changeSlide(direction, post) {
  const carouselContainer = post.querySelector(".carousel-container");
  const slides = carouselContainer.children;
  let currentSlide = parseInt(post.dataset.currentSlide, 10);

  currentSlide += direction;

  if (currentSlide < 0) {
    currentSlide = slides.length - 1;
  } else if (currentSlide >= slides.length) {
    currentSlide = 0;
  }

  post.dataset.currentSlide = currentSlide;
  const translateValue = -currentSlide * 100 + "%";
  carouselContainer.style.transform = "translateX(" + translateValue + ")";
}

async function obtenerPublicaciones() {
  try {
    const response = await fetch('/api/publicacionesFeed');
    if (!response.ok) throw new Error('Error al obtener todas las publicaciones');

    publicacionesDisponibles = await response.json();
    console.log(publicacionesDisponibles);

    const container = document.getElementById('feed-container');
    container.innerHTML = ''; // Limpia el contenedor
    publicacionesDisponibles.forEach((pub, index) => {
      const multimediaHTML = pub.multimedia.map(media => {
        if (media.tipo === 'imagen') {
          return `<div class="carousel-slide"><img src="${media.url}" alt="Imagen"/></div>`;
        } else if (media.tipo === 'video') {
          return `<div class="carousel-slide"><video controls><source src="${media.url}" type="video/mp4">Tu navegador no soporta videos.</video></div>`;
        }
        return '';
      }).join('');

      const mostrarControles = pub.multimedia.length > 1;
      const comentariosHTML = pub.comentarios.map(com => `
        <div class="comment">
            <a href="https://gravatar.com/${com.hash_correo}" target="_blank">
              <img src="https://www.gravatar.com/avatar/${com.hash_correo}" alt="Usuario" />
            </a>
          <p><strong>${com.correo}:</strong> ${com.comentario_texto}</p>
        </div>
      `).join('');

      const postHTML = `
        <div class="post">
          <div class="post-header">
            <a href="https://gravatar.com/${pub.hash_correo}" target="_blank">
              <img src="https://www.gravatar.com/avatar/${pub.hash_correo}" alt="Usuario" />
            </a>
            <div>
              <h3>${pub.autor}</h3>
              <span>Publicado el ${new Date(pub.fecha_publicacion).toLocaleDateString()}</span>
            </div>
            <div class="post-topic">
              <h5>Tema:</h5>
              <span>${pub.tema}</span>
            </div>
          </div>
          <h2 class="post-title">${pub.titulo}</h2>
          <p class="post-description">${pub.descripcion}</p>

          <div class="carousel">
            ${mostrarControles ? '<button class="prev">&#10094;</button>' : ''}
            <div class="carousel-container" id="carousel-${index}">
              ${multimediaHTML}
            </div>
            ${mostrarControles ? '<button class="next">&#10095;</button>' : ''}
          </div>

          <div class="post-footer">
            <button class="btn like-btn ${pub.es_favorito ? 'liked' : ''}" 
                    data-id="${pub.id_publicaciones}">
              👍 Me gusta <span>${pub.numero_likes}</span>
            </button>
            <button class="btn enviar-comentario" data-id="${pub.id_publicaciones}">💬 Comentar</button>
            <button class="btn editar-btn" data-id="${pub.id_publicaciones}" 
              data-titulo="${pub.titulo}" 
              data-descripcion="${pub.descripcion}" 
              data-tema="${pub.tema}">
              ✏️ Editar publicación
            </button>
          </div>

          <div class="comments-section">
             <input type="text" placeholder="Escribe un comentario..." class="comment-input" data-id="${pub.id_publicaciones}" />
             <div class="comentarios-lista" data-id="${pub.id_publicaciones}">
                ${comentariosHTML}
             </div>
          </div>
        </div>
      `;

      container.insertAdjacentHTML('beforeend', postHTML);
    });

    inicializarCarruseles(); // Aquí ya existen los .post
  } catch (error) {
    console.error(error);
  }
}

async function obtenerPublicacionesFiltradas() {
  try {
    titulo = document.querySelectorAll('.search-input')[0].value.trim();
    fecha = document.getElementById('filter-date').value;
    tema = document.getElementById('filter-topic').value;

    const response = await fetch('/api/publicaciones_filtradasFeed', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        titulo: titulo,
        fecha: fecha,
        tema: tema
      })
    });

    if (!response.ok) throw new Error('Error al obtener las publicaciones filtradas');

    publicacionesDisponibles = await response.json();
    console.log(publicacionesDisponibles);

    const container = document.getElementById('feed-container');
    container.innerHTML = '';
    publicacionesDisponibles.forEach((pub, index) => {
      const multimediaHTML = pub.multimedia.map(media => {
        if (media.tipo === 'imagen') {
          return `<div class="carousel-slide"><img src="${media.url}" alt="Imagen"/></div>`;
        } else if (media.tipo === 'video') {
          return `<div class="carousel-slide"><video controls><source src="${media.url}" type="video/mp4">Tu navegador no soporta videos.</video></div>`;
        }
        return '';
      }).join('');

      const mostrarControles = pub.multimedia.length > 1;
      const comentariosHTML = pub.comentarios.map(com => `
        <div class="comment">
            <a href="https://gravatar.com/${com.hash_correo}" target="_blank">
              <img src="https://www.gravatar.com/avatar/${com.hash_correo}" alt="Usuario" />
            </a>
          <p><strong>${com.correo}:</strong> ${com.comentario_texto}</p>
        </div>
      `).join('');

      const postHTML = `
        <div class="post">
          <div class="post-header">
            <a href="https://gravatar.com/${pub.hash_correo}" target="_blank">
              <img src="https://www.gravatar.com/avatar/${pub.hash_correo}" alt="Usuario" />
            </a>
            <div>
              <h3>${pub.autor}</h3>
              <span>Publicado el ${new Date(pub.fecha_publicacion).toLocaleDateString()}</span>
            </div>
            <div class="post-topic">
              <h5>Tema:</h5>
              <span>${pub.tema}</span>
            </div>
          </div>
          <h2 class="post-title">${pub.titulo}</h2>
          <p class="post-description">${pub.descripcion}</p>

          <div class="carousel">
            ${mostrarControles ? '<button class="prev">&#10094;</button>' : ''}
            <div class="carousel-container" id="carousel-${index}">
              ${multimediaHTML}
            </div>
            ${mostrarControles ? '<button class="next">&#10095;</button>' : ''}
          </div>

          <div class="post-footer">
            <button class="btn like-btn ${pub.es_favorito ? 'liked' : ''}" 
                    data-id="${pub.id_publicaciones}">
              👍 Me gusta <span>${pub.numero_likes}</span>
            </button>
            <button class="btn enviar-comentario" data-id="${pub.id_publicaciones}">💬 Comentar</button>
          </div>

          <div class="comments-section">
             <input type="text" placeholder="Escribe un comentario..." class="comment-input" data-id="${pub.id_publicaciones}" />
             <div class="comentarios-lista" data-id="${pub.id_publicaciones}">
                ${comentariosHTML}
             </div>
          </div>
        </div>
      `;

      container.insertAdjacentHTML('beforeend', postHTML);
    });

    inicializarCarruseles();
  } catch (error) {
    console.error(error);
  }
}

document.addEventListener('click', async (e) => {
  if (e.target.closest('.like-btn')) {
    const btn = e.target.closest('.like-btn');
    postId = btn.dataset.id;

    try {
      const response = await fetch('/api/toggle_favorito', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id_publicacion: postId })
      });

      if (!response.ok) throw new Error("Error al marcar favorito");
      const data = await response.json();

      btn.classList.toggle('liked');

      const span = btn.querySelector('span');
      span.textContent = data.numero_likes;

    } catch (error) {
      console.error(error);
    }
  }
});

document.addEventListener("click", async function (e) {
  if (e.target.classList.contains("enviar-comentario")) {
    postId = e.target.dataset.id;
    const input = document.querySelector(`.comment-input[data-id="${postId}"]`);
    const comentario = input.value.trim();

    if (!comentario) return alert("Escribe un comentario válido.");

    try {
      const response = await fetch('/api/crear_comentario', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          post_id: postId,
          comentario: comentario
        })
      });

      const res = await response.json();

      if (res.exito) {
        input.value = "";

        // Crear nuevo comentario y añadirlo al DOM
        const nuevoComentario = document.createElement("div");
        nuevoComentario.classList.add("comentario");
        nuevoComentario.innerHTML = `
          <strong>Tú</strong>: ${comentario} <span class="fecha-comentario">(Ahora)</span>
        `;
        const comentariosLista = document.querySelector(`.comentarios-lista[data-id="${postId}"]`);
        comentariosLista.appendChild(nuevoComentario);
      } else {
        alert("Error al publicar comentario");
      }
    } catch (error) {
      console.error("Error enviando comentario", error);
    }
  }
});

document.querySelector('.filter').addEventListener('click', async (e) => {
  await obtenerPublicacionesFiltradas();
});

// Modal elements
const modal = document.getElementById("edit-modal");
const closeBtn = modal.querySelector(".close");
const guardarBtn = modal.querySelector(".guardar-cambios");

let editPostId = null;

// Function to show modal
function showModal() {
  modal.classList.remove("hidden");
  document.body.style.overflow = 'hidden'; // Prevent background scrolling
}

// Function to hide modal
function hideModal() {
  modal.classList.add("hidden");
  document.body.style.overflow = 'auto'; // Restore scrolling
  editPostId = null;
}

// Event listener for edit buttons (using event delegation)
document.addEventListener("click", (e) => {
  // Handle edit button click
  if (e.target.classList.contains("editar-btn")) {
    e.preventDefault();
    e.stopPropagation();

    editPostId = e.target.dataset.id;
    console.log(editPostId)

    // Populate modal fields with current values
    document.getElementById("edit-titulo").value = e.target.dataset.titulo || '';
    document.getElementById("edit-descripcion").value = e.target.dataset.descripcion || '';
    //document.getElementById("edit-tema").value = e.target.dataset.tema || '';

    showModal();
  }
});

// Close modal when clicking the X button
closeBtn.addEventListener("click", (e) => {
  e.preventDefault();
  hideModal();
});

// Close modal when clicking outside the modal content
modal.addEventListener("click", (e) => {
  if (e.target === modal) {
    hideModal();
  }
});

// Close modal with Escape key
document.addEventListener("keydown", (e) => {
  if (e.key === "Escape" && !modal.classList.contains("hidden")) {
    hideModal();
  }
});

// Handle save changes button
guardarBtn.addEventListener("click", async (e) => {
  e.preventDefault();

  if (!editPostId) {
    alert("Error: No se ha seleccionado ninguna publicación para editar.");
    return;
  }

  const nuevoTitulo = document.getElementById("edit-titulo").value.trim();
  const nuevaDescripcion = document.getElementById("edit-descripcion").value.trim();
  //const nuevoTema = document.getElementById("edit-tema").value;

  // Validation

  /* if (!nuevaDescripcion) {
    alert("La descripción no puede estar vacía.");
    return;
  }
  
  if (!nuevoTema) {
    alert("Debe seleccionar un tema.");
    return;
  } */

  try {
    // Show loading state
    guardarBtn.disabled = true;
    guardarBtn.textContent = "Guardando...";
    //console.log(nuevoTitulo);
    //console.log(nuevaDescripcion);
    const formData = new FormData();
    formData.append('id_publicacion', editPostId);
    formData.append('titulo', nuevoTitulo);
    formData.append('descripcion', nuevaDescripcion);

    const res = await fetch("/api/editar_publicacion", {
      method: "POST",
      body: formData // Don't set Content-Type header
    });
    if (!res.ok) {
      throw new Error(`HTTP error! status: ${res.status}`);
    }

    // Try to parse JSON response
    let data;
    try {
      data = await res.json();
    } catch (jsonError) {
      console.error("Response is not valid JSON:", await res.text());
      throw new Error("El servidor no devolvió una respuesta válida");
    }

    if (data.exito) {
      hideModal();
      await obtenerPublicaciones(); // Refresh posts
      alert("Publicación editada exitosamente.");
    } else {
      alert("No se pudo editar la publicación: " + (data.mensaje || "Error desconocido"));
    }

  } catch (error) {
    console.error("Error al editar publicación:", error);

    // Show user-friendly error message
    if (error.message.includes("HTTP error")) {
      alert("Error del servidor. Por favor intente nuevamente.");
    } else if (error.message.includes("JSON")) {
      alert("Error de comunicación con el servidor.");
    } else {
      alert("Error de conexión. Intente nuevamente.");
    }
  } finally {
    // Restore button state
    guardarBtn.disabled = false;
    guardarBtn.textContent = "Guardar cambios";
  }
});
