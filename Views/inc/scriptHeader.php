<script>
  // togle de barra de usuario opciones
  const userBar = document.querySelector(".nav__bar");
  const userBarRes = document.querySelector(".nav__res__bar");
  const iconUser = document.getElementById("iconUser");
  const btnCloseUserBar = document.querySelector(".nav__res__iconClose");

  iconUser.addEventListener("click", (e) => {
    toggleShowElement(userBar);
    toggleShowElement(userBarRes);
  });
  btnCloseUserBar.addEventListener("click", (e) => {
    toggleShowElement(userBar);
    toggleShowElement(userBarRes);
  });

  const buttonslogout = document.querySelectorAll('.btnLogout');

  buttonslogout.forEach(button => {
    button.addEventListener('click', () => {
      Swal.fire({
        title: "Estas seguro de abandonar la sesión?",
        text: "La sesión se cerrará y saldrá del sistema",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
      }).then(async (result) => {
        try {
          if (result.isConfirmed) {
            const req = await fetch("<?php echo SERVER_URL ?>/fetch/loginFetch.php", {
              method: "POST",
              body: new URLSearchParams(`token=<?php echo $lc->encryption($_SESSION['token']); ?>`)
            });
            const res = await req.json();
            alertFetch(res);
          }
        } catch (error) {
          console.log(error);
        }
      });
    })
  });
</script>