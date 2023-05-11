<section class="section__main">
  <main class="main container">
    <div class="top">
      <h1>Proyectos</h1>
      <a target="_blank" href="<?php echo SERVER_URL; ?>/repository">Ver proyectos publicados</a>
    </div>
    <hr />
    <div class="flex">
      <div class="careers">
        <h1 class="careers__title">Carreras</h1>
        <hr>
        <nav class="careers__nav">
          <ul>
            <?php
            $sql = MainModel::connect()->prepare("SELECT carrera_id,nombre FROM carreras ORDER BY escuela_id");
            $sql->execute();
            $states = $sql->fetchAll();
            foreach ($states as $state) {
              echo '
                  <li><a class="careers__nav__item" href="" data-career="' . $state["carrera_id"] . '">' . $state["nombre"] . '</a></li>
                  ';
            }
            ?>
          </ul>
        </nav>
      </div>
      <div class="container__projects">
        <nav class="filter">
          <ul>
            <li><button class="filter__item selected" data-state="">Todos</button></li>
            <li><button class="filter__item" data-state="1">Enviados</button></li>
            <li><button class="filter__item" data-state="2">Asignados</button></li>
            <li><button class="filter__item" data-state="obs">Observados</button></li>
            <li><button class="filter__item" data-state="3">Pasados</button></li>
            <li><button class="filter__item" data-state="4">En sustentación</button></li>
            <li><button class="filter__item" data-state="5">Calificados</button></li>
            <li><button class="filter__item" data-state="6">Publicados</button></li>
          </ul>
        </nav>
        <div id="projectsBox" class="projectsBox">
          <!-- peticion -->
        </div>
      </div>
    </div>
  </main>
</section>