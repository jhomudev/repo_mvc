<?php

require_once "ObservationModel.php";

// Modelo trámite
class ProjectModel extends ObservationModel
{
  // Funcion general para los proyectos
  protected static function getProjectsModel(array $params): array
  {
    $user_type = $params['user_type'];
    $user_id = $params['user_id'];
    $user_sede = $params['user_sede'];
    $filter_state = $params['filter_state'];
    if (empty($filter_state)) {
      if ($user_type == 3) $query = "SELECT p.proyecto_id,p.titulo,p.tipo,p.descripcion,e.nombre AS estado,e.descripcion AS es_descrip,e.color FROM proyectos p INNER JOIN tramites t ON t.proyecto_id=p.proyecto_id INNER JOIN detalle_tramite dt ON dt.tramite_id=t.tramite_id INNER JOIN estados e ON e.estado_id=dt.estado_id  WHERE t.estudiante_id=$user_id GROUP BY p.proyecto_id,p.titulo,p.tipo,p.descripcion,e.nombre,e.descripcion,e.color";

      if ($user_type == 2) $query = "SELECT p.proyecto_id,p.titulo,p.tipo,p.descripcion,e.nombre AS estado,e.descripcion AS es_descrip,e.color FROM proyectos p INNER JOIN tramites t ON t.proyecto_id=p.proyecto_id INNER JOIN detalle_tramite dt ON dt.tramite_id=t.tramite_id INNER JOIN estados e ON e.estado_id=dt.estado_id  WHERE dt.instructor_id=$user_id GROUP BY p.proyecto_id,p.titulo,p.tipo,p.descripcion,e.nombre,e.descripcion,e.color";

      if ($user_type == 1) $query = "SELECT p.proyecto_id,p.titulo,p.tipo,p.descripcion,e.nombre AS estado,e.descripcion AS es_descrip,e.color FROM proyectos p INNER JOIN tramites t ON t.proyecto_id=p.proyecto_id INNER JOIN detalle_tramite dt ON dt.tramite_id=t.tramite_id INNER JOIN estados e ON e.estado_id=dt.estado_id  INNER JOIN usuarios u ON u.sede_id=$user_sede GROUP BY p.proyecto_id,p.titulo,p.tipo,p.descripcion,e.nombre,e.descripcion,e.color";

      if ($user_type == "all") $query = "SELECT p.proyecto_id,p.titulo,p.tipo,p.descripcion,e.nombre,e.descripcion FROM proyectos p INNER JOIN tramites t ON t.proyecto_id=p.proyecto_id INNER JOIN detalle_tramite dt ON dt.tramite_id=t.tramite_id";
    } else {
      if ($filter_state == 'obs') {
        if ($user_type == 2) $query = "SELECT p.proyecto_id,p.titulo,p.tipo,p.descripcion,e.nombre AS estado,e.descripcion AS es_descrip,e.color FROM proyectos p INNER JOIN tramites t ON t.proyecto_id=p.proyecto_id INNER JOIN detalle_tramite dt ON dt.tramite_id=t.tramite_id INNER JOIN estados e ON e.estado_id=dt.estado_id INNER JOIN observaciones o ON o.proyecto_id=t.proyecto_id WHERE dt.instructor_id=$user_id GROUP BY p.proyecto_id,p.titulo,p.tipo,p.descripcion,e.nombre,e.descripcion,e.color";

        if ($user_type == 1) $query = "SELECT p.proyecto_id,p.titulo,p.tipo,p.descripcion,e.nombre AS estado,e.descripcion AS es_descrip,e.color FROM proyectos p INNER JOIN tramites t ON t.proyecto_id=p.proyecto_id INNER JOIN detalle_tramite dt ON dt.tramite_id=t.tramite_id INNER JOIN estados e ON e.estado_id=dt.estado_id INNER JOIN observaciones o ON o.proyecto_id=t.proyecto_id INNER JOIN usuarios u ON u.sede_id=$user_sede WHERE GROUP BY p.proyecto_id,p.titulo,p.tipo,p.descripcion,e.nombre,e.descripcion,e.color";
      } else {
        if ($user_type == 2) $query = "SELECT p.proyecto_id,p.titulo,p.tipo,p.descripcion,e.nombre AS estado,e.descripcion AS es_descrip,e.color FROM proyectos p INNER JOIN tramites t ON t.proyecto_id=p.proyecto_id INNER JOIN detalle_tramite dt ON dt.tramite_id=t.tramite_id INNER JOIN estados e ON e.estado_id=dt.estado_id  WHERE dt.instructor_id=$user_id  AND dt.estado_id=$filter_state GROUP BY p.proyecto_id,p.titulo,p.tipo,p.descripcion,e.nombre,e.descripcion,e.color";

        if ($user_type == 1) $query = "SELECT p.proyecto_id,p.titulo,p.tipo,p.descripcion,e.nombre AS estado,e.descripcion AS es_descrip,e.color FROM proyectos p INNER JOIN tramites t ON t.proyecto_id=p.proyecto_id INNER JOIN detalle_tramite dt ON dt.tramite_id=t.tramite_id INNER JOIN estados e ON e.estado_id=dt.estado_id  INNER JOIN usuarios u ON u.sede_id=$user_sede WHERE dt.estado_id=$filter_state GROUP BY p.proyecto_id,p.titulo,p.tipo,p.descripcion,e.nombre,e.descripcion,e.color";
      }
    }

    $projects = MainModel::executeQuerySimple($query);

    return $projects->fetchAll();
  }

