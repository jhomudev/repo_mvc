<section class="section__main">
  <main class="main container">
    <div class="top">
      <h1>Proyectos designados</h1>
      <a href="<?php echo SERVER_URL; ?>/repository">Ver proyectos publicados</a>
    </div>
    <hr />
    <div class="container__projects">
      <nav class="filter">
        <ul>
          <li><a class="filter__item" href="" data-state="">Todos</a></li>
          <li><a class="filter__item" href="" data-state="">Por revisar</a></li>
          <li><a class="filter__item" href="" data-state="">Observados</a></li>
          <li><a class="filter__item" href="" data-state="">Aprobados</a></li>
          <li><a class="filter__item" href="" data-state="">Desaprobados</a></li>
          <?php
          // $sql = mainModel::connect()->prepare("SELECT estado_id,nombre FROM estados");
          // $sql->execute();
          // $states = $sql->fetchAll();
          // foreach ($states as $state) {
          //   echo '
          //       <li><a class="filter__item" href="" data-state="' . $state["estado_id"] . '">' . $state["nombre"] . '</a></li>
          //       ';
          // }
          ?>
        </ul>
      </nav>
      <div id="projectsBox" class="projectsBox">
        <article class="project" style="--cl:black">
          <a href="<?php echo SERVER_URL; ?>/project" class="project__link"></a>
          <h1 class="project__title">SISTEMA DE REPOSITORIO</h1>
          <h2 class="project__type">PROYECTO DE MEJORA</h2>
          <p class="project__descri">Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi maiores quod corrupti dolores eligendi. Sequi, esse delectus? Dolores, mollitia unde. Architecto doloribus error voluptas tenetur, ullam qui placeat modi ipsum!
          </p>
          <span class="project__state">ENVIADO</span>
        </article>
        <article class="project" style="--cl:black">
          <a href="<?php echo SERVER_URL; ?>/project" class="project__link"></a>
          <h1 class="project__title">SISTEMA DE REPOSITORIO</h1>
          <h2 class="project__type">PROYECTO DE MEJORA</h2>
          <p class="project__descri">Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi maiores quod corrupti dolores eligendi. Sequi, esse delectus? Dolores, mollitia unde. Architecto doloribus error voluptas tenetur, ullam qui placeat modi ipsum!
          </p>
          <span class="project__state">ENVIADO</span>
        </article>
        <article class="project" style="--cl:black">
          <a href="<?php echo SERVER_URL; ?>/project" class="project__link"></a>
          <h1 class="project__title">SISTEMA DE REPOSITORIO</h1>
          <h2 class="project__type">PROYECTO DE MEJORA</h2>
          <p class="project__descri">Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi maiores quod corrupti dolores eligendi. Sequi, esse delectus? Dolores, mollitia unde. Architecto doloribus error voluptas tenetur, ullam qui placeat modi ipsum!
          </p>
          <span class="project__state">ENVIADO</span>
        </article>
        <article class="project" style="--cl:black">
          <a href="<?php echo SERVER_URL; ?>/project" class="project__link"></a>
          <h1 class="project__title">SISTEMA DE REPOSITORIO</h1>
          <h2 class="project__type">PROYECTO DE MEJORA</h2>
          <p class="project__descri">Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi maiores quod corrupti dolores eligendi. Sequi, esse delectus? Dolores, mollitia unde. Architecto doloribus error voluptas tenetur, ullam qui placeat modi ipsum!
          </p>
          <span class="project__state">ENVIADO</span>
        </article>
        <article class="project" style="--cl:black">
          <a href="<?php echo SERVER_URL; ?>/project" class="project__link"></a>
          <h1 class="project__title">SISTEMA DE REPOSITORIO</h1>
          <h2 class="project__type">PROYECTO DE MEJORA</h2>
          <p class="project__descri">Lt o erendis facere fugit deleniti nobis excepturi doloribus rem et, incidunt ipsa dicta accusamus quaerat, nisi exercitationem! Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi maiores quod corrupti dolores eligendi. Sequi, esse delectus? Dolores, mollitia unde. Architecto doloribus error voluptas tenetur, ullam qui placeat modi ipsum!
          </p>
          <span class="project__state">ENVIADO</span>
        </article>
        <article class="project" style="--cl:black">
          <a href="<?php echo SERVER_URL; ?>/project" class="project__link"></a>
          <h1 class="project__title">SISTEMA DE REPOSITORIO</h1>
          <h2 class="project__type">PROYECTO DE MEJORA</h2>
          <p class="project__descri">Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi maiores quod corrupti dolores eligendi. Sequi, esse delectus? Dolores, mollitia unde. Architecto doloribus error voluptas tenetur, ullam qui placeat modi ipsum!
          </p>
          <span class="project__state">ENVIADO</span>
        </article>
        <article class="project" style="--cl:black">
          <a href="<?php echo SERVER_URL; ?>/project" class="project__link"></a>
          <h1 class="project__title">SISTEMA DE REPOSITORIO</h1>
          <h2 class="project__type">PROYECTO DE MEJORA</h2>
          <p class="project__descri">ingaiores quod corrupti dolores eligendi. Sequi, esse delectus? Dolores, mollitia unde. Architecto doloribus error voluptas tenetur, ullam qui placeat modi ipsum!
          </p>
          <span class="project__state">ENVIADO</span>
        </article>
      </div>
    </div>
  </main>
</section>
<!-- <script src="<?php echo SERVER_URL; ?>/Views/js/alerts.js"></script> -->