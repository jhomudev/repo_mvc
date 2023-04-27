// Toggle de etiqueta details del proyecto
const details = document.querySelectorAll(".details");
details.forEach((item) => {
  item.addEventListener("toggle", () => {
    const icon = item.children[0].children[1];
    if (item.open) {
      icon.classList.remove("open");
    } else {
      icon.classList.add("open");
    }
  });
});

// Funcion mostrar formulario newObs
const btnNewObs = document.querySelector(".newObs__btnNewObs");
const formNewObs = document.querySelector(".newObs__form");

if (btnNewObs && formNewObs) {
  btnNewObs.addEventListener("click", () => formNewObs.classList.add("show"));

  document.addEventListener("click", function (e) {
    // Comprobar si el clic ocurrió fuera del div
    if (!btnNewObs.contains(e.target) && !formNewObs.contains(e.target)) {
      formNewObs.classList.remove("show");
    }
  });
}

// Funcionalidad de envio de forms con fetch
formsFetch.forEach((form) => {
  form.addEventListener("submit", (e) => {
    sendFormFetch(e);
  });
});