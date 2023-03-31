// toggle de formulario
const box = document.querySelector(".formBackground");

function toggleForm() {
  box.classList.toggle("show");
  userBar.classList.remove("show");
  formUpload.reset();
}
// document.addEventListener("mouseup", function (event) {
//   if (box.classList.contains("show") && !formUpload.contains(event.target))
//     toggleForm();
// });

const btnUpload = document.getElementById("upload");
btnUpload.addEventListener("click", toggleForm);
closeForm.addEventListener("click", toggleForm);

//PETICIONES FECTH
async function getProjects() {
  // la funcio nya no enviara el id del usuario, xq en el archivo php ya se hara  el sesion start
  try {
    const req = await fetch(
      "http://localhost/repo_poo/src/Controller/CtrlGetProUser.php"
    );
    if (req.ok) {
      const res = await req.json();
      console.log(res);
      const boxProject = document.getElementById("projectsBox");
      res.forEach((project) => {
        boxProject.innerHTML = `
        <article class="project" style="--cl:${project.clr}">   
          <h1 class="project__title">${project.titulo}</h1>
          <h2 class="project__type">PROYECTO DE ${project.tipo}</h2>
          <p class="project__descri">${project.descripcion}</p>
          <span class="project__state">${project.estado}</span>
        </article>
        `;
      });
    }
  } catch (error) {
    console.log("Ocurrio un error: " + error.message);
  }
}

// const form = document.getElementById("formUpload");

// form.addEventListener("submit", async (e) => {
//   e.preventDefault();
//   try {
//     const req = await fetch(e.target.getAttribute("action"), {
//       method: e.target.getAttribute("method"),
//       body: new FormData(e.target),
//     });

//     if (req.ok) {
//       const res = await req.text();
//       console.log(res);
//       toggleForm();

//       if (res == "ok") {
//         Swal.fire({
//           position: "center",
//           icon: "success",
//           title: "Proyecto subido",
//           showConfirmButton: false,
//           timer: 1500,
//         });
//       } else if (res == "exist") {
//         Swal.fire({
//           icon: "error",
//           title: "Oops...",
//           text: "No puedes subir más de un proyecto",
//         });
//       }
//     }
//   } catch (error) {
//     console.log("Ocurrio un error: " + error.message);
//   }
// });