  // Funcion para obtener datos de un tramite u proyecto
  protected static function getInfoProjectModel($project_id): array
  {
    // obtencion de datos de proyecto
    $query_project = "SELECT p.proyecto_id, p.nombre_archivo, p.titulo, p.tipo, p.descripcion,t.fecha_gen, dt.estado_id, dt.nota, e.nombre AS estado, e.color,e.descripcion AS es_descrip 
    FROM proyectos p 
    INNER JOIN tramites t ON t.proyecto_id = p.proyecto_id 
    INNER JOIN detalle_tramite dt ON dt.tramite_id = t.tramite_id 
    INNER JOIN estados e ON e.estado_id = dt.estado_id 
    WHERE p.proyecto_id = '$project_id' 
    GROUP BY p.proyecto_id, p.titulo, p.tipo, p.descripcion, t.fecha_gen, dt.estado_id, dt.nota, e.nombre,e.color,e.descripcion";
    $project = MainModel::executeQuerySimple($query_project)->fetch();

    // obtención de los datos de los autores
    $queryAuthors = "SELECT u.nombres,u.apellidos 
    FROM usuarios u 
    INNER JOIN tramites t ON u.usuario_id=t.estudiante_id 
    INNER JOIN proyectos p ON p.proyecto_id=t.proyecto_id WHERE p.proyecto_id='$project_id'";
    $authors = MainModel::executeQuerySimple($queryAuthors)->fetchAll();

    // obtención de las observaciones del proyecto
    $obs = ObservationModel::getObservationsModel($project_id);

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
    $sql_project = MainModel::connect()->prepare("INSERT INTO 
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
    $sql = MainModel::connect()->prepare("UPDATE proyectos SET titulo = :title, tipo = :type, descripcion  = :description, nombre_archivo = :filename WHERE proyecto_id = :project_id");
    $sql->bindParam(':title', $new_data['title'], PDO::PARAM_STR);
    $sql->bindParam(':type', $new_data['type'], PDO::PARAM_INT);
    $sql->bindParam(':description', $new_data['description'], PDO::PARAM_STR);
    $sql->bindParam(':filename', $new_data['filename'], PDO::PARAM_STR);
    $sql->bindParam(':project_id', $new_data['project_id'], PDO::PARAM_INT);

    return $sql->execute();
  }
}
