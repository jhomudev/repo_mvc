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
            <li><button class="filter__item" data-state="">Todos</button></li>
            <?php
            $sql = MainModel::connect()->prepare("SELECT estado_id,nombre FROM estados ORDER BY estado_id");
            $sql->execute();
            $states = $sql->fetchAll();
            foreach ($states as $state) {
              echo '
                  <li><button class="filter__item" data-state="' . $state["estado_id"] . '">' . $state["nombre"] . '</button></li>
                  ';
            }
            ?>
          </ul>
        </nav>
        <div id="projectsBox" class="projectsBox">
          <!-- peticion -->
        </div>
      </div>
    </div>
  </main>
</section>