// toggle de formulario
const box = document.querySelector(".formBackground");

formsFetch.forEach((form) => {
  form.addEventListener("submit", (e) => sendFormFetch(e));
});

//PETICIONES FECTH
async function getProjects() {
  try {
    // peticion
    const req = await fetch(`${serverURL}/fetch/getProjectsFetch.php`);
    const res = await req.json();
    const boxProject = document.getElementById("projectsBox");
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
    boxProject.innerHTML += `
      <article id="upload" class="project project__upload toggle__form">
        <i class="ph-upload-simple"></i>
        <span>Subir proyecto</span>
      </article>
      `;

    const toggleForm = document.querySelectorAll(".toggle__form");
    toggleForm.forEach((btn) => {
      btn.addEventListener("click", () => toggleShowElement(box));
    });
  } catch (error) {
    console.log(error);
  }
}

getProjects();

// funcion show list estudiantes
const authorsBox = document.querySelector(".form__authorsBox");
const authorsList = document.querySelector(".list__users");
const inputShow = document.querySelector(".inputShow");
const authorsInput = document.getElementsByName("tx_authors")[0];
let arrayAuthors = [];

inputShow.addEventListener("input", () => {
  if (inputShow.value !== "") authorsList.classList.add("show");
  else authorsList.classList.remove("show");

  getStudents(inputShow.value);
});

async function getStudents(nameOrId) {
  try {
    const req = await fetch(`${serverURL}/fetch/getStudentsFetch.php`, {
      method: "POST",
      body: new URLSearchParams(`words=${nameOrId}`),
    });
    const res = await req.json();
    authorsList.innerHTML = "";

    res.forEach((student) => {
      authorsList.innerHTML += `<li class="list__users__item" data-id="${student.id}" data-name="${student.fullname}"><h1>${student.fullname}</h1><p>${student.correo}</p></li>`;
    });

    const itemsList = document.querySelectorAll(".list__users__item");
    itemsList.forEach((item) => {
      item.addEventListener("click", () => {
        const id = item.dataset.id;
        const name = item.dataset.name;

        arrayAuthors.push({ id, name });
        arrayAuthors = arrayAuthors.filter(
          (obj, index, self) => index === self.findIndex((o) => o.id === obj.id)
        );

        updateAuthorsBox();

        const popAuthorBtns = document.querySelectorAll(".popAuthor");
        popAuthorBtns.forEach((btn) => {
          btn.addEventListener("click", () => {
            idPop = btn.dataset.id;
            arrayAuthors = arrayAuthors.filter((author) => author.id !== idPop);

            updateAuthorsBox();
          });
        });
      });
    });
  } catch (error) {
    console.log(error);
  }
}

function updateAuthorsBox() {
  if (arrayAuthors.length > 0) authorsBox.classList.add("show");
  else authorsBox.classList.remove("show");

  let authorsIds = [];
  authorsBox.innerHTML = "";
  arrayAuthors.forEach((author) => {
    authorsBox.innerHTML += `<div class="author"><span>${author.name}</span><i class="ph ph-x-circle popAuthor" data-id="${author.id}"></i></div>`;
    authorsIds.push(author.id);
  });

  authorsInput.value = authorsIds;

  const popAuthorBtns = document.querySelectorAll(".popAuthor");
  popAuthorBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      idPop = btn.dataset.id;
      arrayAuthors = arrayAuthors.filter((author) => author.id !== idPop);

      updateAuthorsBox();
    });
  });
}
