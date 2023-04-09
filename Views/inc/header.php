<div class="headerMainBox">
  <header class="headerMain container">
    <a href="./" class="headerMain__logo">
      <img class="headerMain__imgLogo" src="<?php echo SERVER_URL; ?>/Views/assets/logo.png" alt="logo" />
    </a>
    <nav class="nav">
      <i id="iconUser" class="ph-user-circle"></i>
      <div id="userBar" class="nav__bar">
        <span class="nav__username"><?php echo $_SESSION['nombres'] . " " . $_SESSION['apellidos'] ?></span>
        <ul class="nav__ul">
          <li class="nav__item">
            <a class="nav__link" href=""><i class="ph-student"></i>Proyectos de mi carrera</a>
          </li>
          <li class="nav__item">
            <a class="nav__link" href=""><i class="ph-books"></i>Todos los proyectos</a>
          </li>
          <li class="nav__item">
            <a class="nav__link" id="btnLogout"><i class="ph-sign-out"></i> Cerrar Sesión</a>
          </li>
        </ul>
      </div>
      <div class="nav__res__bar">
        <button class="nav__res__iconClose"><i class="ph ph-x"></i></button>
        <div class="nav__res__bar__logo">
          <img class="nav__res__bar__imgLogo" src="<?php echo SERVER_URL; ?>/Views/assets/iconLogo.png" alt="logo" />
        </div>
        <span class="nav__res__username"><?php echo $_SESSION['nombres'] . " " . $_SESSION['apellidos'] ?></span>
        <ul class="nav__res__ul">
          <li class="nav__res__item">
            <a class="nav__res__link" href="">Proyectos de mi carrera</a>
          </li>
          <li class="nav__res__item">
            <a class="nav__res__link" href="<?php echo SERVER_URL; ?>/repository">Ir al repositorio</a>
          </li>
          <li class="nav__res__item">
            <a class="nav__res__link" id="btnLogout">Cerrar Sesión</a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
</div>