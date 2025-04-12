// Seleccionar todos los campos
const nombreInput = document.getElementById("nombre");
const apellidoInput = document.getElementById("apellido");
const nombreUsuarioInput = document.getElementById("nombre_usuario");
const passwordInput = document.getElementById("password");
const confirmPasswordInput = document.getElementById("confirm_password");
// const fotoInput = document.getElementById("foto");
// const profilePreview = document.getElementById("profilePreview");
const guardar_cambiosBtn = document.getElementById("guardar_cambiosBtn");
const form = document.getElementById("info_usuarioForm");

// Expresiones regulares para validación
const passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/; // Contraseña válida
const nombreRegex = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/; // Solo letras y espacios
const nombreUsuarioRegex = /^[A-Za-z0-9!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+$/;


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
nombreInput.addEventListener("input", function () {
  validarNombre();
});
apellidoInput.addEventListener("input", function () {
  validarApellido();
});
nombreUsuarioInput.addEventListener("input", function () {
  validarNombreUsuario();
});
passwordInput.addEventListener("input", function () {
  ValidarContrasenia();
  validarContraseniaIgual();
});
confirmPasswordInput.addEventListener("input", function () {
  validarContraseniaIgual();
});

//Funciones para validar los campos
function validarNombre() {
  let isValid = true;
  if (nombreInput.value.trim() === "") {
    showError(nombreInput, "El nombre es obligatorio.");
    isValid = false;
  } else if (!nombreRegex.test(nombreInput.value)) {
    showError(nombreInput, "Solo se permiten letras y espacios.");
    isValid = false;
  } else {
    clearError(nombreInput);
  }
  return isValid;
}
function validarApellido() {
  let isValid = true;
  if (apellidoInput.value.trim() === "") {
    showError(apellidoInput, "El apellido es obligatorio.");
    isValid = false;
  } else if (!nombreRegex.test(apellidoInput.value)) {
    showError(apellidoInput, "Solo se permiten letras y espacios.");
    isValid = false;
  } else {
    clearError(apellidoInput);
  }
  return isValid;
}
function validarNombreUsuario() {
  let isValid = true;
  if (nombreUsuarioInput.value.trim() === "") {
    showError(nombreUsuarioInput, "El nombre de usuario es obligatorio.");
    isValid = false;
  } else if (!nombreUsuarioRegex.test(nombreUsuarioInput.value)) {
    showError(nombreUsuarioInput, "Solo se permiten letras, números y caracteres especiales.");
    isValid = false;
  } else {
    clearError(nombreUsuarioInput);
  }
  return isValid;
}
function ValidarContrasenia() {
  let isValid = true;
  if (passwordInput.value.trim() === "") {
    isValid = true;
  } else if (!passwordRegex.test(passwordInput.value)) {
    showError(
      passwordInput,
      "La contraseña debe tener al menos 8 caracteres, 1 número, 1 mayúscula, 1 minúscula y 1 carácter especial."
    );
    isValid = false;
  } else {
    clearError(passwordInput);
  }
  return isValid;
}
function validarContraseniaIgual() {
  let isValid = true;
  if (passwordInput.value !== confirmPasswordInput.value) {
    showError(confirmPasswordInput, "Las contraseñas no coinciden.");
    isValid = false;
  } else {
    clearError(confirmPasswordInput);
  }
  return isValid;
}
function validarFormulario() {
  let isValid = true; // Se asume que todo está correcto

  if (!validarNombre()) isValid = false;
  if (!validarApellido()) isValid = false;
  if (!validarNombreUsuario()) isValid = false;
  if (!ValidarContrasenia()) isValid = false;
  if (!validarContraseniaIgual()) isValid = false;

  return isValid; // Retorna false si hay al menos un error
}

// Previsualización de la imagen
// fotoInput.addEventListener("change", function (event) {
//   const file = event.target.files[0];
//   if (file) {
//     const reader = new FileReader();
//     reader.onload = function (e) {
//       profilePreview.src = e.target.result;
//     };
//     reader.readAsDataURL(file);
//   }
// });

// Manejar el envío del formulario
guardar_cambiosBtn.addEventListener("click", function (event) {
  event.preventDefault();
  if (validarFormulario()) {
    form.submit();
  } else {
    alert("Por favor, corrige los errores antes de enviar.");
    return false; // Evita el envío si hay errores
  }
});
