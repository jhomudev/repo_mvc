// togle de barra de usuario opciones
const userBar = document.querySelector(".nav__bar");
const userBarRes = document.querySelector(".nav__res__bar");
const iconUser = document.getElementById("iconUser");
const btnCloseUserBar = document.querySelector(".nav__res__iconClose");

function toggleShowElement(element) {
  element.classList.toggle("show");
}
iconUser.addEventListener("click", (e) => {
  toggleShowElement(userBar);
  toggleShowElement(userBarRes);
});
btnCloseUserBar.addEventListener("click", (e) => {
  toggleShowElement(userBar);
  toggleShowElement(userBarRes);
});

// Limitar palabras de la descripción de los trámites/proyectos
const allDescrips = document.querySelectorAll(".project__descri");

allDescrips.forEach((descri) => {
  let words = descri.textContent.split(" ");

  if (words.length > 20) {
    descri.textContent = words.slice(0, 20).join(" ") + "...";
  }
});
