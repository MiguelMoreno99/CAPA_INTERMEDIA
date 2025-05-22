let publicacionesDisponibles = [];
let postId = 0;

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
    const response = await fetch('/api/publicaciones');
    if (!response.ok) throw new Error('Error al obtener contactos publicaciones');

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
            <button class="btn comment-btn">💬 Comentar</button>
          </div>

          <div class="comments-section">
            <input type="text" placeholder="Escribe un comentario..." class="comment-input" />
            ${comentariosHTML}
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

      // Alternar la clase visual
      btn.classList.toggle('liked');

      // Actualizar contador de likes
      const span = btn.querySelector('span');
      span.textContent = data.numero_likes;

    } catch (error) {
      console.error(error);
    }
  }
});
