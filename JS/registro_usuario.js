// Seleccionar todos los campos

const emailInput = document.getElementById("correo_usuario");
const passwordInput = document.getElementById("contrasenia_usuario");
const confirmPasswordInput = document.getElementById("confirmar_contrasenia");
const fotoInput = document.getElementById("foto");
const radioGrupo = document.getElementById("radio-grupo");
const profilePreview = document.getElementById("profilePreview");
const registerBtn = document.getElementById("registerBtn");
const form = document.getElementById("registro_usuarioForm");

const radiosInput = document.getElementsByName("rol");

// Expresiones regulares para validación
const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Correo válido
const passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/; // Contraseña válida

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
  validarContraseniaIgual();
});
confirmPasswordInput.addEventListener("input", function () {
  validarContraseniaIgual();
});
fotoInput.addEventListener("change", function () {
  validarImagen();
});
radiosInput.forEach((radio) => {
  radio.addEventListener("change", function () {
    validarRadio();
  });
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
async function validarCorreoGravatar() {
  try {
    const result = await fetchData(emailInput.value.trim().toLowerCase());
    if (!result || result.error === "Profile not found") {
      showError(emailInput, "Correo electrónico no registrado en Gravatar.");
      return false;
    } else {
      clearError(emailInput);
      return true;
    }
  } catch (err) {
    showError(emailInput, "Error al conectar con Gravatar.");
    return false;
  }
}
function ValidarContrasenia() {
  let isValid = true;
  if (!passwordRegex.test(passwordInput.value)) {
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
function validarImagen() {
  let isValid = true;
  if (!fotoInput.files || fotoInput.files.length === 0) {
    showError(fotoInput, "Debes seleccionar una imagen.");
    isValid = false;
  } else {
    clearError(fotoInput);
  }
  return isValid;
}
function validarRadio() {
  let isValid = false;

  for (let i = 0; i < radiosInput.length; i++) {
    if (radiosInput[i].checked) {
      isValid = true;
      clearError(radioGrupo);
      break;
    }
  }
  if (!isValid) {
    showError(radioGrupo, "Debes seleccionar una opcion.");
    isValid = false;
  }
  return isValid;
}
function validarFormulario() {
  let isValid = true; // Se asume que todo está correcto

  if (!validarCorreo()) isValid = false;
  if (!ValidarContrasenia()) isValid = false;
  if (!validarContraseniaIgual()) isValid = false;
  if (!validarRadio()) isValid = false;
  if (!validarImagen()) isValid = false;

  return isValid; // Retorna false si hay al menos un error
}

// Previsualización de la imagen
fotoInput.addEventListener("change", function (event) {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function (e) {
      profilePreview.src = e.target.result;
    };
    reader.readAsDataURL(file);
  }
});

// Manejar el envío del formulario
registerBtn.addEventListener("click", async function (event) {
  event.preventDefault();
  if (validarFormulario()) {
    const gravatarValido = await validarCorreoGravatar();
    if (gravatarValido) {
      let hashInput = document.getElementById("hash_correo");
      let hash_correo = CryptoJS.SHA256(emailInput.value.trim().toLowerCase()).toString(CryptoJS.enc.Hex);
      hashInput.value = hash_correo;
      form.submit();
    }
  } else {
    alert("Por favor, corrige los errores antes de enviar.");
    return false; // Evita el envío si hay errores
  }
});

async function fetchData(correoUsuario) {
  try {
    const hash = CryptoJS.SHA256(correoUsuario).toString(CryptoJS.enc.Hex);
    const response = await fetch(`/API/gravatar_proxy.php?hash=${hash}`);
    if (!response.ok) throw new Error("Error al obtener datos");
    const data = await response.json();
    console.log(data);
    return data;
  }
  catch (error) {
    console.error("Error:", error);
  }
}
