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
  form.addEventListener("submit", (e) => sendFormFetch(e));
});

// Funcionalidad aside de detales de gestión
const daToggleBtns = document.querySelectorAll(".toggle__da");
const daBox = document.querySelector(".da__box");

daToggleBtns.forEach((btn) => {
  btn.addEventListener("click", () => toggleShowElement(daBox));
});

// toggle de formEdit
const formEdit = document.querySelector(".form__edit");
const toggleFormEdit = document.querySelectorAll(".toggle__formEdit");

toggleFormEdit.forEach((btn) => {
  btn.addEventListener("click", () => toggleShowElement(formEdit));
});

// funcion show list instructores/juries
const juriesBox = document.querySelector(".da__form__juriesBox");
const juriesList = document.querySelector(".list__ins");
const inputShow = document.querySelector(".inputShow");
const juriesInput = document.getElementsByName("jurados")[0];
let arrayIns = [];

if (inputShow) {
  inputShow.addEventListener("input", () => {
    getIns(inputShow.value);
    if (inputShow.value !== "") juriesList.classList.add("show");
    else juriesList.classList.remove("show");
  });
}

async function getIns(nameOrId) {
  try {
    const req = await fetch(`${serverURL}/fetch/getInsFetch.php`, {
      method: "POST",
      body: new URLSearchParams(`words=${nameOrId}`),
    });
    const res = await req.json();
    juriesList.innerHTML = "";

    res.forEach((instructor) => {
      juriesList.innerHTML += `<li class="list__ins__item" data-id="${instructor.id}" data-name="${instructor.fullname}"><h1>${instructor.fullname}</h1><p>${instructor.correo}</p></li>`;
    });

    const itemsList = document.querySelectorAll(".list__ins__item");
    itemsList.forEach((item) => {
      item.addEventListener("click", () => {
        const id = item.dataset.id;
        const name = item.dataset.name;
        inputShow.focus();

        arrayIns.push({ id, name });
        arrayIns = arrayIns.filter(
          (obj, index, self) => index === self.findIndex((o) => o.id === obj.id)
        );

        updateJuriesBox();

        const popInBtns = document.querySelectorAll(".popIn");
        popInBtns.forEach((btn) => {
          btn.addEventListener("click", () => {
            idPop = btn.dataset.id;
            arrayIns = arrayIns.filter((author) => author.id !== idPop);

            updateJuriesBox();
          });
        });
      });
    });
  } catch (error) {
    console.log(error);
  }
}

function updateJuriesBox() {
  if (arrayIns.length > 0) juriesBox.classList.add("show");
  else juriesBox.classList.remove("show");

  let insIds = [];
  juriesBox.innerHTML = "";
  arrayIns.forEach((instructor) => {
    juriesBox.innerHTML += `<div class="instructor"><span>${instructor.name}</span><i class="ph ph-x-circle popIn" data-id="${instructor.id}"></i></div>`;
    insIds.push(instructor.id);
  });

  juriesInput.value = insIds;

  const popInBtns = document.querySelectorAll(".popIn");
  popInBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      idPop = btn.dataset.id;
      arrayIns = arrayIns.filter((jury) => jury.id !== idPop);

      updateJuriesBox();
    });
  });
}
