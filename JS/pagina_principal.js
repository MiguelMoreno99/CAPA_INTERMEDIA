const posts = document.querySelectorAll(".post");
let publicacionesDisponibles = [];

obtenerPublicaciones();

posts.forEach((post, index) => {
  post.dataset.currentSlide = 0; // Inicializa cada post con su propio índice de slide

  const prevBtn = post.querySelector(".prev");
  const nextBtn = post.querySelector(".next");

  prevBtn.addEventListener("click", () => changeSlide(-1, post));
  nextBtn.addEventListener("click", () => changeSlide(1, post));
});

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

  post.dataset.currentSlide = currentSlide; // Actualiza el slide actual del post
  const translateValue = -currentSlide * 100 + "%";
  carouselContainer.style.transform = "translateX(" + translateValue + ")";
}

async function obtenerPublicaciones() {
  try {
    const response = await fetch('/api/publicaciones');
    if (!response.ok) throw new Error('Error al obtener contactos publicaciones');

    publicacionesDisponibles = await response.json();
    console.log(publicacionesDisponibles);

  } catch (error) {
    console.error(error);
  }
}
