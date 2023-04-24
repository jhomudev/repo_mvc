<?php

require_once "observationModel.php";

// Modelo trámite
class projectModel extends observationModel
{
  // Funcion general para los proyectos
  protected static function getProjectsModel(array $params):array
  {
    $user_type = $params['user_type'];
    $user_id = $params['user_id'];
    $user_sede = $params['user_sede'];
    $filter_state = $params['filter_state'];

    if ($user_type == 3) $query = "SELECT p.proyecto_id,p.titulo,p.tipo,p.descripcion,dt.estado_id FROM proyectos p INNER JOIN tramites t ON t.proyecto_id=p.proyecto_id INNER JOIN detalle_tramite dt ON dt.tramite_id=t.tramite_id WHERE t.estudiante_id=$user_id GROUP BY p.proyecto_id,p.titulo,p.tipo,p.descripcion,dt.estado_id";

    if ($user_type == 2) $query = "SELECT p.proyecto_id,p.titulo,p.tipo,p.descripcion,dt.estado_id FROM proyectos p INNER JOIN tramites t ON t.proyecto_id=p.proyecto_id INNER JOIN detalle_tramite dt ON dt.tramite_id=t.tramite_id WHERE dt.instructor_id=$user_id GROUP BY p.proyecto_id,p.titulo,p.tipo,p.descripcion,dt.estado_id";

    if ($user_type == 1) $query = "SELECT p.proyecto_id,p.titulo,p.tipo,p.descripcion,dt.estado_id FROM proyectos p INNER JOIN tramites t ON t.proyecto_id=p.proyecto_id INNER JOIN detalle_tramite dt ON dt.tramite_id=t.tramite_id INNER JOIN usuarios u ON u.sede_id=$user_sede GROUP BY p.proyecto_id,p.titulo,p.tipo,p.descripcion,dt.estado_id";

    if ($user_type == "all") $query = "SELECT p.proyecto_id,p.titulo,p.tipo,p.descripcion,dt.estado_id FROM proyectos p INNER JOIN tramites t ON t.proyecto_id=p.proyecto_id INNER JOIN detalle_tramite dt ON dt.tramite_id=t.tramite_id";

    $projects = mainModel::executeQuerySimple($query);

    return $projects->fetchAll();
  }

  // Funcion para obtener datos de un tramite u proyecto
  protected static function getInfoProjectModel($project_id): array
  {
    // obtencion de datos de proyecto
    $query_project = "SELECT p.proyecto_id, p.nombre_archivo, p.titulo, p.tipo, p.descripcion,t.fecha_gen, dt.estado_id, dt.nota, e.nombre AS estado 
    FROM proyectos p 
    INNER JOIN tramites t ON t.proyecto_id = p.proyecto_id 
    INNER JOIN detalle_tramite dt ON dt.tramite_id = t.tramite_id 
    INNER JOIN estados e ON e.estado_id = dt.estado_id 
    WHERE p.proyecto_id = '$project_id' 
    GROUP BY p.proyecto_id, p.titulo, p.tipo, p.descripcion, t.fecha_gen, dt.estado_id, dt.nota, e.nombre";
    $project = mainModel::executeQuerySimple($query_project)->fetch();

    // obtención de los datos de los autores
    $queryAuthors = "SELECT u.nombres,u.apellidos 
    FROM usuarios u 
    INNER JOIN tramites t ON u.usuario_id=t.estudiante_id 
    INNER JOIN proyectos p ON p.proyecto_id=t.proyecto_id WHERE p.proyecto_id='$project_id'";
    $authors = mainModel::executeQuerySimple($queryAuthors)->fetchAll();

    // obtención de las observaciones del proyecto
    $obs = observationModel::getObservationsModel($project_id);

    $data = [
      "authors" => $authors,
      "project" => $project,
      "observations" => $obs,
    ];

    return $data;
  }

  // Función generar tramite o proceso
  protected static function createProjectModel(string $project_id, string $title, int $type, string $description, string $filename): bool
  {
    $sql_project = mainModel::connect()->prepare("INSERT INTO 
    proyectos(proyecto_id,titulo,tipo,descripcion,nombre_archivo) 
    VALUES(:project_id,:title,:type,:description,:filename)");

    $sql_project->bindParam(":project_id", $project_id, PDO::PARAM_STR);
    $sql_project->bindParam(":title", $title, PDO::PARAM_STR);
    $sql_project->bindParam(":type", $type, PDO::PARAM_INT);
    $sql_project->bindParam(":description", $description, PDO::PARAM_STR);
    $sql_project->bindParam(":filename", $filename, PDO::PARAM_STR);

    return $sql_project->execute();
  }

  // Funcion  para editar proyecto
  protected static function editProjectModel(array $new_data): bool
  {
    $sql = mainModel::connect()->prepare("UPDATE proyectos SET titulo = :title, tipo = :type, descripcion  = :description, nombre_archivo = :filename WHERE proyecto_id = :project_id");
    $sql->bindParam(':title', $new_data['title'], PDO::PARAM_STR);
    $sql->bindParam(':type', $new_data['type'], PDO::PARAM_INT);
    $sql->bindParam(':description', $new_data['description'], PDO::PARAM_STR);
    $sql->bindParam(':filename', $new_data['filename'], PDO::PARAM_STR);
    $sql->bindParam(':project_id', $new_data['project_id'], PDO::PARAM_INT);

    return $sql->execute();
  }
}
