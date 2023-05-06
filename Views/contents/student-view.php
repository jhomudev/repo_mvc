<section class="section__main">
  <main class="main container">
    <div class="top">
      <h1>Mis trámites</h1>
      <a target="_blank" href="<?php echo SERVER_URL; ?>/repository">Ver proyectos publicados</a>
    </div>
    <hr />
    <div id="projectsBox" class="projectsBox">
      <article class="project project__upload toggle__form">
        <i class="ph-upload-simple"></i>
        <span>Subir proyecto</span>
      </article>
    </div>
  </main>
</section>
<div class="formBackground">
  <form action="<?php echo SERVER_URL; ?>/fetch/processFetch.php" method="POST" id="formUpload" class="form formFetch">
    <div id="closeForm" class="form__close toggle__form">
      <i class="ph-x"></i>
    </div>
    <h1 class="form__title">Subir proyecto</h1>
    <fieldset class="form__group">
      <legend>Título</legend>
      <input type="text" class="form__input" name="tx_title" placeholder="Escriba el título del proyecto" mayus required />
    </fieldset>
    <fieldset class="form__group">
      <legend>Tipo</legend>
      <select name="tx_type" class="form__input" required>
        <option value="" selected disabled>Seleccione el tipo</option>
        <option value="1">Proyecto de innovación</option>
        <option value="2">Proyecto de mejora</option>
        <option value="3">Proyecto de creatividad</option>
      </select>
    </fieldset>
    <fieldset class="form__group">
      <legend>Autores</legend>
      <input type="hidden" name="tx_authors" />
      <input type="text" class="form__input inputShow" placeholder="Escriba el nombre de los autores" />
      <div class="form__authorsBox">
        <!-- autores -->
      </div>
      <ul class="list__users">
        <!-- peticion -->
      </ul>
    </fieldset>
    <fieldset class="form__group">
      <legend>Descripción</legend>
      <textarea class="form__input" name="tx_descri" placeholder="Escriba una descrición general del proyecto" required></textarea>
    </fieldset>
    <div class="form__fileBox">
      <label for="file" class="fileBox__labelBtn">Subir archivo</label>
      <input type="file" name="file" id="file" class="inputFile" accept=".pdf" />
    </div>
    <button type="submit" value="Subir" class="form__submit">
      Subir
    </button>
  </form>
</div>