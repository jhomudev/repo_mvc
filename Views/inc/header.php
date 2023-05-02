<div class="headerMainBox container">
  <header class="headerMain">
    <a href="./" class="headerMain__logo">
      <img class="headerMain__imgLogo" src="<?php echo SERVER_URL; ?>/Views/assets/logo.png" alt="logo" />
    </a>
    <nav class="nav">
      <i id="iconUser" class="ph-user-circle"></i>
      <div id="userBar" class="nav__bar">
        <span class="nav__username"><?php echo $_SESSION['nombres'] . " " . $_SESSION['apellidos'] ?></span>
        <ul class="nav__ul">
          <li class="nav__item">
            <a class="nav__link" target="_blank" href="<?php echo SERVER_URL; ?>/repository"><i class="ph-books"></i>Repositorio institucional</a>
          </li>
          <li class="nav__item">
            <a class="nav__link btnLogout"><i class="ph-sign-out"></i> Cerrar Sesión</a>
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
            <a class="nav__res__link" target="_blank" href="<?php echo SERVER_URL; ?>/repository">Repositorio institucional</a>
          </li>
          <li class="nav__res__item">
            <a class="nav__res__link btnLogout">Cerrar Sesión</a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
</div>