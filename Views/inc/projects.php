<?php
require_once "Controllers/ProjectController.php";
$IP = new ProjectController();
if (isset($_POST['words'])) $projects = $IP->getProjectsController();
else {
  $_POST['filter'] = "all";
  $projects = $IP->getProjectsController();
}

?>
<section class="flex container">
  <aside class="filter">
    <div class="filter__group">
      <button class="filter__btnShow show">Carreras<i class="ph ph-caret-down arrow"></i></button>
      <nav class="filter__nav">
        <ul>
          <li><a class="nav__item" href="">Ing de software con Inteligencia artificial<span class="nav__item__count">123</span></a></li>
          <li><a class="nav__item" href="">Ing de software con IA <span class="nav__item__count">123</span></a></li>
          <li><a class="nav__item" href="">Ing de software con Inteligencia artificial<span class="nav__item__count">123</span></a></li>
          <li><a class="nav__item" href="">Ing de software con IA <span class="nav__item__count">123</span></a></li>
          <li><a class="nav__item" href="">Ing de software con IA <span class="nav__item__count">123</span></a></li>
        </ul>
      </nav>
    </div>
    <div class="filter__group">
      <button class="filter__btnShow show">Zonales<i class="ph ph-caret-down arrow"></i></button>
      <nav class="filter__nav">
        <ul>
          <li><a class="nav__item" href="">Ica - Ayacucho <span class="nav__item__count">123</span></a></li>
          <li><a class="nav__item" href="">Ica - Ayacucho <span class="nav__item__count">123</span></a></li>
          <li><a class="nav__item" href="">Ica - Ayacucho <span class="nav__item__count">123</span></a></li>
          <li><a class="nav__item" href="">Ica - Ayacucho <span class="nav__item__count">123</span></a></li>
          <li><a class="nav__item" href="">Ica - Ayacucho <span class="nav__item__count">123</span></a></li>
        </ul>
      </nav>
    </div>
  </aside>
  <main class="results">
    <h3 class="results__title">Resultados</h3>
    <hr>
    <div class="results__message">
      <p>Mostrando
        <?php echo count($projects) . ' resultados';
        echo (isset($_POST['words'])) ? ' relacionados a "' . $_POST['words'] . '"' : '.';
        ?>
      </p>
    </div>
    <div class="projects">
      <?php
      foreach ($projects as $key => $project) {
        echo '
          <article class="project">
            <div class="project__details">
              <h4 class="projetc__type">Proyecto de ' . $project['tipo'] . '</h4>
              <a href="' . SERVER_URL . '/repository?id=' . $project['proyecto_id'] . '" class="project__title">' . $project['titulo'] . '</a>
              <p class="project__authors">Publicado por <br><b>' . $project['autores'] . '</b></p>
              <span class="project__date">Publicado el ' . date("Y", strtotime($project['fecha_publicacion'])) . '</span>
            </div>
            <div class="project__description">
              <p>' . $project['descripcion'] . '</p>
            </div>
          </article>
          ';
      }
      ?>
    </div>
  </main>
</section>