<?php
require_once "Controllers/ProjectController.php";

$PI = new ProjectController();

$data = $PI->getInfoProjectController();
$project = $data['project'];
$authors = $data['authors'];
$obs = $data['observations'];

?>
<header class="header">
  <a href="<?php echo SERVER_URL; ?>/login" class="header__btnBack"><i class="ph ph-arrow-left"></i></a>
  <h3 class="header__proyect">PROYECTO DE <?php echo $project['tipo']; ?></h3>
  <strong class="header__titleproyect"><?php echo $project['titulo'] ?></strong>
</header>
<main class="main">
  <div class="detailsResult">
    <div class="detailsResult__flex" style="--cl:<?php echo $project['color']; ?>;">
      <strong class="detailsResult__state"><i class="ph ph-file"></i> <?php echo $project['estado'] ?></strong>
      <p>Enviado <?php echo date('d-m-Y H:i', strtotime($project['fecha_gen'])) ?></p>
    </div>
    <i class="detailsResult__qualification"><?php echo isset($project['nota']) ? $project['nota'] : 'Sin calificar' ?></i>
  </div>
  <div class="proyect__allContent">
    <section class="proyect">
      <details open class="proyect__info details">
        <summary class="proyect__btnShowContent">
          <span class="proyect__subtitles">Detalles del proyecto</span>
          <i class="ph ph-caret-down"></i>
        </summary>
        <div class="proyect__content">
          <?php
          if ($_SESSION['tipo'] == USER_TYPE['student']) {
          ?>
            <div class="proyect__stateInfo" style="--cl:<?php echo $project['color']; ?>;">
              <p><?php echo $project['es_descrip'] ?></p>
            </div>
          <?php
          }
          ?>
          <h4 class="proyect__part">Descripción del proyecto</h4>
          <p class="proyect__description">
            <?php echo $project['descripcion'] ?>
          </p>
          <h4 class="proyect__part">Autores</h4>
          <ul class="proyect__authors">
            <?php
            foreach ($authors as $key => $author) {
              echo '<li class="proyect__author">' . $author['nombres'] . ' ' . $author['apellidos'] . '</li>';
            }
            ?>
          </ul>
        </div>
      </details>
      <details open class="proyect__file details">
        <summary class="proyect__btnShowContent">
          <span class="proyect__subtitles">Archivo del proyecto</span>
          <i class="ph ph-caret-down"></i>
        </summary>
        <div class="proyect__content">
          <iframe src="<?php echo SERVER_URL . '/uploads/' . $project['nombre_archivo'] ?>" frameborder="0"></iframe>
        </div>
      </details>
    </section>
    <aside class="observations">
      <span class="observations__subtitle"><i class="ph ph-eye"></i> Observaciones</span>
      <div class="observations__content">
        <b>Observaciones del proyecto</b>
        <div class="observations__box">
          <?php
          if (count($obs) > 0) {
            foreach ($obs as $key => $ob) {
          ?>
              <article class="observation">
                <div class="observation__flex">
                  <div class="observation__data">
                    <h3 class="observation__author"><?php echo $ob['nombres'] . ' ' . $ob['apellidos']; ?></h3>
                    <span class="observation__date"><?php echo date('d-m-Y H:i', strtotime($ob['fecha_gen'])); ?></span>
                  </div>
                  <?php
                  if ($_SESSION['usuario_id'] == $ob['autor_id']) {
                  ?>
                    <form action="<?php echo SERVER_URL; ?>/fetch/observationFetch.php" method="POST" class="observation__form formFetch">
                      <input type="hidden" name="observacion_id" value="<?php echo $ob['observacion_id']; ?>">
                      <button type="submit" title="Eliminar observación" class="observation__form__submit"><i class="ph ph-trash"></i></button>
                    </form>
                  <?php
                  }
                  ?>
                </div>
                <p class="observation__descri"><?php echo $ob['descripcion']; ?></p>
              </article>
          <?php
            }
          } else echo '<i>EL proyecto no tiene observaciones</i>';

          if ($_SESSION['tipo'] !== 3 && $project['estado_id'] < 4) {
            echo '
              <div class="newObs">
                <button class="newObs__btnNewObs">Nueva observación</button>
                <form action="' . SERVER_URL . '/fetch/observationFetch.php" method="POST" class="newObs__form formFetch">
                  <input type="hidden" name="project_id" value="' . $project['proyecto_id'] . '">
                  <textarea name="descryption" class="newObs__form__textarea" id="obs" placeholder="Detalle su observación aquí"></textarea>
                  <input type="submit" value="Enviar" class="newObs__form__submit">
                </form>
              </div>
              ';
          }
          ?>
        </div>
      </div>
    </aside>
  </div>
</main>