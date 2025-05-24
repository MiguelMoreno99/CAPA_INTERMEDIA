let currentSlide = 0;
const form = document.getElementById("crear-post-form");
const submitBtn = document.getElementById("crearPostBtn");

const titulo = document.getElementById("edit-title");
const categoria = document.getElementById("filter-topic");
const descripcion = document.getElementById("edit-description");
const multimedia = document.getElementById("edit-media");

// Función para mostrar errores
function showError(input, message) {
  const errorMessage = input.parentNode.querySelector(".error-message");
  if (errorMessage) {
    errorMessage.textContent = message;
    errorMessage.style.display = "block";
    input.classList.add("invalid");
  }
}

// Función para limpiar errores
function clearError(input) {
  const errorMessage = input.parentNode.querySelector(".error-message");
  if (errorMessage) {
    errorMessage.textContent = "";
    errorMessage.style.display = "none";
    input.classList.remove("invalid");
  }
}

// Manejar el envío del formulario
submitBtn.addEventListener("click", function (event) {
  event.preventDefault();
  if (validarFormulario()) {
    form.submit();
  } else {
    alert("Por favor, corrige los errores antes de enviar.");
    return false; // Evita el envío si hay errores
  }
});

function changeSlide(direction, postIndex) {
  const carousels = document.querySelectorAll(".carousel-container");
  const totalSlides = carousels[postIndex].children.length;

  currentSlide += direction;

  if (currentSlide < 0) {
    currentSlide = totalSlides - 1;
  } else if (currentSlide >= totalSlides) {
    currentSlide = 0;
  }

  const translateValue = -currentSlide * 100 + "%";
  carousels[postIndex].style.transform = "translateX(" + translateValue + ")";
}

function previewImages(event) {
  const files = event.target.files;
  const container = document.getElementById("edit-carousel-container");
  const buttons = document.querySelector(".buttons-edit-carousel");

  container.innerHTML = ""; // Limpiar el contenedor

  if (files.length <= 1) {
    buttons.style.display = "none";
  } else {
    buttons.style.display = "block";
  }

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
}

function validarFormulario() {
  let isValid = true; // Se asume que todo está correcto

  if (titulo.value === "") {
    showError(titulo, "El título no puede estar vacío.");
    isValid = false;
  } else {
    clearError(titulo);
  }
  if (categoria.value === "") {
    showError(categoria, "Debes seleccionar una categoría.");
    isValid = false;
  } else {
    clearError(categoria);
  }
  if (descripcion.value === "") {
    showError(descripcion, "La descripción no puede estar vacía.");
    isValid = false;
  } else {
    clearError(descripcion);
  }

  return isValid; // Retorna false si hay al menos un error
}