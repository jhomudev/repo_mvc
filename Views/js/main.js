// Variables globales
const serverURL = "http://localhost/repo_mvc";

function toggleShowElement(element) {
  element.classList.toggle("show");
}

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
  } else if (alert.Alert === "clear") {
    Swal.fire({
      icon: alert.icon,
      title: alert.title,
      text: alert.text,
      confirmButtonText: "Aceptar",
    });
  } else if (alert.Alert === "reload") {
    window.location.reload();
  }
}

const formsFetch = document.querySelectorAll(".formFetch");

async function sendFormFetch(e, functionToExec=(e)) {
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
    text: "Esta acción es irreversible",
    icon: "warning",
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
        alertFetch(res);
        if (functionToExec !== "undefined" || functionToExec !== null)
          functionToExec();
      }
    } catch (error) {
      console.log(error);
    }
  });
}
