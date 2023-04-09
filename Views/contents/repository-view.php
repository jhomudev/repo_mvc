<div class="container__all">
  <div class="headerBox">
    <header class="header container">
      <div class="header__logo"><img src="http://localhost/repo_mvc/Views/assets/logo.png" alt="" class="header__imgLogo"></div>
      <a class="header__btnRedirect" href="<?php echo SERVER_URL; ?>/login">¿Eres estudiante?</a>
    </header>
  </div>
  <div class="presentation">
    <p class="pres__text">Repositorio institucional <span>SENATI</span></p>
    <p class="pres__paragraph">Esta página muestra información perteneciente a SENATI. Presentamos los diversos proyectos realizados por los egresados de nuestra institución con la finalidad de poner dicho contenido a disposición de la población en general e interesados y sirva de fuente o referencia.
    </p>
    <form method="POST" class="browser">
      <div class="browser__inputBox">
        <input type="text" class="browser__input" name="tx_words" placeholder="Escriba el término a buscar" required>
        <i class="ph ph-magnifying-glass"></i>
      </div>
      <input type="submit" value="Buscar" class="browser__submit">
    </form>
  </div>
  <?php 
    if(isset($_POST['project_id'])) include_once "./views/inc/project.php";
    else{
      if(isset($_POST['tx_words'])){
        include_once "./views/inc/projects.php";/* Corregir despues */
      }
      else include_once "./views/inc/projects.php";
    }
  ?>
  <!-- aqui -->
</div>
<script src="<?php echo SERVER_URL; ?>/Views/js/repository.js"></script>
