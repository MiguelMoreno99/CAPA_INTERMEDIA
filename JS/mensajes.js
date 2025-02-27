// Script temporal para el boton de cifrado
function toggleCifrado() {
  var button = document.getElementById("cifrado-btn");
  button.classList.toggle("active");
  if (button.classList.contains("active")) {
    button.textContent = "Activado";
  } else {
    button.textContent = "Desactivado";
  }
}
