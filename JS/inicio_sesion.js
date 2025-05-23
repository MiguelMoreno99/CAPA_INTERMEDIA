
const emailInput = document.getElementById("correo_usuario");
const passwordInput = document.getElementById("contrasenia_usuario");
const loginBtn = document.getElementById("loginBtn");
const form = document.getElementById("inicio_sesionForm");

// Expresión regular para validar correo
const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

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

// Escuchar cambios en los campos
emailInput.addEventListener("input", function () {
  validarCorreo();
});
passwordInput.addEventListener("input", function () {
  ValidarContrasenia();
});

//Funciones para validar los campos
function validarCorreo() {
  let isValid = true;
  if (!emailRegex.test(emailInput.value)) {
    showError(emailInput, "Correo electrónico no válido.");
    isValid = false;
  } else {
    clearError(emailInput);
  }
  return isValid;
}
function ValidarContrasenia() {
  let isValid = true;
  if (passwordInput.value.trim() === "") {
    showError(passwordInput, "Ingrese una contraseña primero.");
    isValid = false;
  } else {
    clearError(passwordInput);
  }
  return isValid;
}
function validarFormulario() {
  let isValid = true; // Se asume que todo está correcto

  if (!validarCorreo()) isValid = false;
  if (!ValidarContrasenia()) isValid = false;

  return isValid; // Retorna false si hay al menos un error
}

// Manejar el envío del formulario
loginBtn.addEventListener("click", function (event) {
  event.preventDefault();
  if (validarFormulario()) {
    let hashInput = document.getElementById("hash_correo");
    let hash_correo = CryptoJS.SHA256(emailInput.value.trim().toLowerCase()).toString(CryptoJS.enc.Hex);
    hashInput.value = hash_correo;
    form.submit();
  } else {
    alert("Por favor, corrige los errores antes de enviar.");
    return false; // Evita el envío si hay errores
  }
});
