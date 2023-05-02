<div class="container__all">
  <div class="headerBox container">
    <header class="header">
      <a href="<?php echo SERVER_URL; ?>/repository" class="header__logo"><img src="http://localhost/repo_mvc/Views/assets/logo.png" alt="logo uploadSen" class="header__imgLogo"></a>
      <a class="header__btnRedirect" href="<?php echo SERVER_URL; ?>/login">¿Eres estudiante?</a>
    </header>
  </div>
  <div class="presentation">
    <p class="pres__text">Repositorio institucional <span>SENATI</span></p>
    <p class="pres__paragraph">Esta página muestra información perteneciente a SENATI. Presentamos los diversos proyectos realizados por los egresados de nuestra institución con la finalidad de poner dicho contenido a disposición de la población en general e interesados y sirva de fuente o referencia.
    </p>
    <form method="POST" action="<?php echo SERVER_URL; ?>/repository" class="browser">
      <div class="browser__inputBox">
        <input type="search" class="browser__input" name="words" list="all_projects" placeholder="Escriba el término a buscar" required>
        <i class="ph ph-magnifying-glass"></i>
        <datalist id="all_projects">
          <?php
          require_once "Controllers/ProjectController.php";
          $IP = new ProjectController();

          $projects = $IP->getProjectsController();

          foreach ($projects as $key => $project) {
            echo '<option value="' . $project['titulo'] . '">';
          }
          ?>
        </datalist>
      </div>
      <input type="submit" value="Buscar" class="browser__submit">
    </form>
  </div>
  <?php
  // $projetc_id=$_GET['id']; no funciona el GET xq nosotros asi lo definimos, analizar bien
  $url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
  // Descomponemos la URL
  $comps_url = parse_url($url);
  // verificamos si se pasan parametros a la URl
  if (isset($comps_url['query'])) {
    // Obtenemos los valores de los parámetros
    parse_str($comps_url['query'], $params);
    $project_id = $params['id'];
  }

  if (isset($project_id)) include_once "./views/inc/project.php";
  else include_once "./views/inc/projects.php";

  ?>
</div>