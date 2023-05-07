// Variables globales
const serverURL = "http://localhost/repo_mvc";

// funcion mostrar un elemento
function toggleShowElement(element) {
  element.classList.toggle("show");
}

// funcion de convettir a mayuculas
const mayus = document.querySelectorAll("[mayus]");
mayus.forEach((input) => {
  input.addEventListener(
    "input",
    () => (input.value = input.value.toUpperCase())
  );
});

// Funciones validaciones de inputs decimales
const inputsDecimal = document.querySelectorAll("input[decimal]");

inputsDecimal.forEach((input) => {
  input.addEventListener("input", (e) => {
    let valorAnterior = e.target.value;
    let valorNuevo = valorAnterior.replace(/[^0-9,]/g, ""); // Solo permitir números y puntos
    const decimales = valorNuevo.split(",").length - 1;

    if (decimales > 1) {
      // Si hay más de un punto, eliminar el último
      const ultimoPunto = valorNuevo.lastIndexOf(",");
      valorNuevo = valorNuevo.substring(0, ultimoPunto);
    }

    if (valorAnterior !== valorNuevo) {
      e.target.value = valorNuevo; // Actualizar el valor del input
    }
  });
});

// Limitar palabras un string de los trámites/proyectos---Ya innecesario
function limitString(limit) {
  const allDescrips = document.querySelectorAll(".project__descri");

  allDescrips.forEach((descri) => {
    let words = descri.textContent.split(" ");

    if (words.length > limit) {
      descri.textContent = words.slice(0, limit).join(" ") + "...";
    }
  });
}

// Funcion de envio de formularios
function alertFetch(alert = {}) {
  if (alert.Alert === "simple") {
    Swal.fire({
      icon: alert.icon,
      title: alert.title,
      text: alert.text,
      confirmButtonText: "Aceptar",
    });
  } else if (alert.Alert === "reload") {
    window.location.reload();
  } else if (alert.Alert === "alert&reload") {
    Swal.fire({
      icon: alert.icon,
      title: alert.title,
      text: alert.text,
      confirmButtonText: "Aceptar",
    }).then((e) => window.location.reload());
  }
}

const formsFetch = document.querySelectorAll(".formFetch");

function sendFormFetch(e) {
  e.preventDefault();

  const data = new FormData(e.target);
  const method = e.target.getAttribute("method");
  const action = e.target.getAttribute("action");

  const config = {
    method: method,
    body: data,
  };

  Swal.fire({
    title: "Estas seguro de realizar la operación?",
    text: "Esta acción podría ser irreversible.",
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Aceptar",
    cancelButtonText: "Cancelar",
  }).then(async (result) => {
    try {
      if (result.isConfirmed) {
        const req = await fetch(action, config);
        const res = await req.json();
        console.log(res);
        alertFetch(res);
      }
    } catch (error) {
      console.log(error);
    }
  });
}
