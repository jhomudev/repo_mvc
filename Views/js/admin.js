// fucnionalidades a filtros
const filters = document.querySelectorAll(".filter__item");

filters.forEach((filter) => {
  filter.addEventListener("click", () => {
    const fil = filter.dataset.state;
    getProjects(fil);
  });
});

//PETICIONES FECTH
async function getProjects(filter = "") {
  try {
    // peticion
    const req = await fetch(`${serverURL}/fetch/getProjectsFetch.php`, {
      method: "POST",
      body: new URLSearchParams(`filter=${filter}`),
    });
    const res = await req.json();
    const boxProject = document.getElementById("projectsBox");
    if (res.length > 0) {
      boxProject.innerHTML = "";
      res.forEach((project) => {
        boxProject.innerHTML += `
        <article class="project" style="--cl:${project.color}">
          <a href="${serverURL}/project?id=${project.proyecto_id}" class="project__link"></a>
          <h1 class="project__title">${project.titulo}</h1>
          <h2 class="project__type">PROYECTO DE ${project.tipo}</h2>
          <p class="project__descri">${project.descripcion}</p>
          <span class="project__state">${project.estado}</span>
        </article>
          `;
      });
    } else {
      boxProject.innerHTML = `
        <div class="projectBox__message"><i>No hay proyectos</i></div>
        `;
    }
  } catch (error) {
    console.log("Ocurrio un error: " + error.message);
  }
}

getProjects();
