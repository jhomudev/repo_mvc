// Toggle de etiqueta details del proyecto
const details = document.querySelectorAll(".details");
details.forEach((item) => {
  item.addEventListener("toggle", () => {
    const icon=item.children[0].children[1];
    if (item.open) {
      icon.classList.remove("open")
    } else {
      icon.classList.add("open")
    }
  });
});