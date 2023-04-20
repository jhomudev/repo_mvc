// toggle de formulario
const box = document.querySelector(".formBackground");

//PETICIONES FECTH
async function getProjects() {
  try {
    // peticion
    const req = await fetch(`${serverURL}/fetch/getProcess.php`);
    if (req.ok) {
      const res = await req.json();
      console.log(res);
      const boxProject = document.getElementById("projectsBox");
      boxProject.innerHTML = "";
      res.forEach((project) => {
        boxProject.innerHTML += `
        <article class="project" style="--cl:${project.clr}">  
          <a href="${serverURL}/project?id=${project.proyecto_id}" class="project__link"></a>
          <h1 class="project__title">${project.titulo}</h1>
          <h2 class="project__type">PROYECTO DE ${project.tipo}</h2>
          <p class="project__descri">${project.descripcion}</p>
          <span class="project__state">${project.estado}</span>
        </article>
        `;
      });
      boxProject.innerHTML += `
      <article id="upload" class="project project__upload">
        <i class="ph-upload-simple"></i>
        <span>Subir proyecto</span>
      </article>
      `;

      const btnUpload = document.getElementById("upload");
      const closeForm = document.getElementById("closeForm");

      btnUpload.addEventListener("click", () => toggleShowElement(box));
      closeForm.addEventListener("click", () => toggleShowElement(box));

      formsFetch.forEach((form) => {
        form.addEventListener("submit", (e) => {
          sendFormFetch(e, () => {
            getProjects();
            toggleShowElement(box);
          });
        });
      });
    }
  } catch (error) {
    console.log("Ocurrio un error: " + error.message);
  }
}

getProjects();
