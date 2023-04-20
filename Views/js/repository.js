const buttons = document.querySelectorAll(".filter__btnShow");

buttons.forEach((button) => {
  button.addEventListener("click", () => toggleShowElement(button));
});
