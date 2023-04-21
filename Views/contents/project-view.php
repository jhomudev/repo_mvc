<?php
require_once "Controllers/processController.php";

$PI = new ProcessController();

$data = $PI->getInfoProcessingController();
$project = $data['project'];
$authors = $data['authors'];
$obs = $data['observations'];

// print_r($obs);
?>
<header class="header">
  <a href="<?php echo SERVER_URL; ?>/login" class="header__btnBack"><i class="ph ph-arrow-left"></i></a>
  <h3 class="header__proyect">PROYECTO DE
    <?php echo ($project['tipo'] == 1) ? 'INNOVACIÓN' : (($project['tipo'] == 2) ? 'MEJORA' : (($project['tipo'] == 3) ? 'CREATIVIDAD' : ''));
    ?></h3>
  <strong class="header__titleproyect"><?php echo $project['titulo'] ?></strong>
</header>
<main class="main">
  <div class="detailsResult">
    <div class="detailsResult__flex" style="--cl:<?php echo $project['clr']; ?>;">
      <strong class="detailsResult__state"><i class="ph ph-file"></i> <?php echo $project['estado'] ?></strong>
      <p>Enviado <?php echo $project['fecha_gen'] ?></p>
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
              echo '
                <article class="observation">
                  <div class="observation__flex">
                    <h3 class="observation__author">' . $ob['nombres'] . ' ' . $ob['apellidos'] . '</h3>
                    <span class="observation__date">' . $ob['fecha_gen'] . '</span>
                  </div>
                  <p class="observation__descri">' . $ob['descripcion'] . '</p>
                </article>
                ';
            }
          } else echo '<i>EL proyecto no tiene observaciones</i>';

          if ($_SESSION['tipo'] !== 3) {
            echo '
              <div class="newObs">
                <button class="newObs__btnNewObs">Nueva observación</button>
                <form action="" class="newObs__form">
                  <textarea name="tx_newObs" class="newObs__form__textarea" id="obs" placeholder="Detalle su observación aquí"></textarea>
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