// togle de barra de usuario opciones
const userBar = document.getElementById("userBar");
const iconUser = document.getElementById("iconUser");
iconUser.addEventListener("click", (e) => {
  userBar.classList.toggle("show");
});

// Limitar palabras de la descripción de los trámites/proyectos
const allDescrips = document.querySelectorAll(".project__descri");

allDescrips.forEach((descri) => {
  let words = descri.textContent.split(" ");

  if (words.length > 20) {
    descri.textContent = words.slice(0, 20).join(" ") + "...";
  }
});
