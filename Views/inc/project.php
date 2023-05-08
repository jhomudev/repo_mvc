<?php
require_once "Controllers/ProjectController.php";
$IP = new ProjectController();
$data = $IP->getInfoProjectController();

$project = $data['project'];
$authors = $data['authors'];

?>
<section class="flex container" container>
  <main class="projectBox">
    <h1 class="project__title"><?php echo $project['titulo'] ?></h1>
    <h3 class="projetc__desc__text enc">Descripción del proyecto</h3>
    <p class="project__descri"><?php echo $project['descripcion'] ?></p>
    <hr>
    <div class="project__tableBox">
      <table class="project__table">
        <tbody>
          <tr>
            <th class="table__th">Autores: </th>
            <td>
              <?php
              $tot_authors = count($authors);
              $i = 0;

              foreach ($authors as $author) {
                echo $author['nombres'] . ' ' . $author['apellidos'];
                if (++$i !== $tot_authors) {
                  echo ', ';
                }
              }
              ?>
            </td>
          </tr>
          <tr>
            <th class="table__th">Formato: </th>
            <td>Proyecto de <?php echo $project['tipo'] ?></td>
          </tr>
          <tr>
            <th class="table__th">Fecha de publicación: </th>
            <td><?php echo date("d-m-Y", strtotime($project['fecha_publicacion'])) ?></td>
          </tr>
          <tr>
            <th class="table__th">Escuela: </th>
            <td><?php echo $project['escuela'] ?></td>
          </tr>
          <tr>
            <th class="table__th">Carrera: </th>
            <td><?php echo $project['carrera'] ?></td>
          </tr>
          <tr>
            <th class="table__th">Enlace de recurso: </th>
            <td><a class="table__link" target="_blank" href="<?php echo SERVER_URL . '/uploads/' . $project['nombre_archivo'] ?>">Click aquí</a></td>
          </tr>
        </tbody>
      </table>
      <hr>
    </div>
  </main>
  <aside class="others">
    <h3 class="others__text enc">Otros proyectos</h3>
    <div class="othersBox">
      <?php
      $carrera_id = $project['carrera_id'];
      $proyecto_id = $project['proyecto_id'];
      $query = "SELECT p.proyecto_id,p.titulo,p.tipo,p.descripcion,e.nombre AS estado,e.descripcion AS es_descrip,e.color, MAX(dt.fecha_publicacion) AS fecha_publicacion, GROUP_CONCAT(a.nombres,' ',a.apellidos SEPARATOR ', ')  AS autores FROM proyectos p 
        INNER JOIN tramites t ON t.proyecto_id=p.proyecto_id 
        INNER JOIN usuarios a ON a.usuario_id=t.estudiante_id 
        INNER JOIN detalle_tramite dt ON dt.tramite_id=t.tramite_id 
        INNER JOIN estados e ON e.estado_id=dt.estado_id 
        WHERE a.carrera_id=$carrera_id AND p.proyecto_id<>'$proyecto_id' AND dt.estado_id=6
        GROUP BY p.proyecto_id,p.titulo,p.tipo,p.descripcion,e.nombre,e.descripcion,e.color";
      $others_projects = MainModel::executeQuerySimple($query);
      $others_projects = $others_projects->fetchAll();

      if (count($others_projects) > 0) {
        foreach ($others_projects as $key => $project) {
          echo '
            <article class="others__article">
              <a href="' . SERVER_URL . '/repository?id=' . $project['proyecto_id'] . '" class="other__title">' . $project['titulo'] . '</a>
              <p class="other__authors">por: ' . $project['autores'] . '</p>
              <b class="others__date">Publicado el ' . date("Y", strtotime($project['fecha_publicacion'])) . '</b>
            </article>    
            ';
        }
      } else {
        echo '
          <article class="others__article">
            <p class="other__authors">No hay proyectos relacionados</p>
          </article>    
        ';
      }
      ?>
    </div>
  </aside>
</section>