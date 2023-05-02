<?php
require_once "Controllers/ProjectController.php";

$PI = new ProjectController();

$data = $PI->getInfoProjectController();
$project = $data['project'];
$authors = $data['authors'];
$obs = $data['observations'];

echo '
  <script>
    console.log(' . json_encode($project) . ')
  </script>
';
// validación de que el proyecto este asignado al instructor
if ($_SESSION['tipo'] == USER_TYPE['instructor'] && $project['instructor_id'] !== $_SESSION['usuario_id']) {
  echo 'Acceso denegado. Usted no tiene acceso a este proyecto, porque no está designado a él.';
  exit();
}
// validación de que el proyecto pertenece al aestudiante  de la sesión
else if ($_SESSION['tipo'] == USER_TYPE['student']) {
  $access = false;
  foreach ($authors as $key => $author) {
    if ($_SESSION['usuario_id'] == $author['usuario_id']) {
      $access = true;
    }
  }
  if (!$access) {
    echo 'Acceso denegado. Usted no tiene acceso a este proyecto, solo tiene acceso a sus proyectos.';
    exit();
  }
}

?>
<header class="header">
  <a href="<?php echo SERVER_URL; ?>/login" class="header__btnBack"><i class="ph ph-arrow-left"></i></a>
  <h3 class="header__proyect">PROYECTO DE <?php echo $project['tipo']; ?></h3>
  <strong class="header__titleproyect"><?php echo $project['titulo'] ?></strong>
</header>
<main class="main">
  <?php
  if ($_SESSION['tipo'] == USER_TYPE['admin']) {
  ?>
    <button class="da__btn toggle__da">Detalles de gestión</button>
    <aside class="da__box">
      <div class="da">
        <button class="da__btnclose toggle__da"><i class="ph ph-arrow-right"></i></button>
        <form action="<?php echo SERVER_URL; ?>/fetch/asignInsFetch.php" method="POST" class="da__form formFetch">
          <div class="da__form__group">
            <label for="instructor__name" class="da__form__label">Asesor de proyecto</label>
            <input type="hidden" name="project_id" class="da__form__input" value="<?php echo $project['proyecto_id']; ?>" <?php echo ($project['estado_id'] > 2) ? 'disabled' : ''; ?>>
            <input id="instructor__name" type="text" name="instructor_id" class="da__form__input" list="list__instructors" value="<?php echo (isset($project['instructor_id']) ? $project['instructor_id'] : ''); ?>" placeholder="Escriba el id o nombre del instructor" <?php echo ($project['estado_id'] > 2) ? 'disabled' : ''; ?>>
            <?php if ($project['estado_id'] > 2) echo '<div class="da__form__ins"><p>' . $project['instructor'] . '</p></div>'; ?>
            <datalist id="list__instructors">
              <?php
              $ins = MainModel::executeQuerySimple("SELECT * FROM usuarios WHERE tipo=" . USER_TYPE['instructor'] . " AND sede_id=" . $authors[0]['sede_id'] . " AND carrera_id=" . $authors[0]['carrera_id'] . "");
              $ins = $ins->fetchAll();
              foreach ($ins as $key => $in) {
                echo '<option value="' . $in['usuario_id'] . '" label="' . $in['nombres'] . ' ' . $in['apellidos'] . '">' . $in['nombres'] . ' ' . $in['apellidos'] . '</option>';
              }
              ?>
            </datalist>
          </div>
          <?php
          if ($project['estado_id'] <= 2) echo '<input type="submit" value="Delegar asesor" class="da__form__submit">';
          ?>
        </form>
        <br>
        <div class="da__form__group">
          <label for="instructor__name" class="da__form__label">Calificaciones</label>
          <?php
          if ($project['estado_id'] < 4) {
            echo '<div class="da__form__ins"><p>No puede asignar las notas aún</p></div>';
          } else if ($project['estado_id'] >= 4) {
          ?>
            <table class="da__table">
              <tbody>
                <?php
                foreach ($authors as $key => $author) {
                  echo '
                      <tr>
                        <form method="POST" action="' . SERVER_URL . '/fetch/asignGradeFetch.php" class="form__calif formFetch">
                          <th>' . $author['nombres'] . ' ' . $author['apellidos'] . '</th>
                          <input type="hidden" name="detalle_id" value="' . $author['detalle_id'] . '" required>
                          <td><input type="number" name="nota" class="form__calif__input" max="20" min="0" placeholder="--" value="' . (isset($author['nota']) ? $author['nota'] : '') . '" number></td>
                          <td><button type="submit" title="Calificar" class="form__calif__submit"><i class="ph ph-check"></i></button></td>
                        </form>
                      </tr>
                      ';
                }
                ?>
              </tbody>
            </table>
          <?php
          }
          ?>
        </div>
      </div>
    </aside>
  <?php
  }
  ?>
  <div class="detailsResult">
    <div class="detailsResult__flex" style="--cl:<?php echo $project['color']; ?>;">
      <strong class="detailsResult__state"><i class="ph ph-file"></i> <?php echo $project['estado'] ?></strong>
      <p>Enviado <?php echo date('d-m-Y H:i', strtotime($project['fecha_gen'])) ?></p>
    </div>
    <?php
    if ($_SESSION['tipo'] == USER_TYPE['student']) {
      $nota = (isset($project['nota'])) ? $project['nota'] . " / 20" : "Sin calificar";
      echo '
        <i class="detailsResult__qualification">' . $nota . '</i>
        ';
    }
    ?>
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
            echo '
            <div class="proyect__stateInfo" style="--cl:' . $project['color'] . ';">
              <p>' . $project['es_descrip'] . '</p>
            </div>
            ';
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
              echo '<li class="proyect__author">' . $author['nombres'] . ' ' . $author['apellidos'] . '';
              if ($author['usuario_id'] == $project['estudiante_generador']) echo '  (generador).';
              echo '</li>';
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
          <a href="<?php echo SERVER_URL . '/uploads/' . $project['nombre_archivo'] ?>" class="proyect__download" download>Descargar archivo</a>
          <iframe class="proyect__iframe" src="<?php echo SERVER_URL . '/uploads/' . $project['nombre_archivo'] ?>" frameborder="0"></iframe>
        </div>
      </details>
    </section>
    <aside class="observationsBox">
      <div class="observations">
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

            if (($_SESSION['tipo'] == USER_TYPE['admin'] && $project['estado_id'] < 4) || $_SESSION['tipo'] == USER_TYPE['instructor'] && $project['estado_id'] < 3) {
              echo '
                <div class="newObs">
                  <button class="newObs__btnNewObs">Nueva observación</button>
                  <form action="' . SERVER_URL . '/fetch/observationFetch.php" method="POST" class="newObs__form formFetch">
                    <input type="hidden" name="project_id" value="' . $project['proyecto_id'] . '">
                    <textarea name="descryption" class="newObs__form__textarea" id="obs" placeholder="Detalle su observación aquí" required></textarea>
                    <input type="submit" value="Enviar" class="newObs__form__submit">
                  </form>
                </div>
                ';
            }
            ?>
          </div>
        </div>
      </div>
    </aside>
  </div>
