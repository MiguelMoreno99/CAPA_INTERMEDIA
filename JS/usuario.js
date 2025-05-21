// Seleccionar todos los campos
const correoUsuario = document.getElementById("correoUsuario").innerText.trim().toLowerCase();

const passwordInput = document.getElementById("contrasenia");
const confirmPasswordInput = document.getElementById("confirmarContrasenia");
const guardar_cambiosBtn = document.getElementById("guardar_cambiosBtn");

const form = document.getElementById("actualizar_usuarioForm");

const infoContainer = document.getElementById('Info-Container');
const fotoContainer = document.getElementById('Foto-Container');

// Expresiones regulares para validación
const passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/; // Contraseña válida

//Datos de Gravatar
const gravatarData = fetchData(correoUsuario);

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

// // Escuchar cambios en los campos
passwordInput.addEventListener("input", function () {
  ValidarContrasenia();
  validarContraseniaIgual();
});
confirmPasswordInput.addEventListener("input", function () {
  validarContraseniaIgual();
});

//Funciones para validar los campos
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
function validarFormulario() {
  let isValid = true; // Se asume que todo está correcto

  if (!ValidarContrasenia()) isValid = false;
  if (!validarContraseniaIgual()) isValid = false;

  return isValid; // Retorna false si hay al menos un error
}

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

function fetchData(correoUsuario) {

  const hash = CryptoJS.SHA256(correoUsuario).toString(CryptoJS.enc.Hex);
  const response = fetch(`/API/gravatar_proxy.php?hash=${hash}`)
    .then(response => {
      if (!response.ok) throw new Error("Error al obtener datos");
      return response.json();
    })
    .then(data => {
      console.log(data);
      renderPerfilData(data);
    })
    .catch(error => {
      console.error("Error:", error);
    });
}

function renderPerfilData(data) {
  let html1 = ""; // Inicializa html1
  // Avatar
  if (data.avatar_url) {
    html1 = `<a href="${data.profile_url}" target="_blank"><img src="https://www.gravatar.com/avatar/${data.hash}" alt="${data.display_name}"></img></a>`;
  }
  // Empieza a construir el HTML
  let html = `<div class="card"><div class="profile">`;

  // Nombre y pronombres
  html += `<div class="profile-info">`;
  if (data.display_name) {
    html += `<h2>${data.display_name}`;
    if (data.pronouns) {
      html += ` <span>(${data.pronouns})</span>`;
    }
    html += `</h2>`;
  } else {
    html += `<h2>Nombre no disponible</h2>`;
  }

  // Ubicación
  if (data.location) {
    html += `<p><strong>Ubicación:</strong> ${data.location}</p>`;
  } else {
    html += `<p><strong>Ubicación:</strong> No disponible</p>`;
  }

  // Ocupación
  if (data.job_title) {
    html += `<p><strong>Ocupación:</strong> ${data.job_title}</p>`;
  } else {
    html += `<p><strong>Ocupación:</strong> No disponible</p>`;
  }

  // Descripción
  if (data.description) {
    html += `<p><strong>Descripción:</strong> ${data.description}</p>`;
  } else {
    html += `<p><strong>Descripción:</strong> No disponible</p>`;
  }

  html += `</div></div>`; // Cierra profile-info y profile

  // Redes verificadas
  if (Array.isArray(data.verified_accounts) && data.verified_accounts.length > 0) {
    html += `<div class="section"><h3>Redes verificadas</h3><div class="social-links">`;
    data.verified_accounts.forEach(account => {
      if (account.url && account.service_icon) {
        html += `
          <span class="tag"> <a href="${account.url}" target="_blank">
            <img src="${account.service_icon}" alt="${account.service_label}"">
          </a></span>
        `;
      }
    });
    html += `</div></div>`;
  } else {
    html += `<div class="section"><h3>Redes verificadas</h3><div class="social-links">`;
    html += `<p>No disponible</p>`;
    html += `</div></div>`;
  }

  // Idiomas
  if (Array.isArray(data.languages) && data.languages.length > 0) {
    html += `<div class="section"><h3>Idiomas</h3><div class="tags">`;
    data.languages.forEach(lang => {
      if (lang.name) html += `<span class="tag">${lang.name}</span>`;
    });
    html += `</div></div>`;
  } else {
    html += `<div class="section"><h3>Idiomas</h3><div class="tags">`;
    html += `<p>No disponible</p>`;
    html += `</div></div>`;
  }

  // Intereses
  if (Array.isArray(data.interests) && data.interests.length > 0) {
    html += `<div class="section"><h3>Intereses</h3><div class="tags">`;
    data.interests.forEach(i => {
      if (i.name) html += `<span class="tag">${i.name}</span>`;
    });
    html += `</div></div>`;
  } else {
    html += `<div class="section"><h3>Intereses</h3><div class="tags">`;
    html += `<p>No disponible</p>`;
    html += `</div></div>`;
  }

  // Galería
  if (Array.isArray(data.gallery) && data.gallery.length > 0) {
    html += `<div class="section"><h3>Galería</h3><div class="gallery">`;
    data.gallery.forEach(img => {
      if (img.url) html += `<img src="${img.url}" alt="">`;
    });
    html += `</div></div>`;
  } else {
    html += `<div class="section"><h3>Galería</h3><div class="gallery">`;
    html += `<p>No disponible</p>`;
    html += `</div></div>`;
  }

  // Contacto
  if (
    (data.contact_info && (data.contact_info.email || data.contact_info.cell_phone)) ||
    (data.payments && Array.isArray(data.payments.links) && data.payments.links.length > 0)
  ) {
    html += `<div class="section"><h3>Contacto</h3>`;

    if (data.contact_info?.email) {
      html += `<p><strong>Correo:</strong> ${data.contact_info.email}</p>`;
    }
    if (data.contact_info?.cell_phone) {
      html += `<p><strong>Celular:</strong> ${data.contact_info.cell_phone}</p>`;
    }

    if (data.payments?.links) {
      data.payments.links.forEach(link => {
        if (link.label && link.url) {
          html += `<p><strong>${link.label}:</strong> <a href="${link.url}" target="_blank">${link.url}</a></p>`;
        }
      });
    }

    html += `</div>`;
  } else {
    html += `<div class="section"><h3>Contacto</h3>`;
    html += `<p>No disponible</p>`;
    html += `</div>`;
  }

  html += `</div>`; // Cierra .card

  infoContainer.innerHTML = html;
  fotoContainer.innerHTML += html1;
}