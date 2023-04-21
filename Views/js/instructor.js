//PETICIONES FECTH
async function getProjects() {
  try {
    // peticion
    const req = await fetch(`${serverURL}/fetch/getProcess.php`);
    if (req.ok) {
      const res = await req.json();
      console.log(res);
      const boxProject = document.getElementById("projectsBox");
      if (res.length > 0) {
        res.forEach((project) => {
          boxProject.innerHTML = `
          <article class="project" style="--cl:${project.clr}">  
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
    }
  } catch (error) {
    console.log("Ocurrio un error: " + error.message);
  }
}

getProjects();
