<style>
  .headerMainBox {
    width: 100%;
    height: 85px;
    background: var(--c_slate);
    display: flex;
  }

  .headerMain {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .headerMain__logo {
    width: 20em;
  }

  .headerMain__imgLogo {
    width: 100%;
    height: 100%;
    object-fit: contain;
  }

  .nav {
    position: relative;
    display: grid;
    place-items: center;
  }

  .nav i {
    font-size: xx-large;
  }

  .nav__bar {
    position: absolute;
    z-index: 100;
    top: 100%;
    right: 10%;
    width: 15em;
    padding: 10px 0 0 0;
    background-color: var(--c_darkBlue);
    border-radius: 5px;
    pointer-events: none;
    opacity: 0;
    transition: opacity 0.3s;
  }

  .nav__bar.show {
    pointer-events: all;
    opacity: 1;
  }

  .nav__username {
    display: block;
    text-align: center;
    text-transform: uppercase;
    color: white;
    font-size: small;
    font-weight: bold;
    margin: 0 10px;
  }

  .nav__ul {
    width: 100%;
    height: auto;
    list-style: none;
    margin-top: 5px;
  }

  .nav__item {
    width: 100%;
    background: inherit;
  }

  .nav__item:hover {
    backdrop-filter: brightness(110%);
  }

  .nav__link {
    color: white;
    display: flex;
    align-items: center;
    gap: 5px;
    text-decoration: none;
    font-size: 14px;
    padding: 8px 10px;
    cursor: pointer;
  }

  .nav__link i {
    font-size: medium;
  }
</style>
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
    </nav>
  </header>
</div>