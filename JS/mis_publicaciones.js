document.addEventListener("DOMContentLoaded", function () {
  const posts = document.querySelectorAll(".post");
  const form = document.querySelector(".edit-post-form");
  document.querySelector(".edit-btn").addEventListener("click", toggleEditForm);
  document.querySelector(".cancel-btn").addEventListener("click", toggleEditForm);
  form.style.display = "none";

  posts.forEach((post, index) => {
    post.dataset.currentSlide = 0; // Inicializa cada post con su propio índice de slide

    const prevBtn = post.querySelector(".prev");
    const nextBtn = post.querySelector(".next");

    prevBtn.addEventListener("click", () => changeSlide(-1, post));
    nextBtn.addEventListener("click", () => changeSlide(1, post));
  });
});

function toggleEditForm() {
  const form = document.querySelector(".edit-post-form");

  if (form.style.display == "none") {
    form.style.display = "block";
  } else {
    form.style.display = "none";
  }
}

function previewImages(event) {
  const files = event.target.files;
  const container = document.getElementById("edit-carousel-container");
  container.innerHTML = ""; // Limpiar el contenedor

  for (let i = 0; i < files.length; i++) {
    const file = files[i];
    const reader = new FileReader();

    reader.onload = function (e) {
      const slide = document.createElement("div");
      slide.classList.add("carousel-slide");

      if (file.type.startsWith("image/")) {
        const img = document.createElement("img");
        img.src = e.target.result;
        slide.appendChild(img);
      } else if (file.type.startsWith("video/")) {
        const video = document.createElement("video");
        video.controls = true;
        const source = document.createElement("source");
        source.src = e.target.result;
        source.type = file.type;
        video.appendChild(source);
        slide.appendChild(video);
      }

      container.appendChild(slide);
    };

    reader.readAsDataURL(file);
  }
  const buttons = document.querySelector(".buttons-edit-carousel");
  buttons.style.display = "block";
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

  post.dataset.currentSlide = currentSlide; // Actualiza el slide actual del post
  const translateValue = -currentSlide * 100 + "%";
  carouselContainer.style.transform = "translateX(" + translateValue + ")";
}