</main>
<?php
if (($_SESSION['tipo'] == USER_TYPE['student'] && $project['estado_id'] <= 3) || ($_SESSION['tipo'] == USER_TYPE['instructor'] && $project['estado_id'] == 2)) {
?>
  <div class="bottomBox">
    <?php
    if ($_SESSION['tipo'] == USER_TYPE['student']) {
    ?>
      <form action="<?php echo SERVER_URL; ?>/fetch/processFetch.php" method="POST" class="form__edit formFetch">
        <div class="form__edit__btnclose toggle__formEdit"><i class="ph ph-caret-down"></i></div>
        <input type="hidden" name="tx_project_id" value="<?php echo $project['proyecto_id'] ?>">
        <div class="form__edit__group">
          <label for="titulo" class="form__edit__label">Título</label>
          <input type="text" id="titulo" name="tx_title" class="form__edit__input" value="<?php echo $project['titulo'] ?>" mayus>
        </div>
        <div class="form__edit__group">
          <label for="tipo" class="form__edit__label">Tipo</label>
          <select name="tx_type" id="tipo" class="form__edit__input" required="">
            <option value="" selected="" disabled="">Seleccione el tipo</option>
            <option value="1">Proyecto de innovación</option>
            <option value="2">Proyecto de mejora</option>
            <option value="3">Proyecto de creatividad</option>
          </select>
        </div>
        <div class="form__edit__group descri">
          <label for="descripcion" class="form__edit__label">Descripción</label>
          <textarea name="tx_descri" class="form__edit__input textarea" id="descripcion" placeholder="Escriba la descripción de su proyecto"><?php echo $project['descripcion'] ?></textarea>
        </div>
        <div class="form__edit__fileBox">
          <label for="file" class="form__edit__label__file">Subir proyecto</label>
          <input type="file" name="file" id="file" class="form__edit__file">
        </div>
        <input type="submit" value="Actualizar" class="form__submit">
      </form>
    <?php
    }
    ?>
    <div class="actions">
      <?php
      if ($_SESSION['tipo'] == USER_TYPE['student']) {
      ?>
        <button class="actions__btn toggle__formEdit">Editar proyecto</button>
        <form action="<?php echo SERVER_URL; ?>/fetch/cancelProcessFetch.php" method="POST" class="actions__form formFetch">
          <input type="hidden" name="proyecto_id" value="<?php echo $project['proyecto_id'] ?>">
          <button class="actions__btn">Cancelar trámite</button>
        </form>
      <?php
      } else {
      ?>
        <form action="<?php echo SERVER_URL; ?>/fetch/passProcessFetch.php" method="POST" class="actions__form formFetch">
          <input type="hidden" name="proyecto_id" value="<?php echo $project['proyecto_id'] ?>">
          <button class="actions__btn">Aprobar y pasar</button>
        </form>
      <?php
      }
      ?>
    </div>
  </div>
<?php
}
?>