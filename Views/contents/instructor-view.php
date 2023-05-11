<section class="section__main">
  <main class="main container">
    <div class="top">
      <h1>Proyectos designados</h1>
      <a target="_blank" href="<?php echo SERVER_URL; ?>/repository">Ver proyectos publicados</a>
    </div>
    <hr />
    <div class="container__projects">
      <nav class="filter">
        <ul>
          <li><button class="filter__item selected" data-state="">Todos</button></li>
          <li><button class="filter__item" data-state="2">Por revisar</button></li>
          <li><button class="filter__item" data-state="obs">Observados</button></li>
          <li><button class="filter__item" data-state="3">Derivados</button></li>
          <li><button class="filter__item" data-state="6">Publicados</button></li>
        </ul>
      </nav>
      <div id="projectsBox" class="projectsBox">
        <!-- peticion -->
      </div>
    </div>
  </main>
</section>