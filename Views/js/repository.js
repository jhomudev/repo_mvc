const buttons = document.querySelectorAll(".filter__btnShow");

buttons.forEach((button) => {
  button.addEventListener("click", () => {
    button.classList.toggle("show");
  });
});
