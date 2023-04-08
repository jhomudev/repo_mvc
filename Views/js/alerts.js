const formsFetch = document.querySelectorAll(".formFetch");

function sendFormFetch(e) {
  e.preventDefault();

  const data = new FormData(this);
  const method = this.getAttribute("method");
  const action = this.getAttribute("action");

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
        // console.log(res)
      }
    } catch (error) {
      console.log(error);
    }
  });
}

formsFetch.forEach((form) => {
  form.addEventListener("submit", sendFormFetch);
});

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
    toggleForm();
  }
  else if (alert.Alert === "reload") {
    window.location.reload();
  }
}
