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
    $words = $params['words'];
    
    if (isset($words)) $query = "SELECT p.proyecto_id,p.titulo,p.tipo,p.descripcion,e.nombre AS estado,e.descripcion AS es_descrip,e.color,MAX(t.fecha_gen) AS fecha_gen, MAX(dt.fecha_publicacion) AS fecha_publicacion, GROUP_CONCAT(a.nombres,' ',a.apellidos SEPARATOR ', ')  AS autores FROM proyectos p INNER JOIN tramites t ON t.proyecto_id=p.proyecto_id INNER JOIN usuarios a ON a.usuario_id=t.estudiante_id INNER JOIN detalle_tramite dt ON dt.tramite_id=t.tramite_id INNER JOIN estados e ON e.estado_id=dt.estado_id WHERE dt.estado_id=6 AND p.titulo LIKE '%$words%' GROUP BY p.proyecto_id,p.titulo,p.tipo,p.descripcion,e.nombre,e.descripcion,e.color ORDER BY fecha_gen DESC";
    if (empty($filter_state)) {
      if ($user_type == USER_TYPE['student']) $query = "SELECT p.proyecto_id,p.titulo,p.tipo,p.descripcion,MAX(t.fecha_gen) AS fecha_gen,e.nombre AS estado,e.descripcion AS es_descrip,e.color FROM proyectos p INNER JOIN tramites t ON t.proyecto_id=p.proyecto_id INNER JOIN detalle_tramite dt ON dt.tramite_id=t.tramite_id INNER JOIN estados e ON e.estado_id=dt.estado_id  WHERE t.estudiante_id=$user_id GROUP BY p.proyecto_id,p.titulo,p.tipo,p.descripcion,e.nombre,e.descripcion,e.color ORDER BY dt.estado_id , fecha_gen DESC";

      if ($user_type == USER_TYPE['instructor']) $query = "SELECT p.proyecto_id,p.titulo,p.tipo,p.descripcion,MAX(t.fecha_gen) AS fecha_gen,MAX(e.nombre) AS estado,MAX(e.descripcion) AS es_descrip,MAX(e.color) AS color FROM proyectos p INNER JOIN tramites t ON t.proyecto_id=p.proyecto_id INNER JOIN detalle_tramite dt ON dt.tramite_id=t.tramite_id INNER JOIN estados e ON e.estado_id=dt.estado_id  WHERE dt.instructor_id=$user_id GROUP BY p.proyecto_id,p.titulo,p.tipo,p.descripcion ORDER BY fecha_gen DESC";

      if ($user_type == USER_TYPE['admin']) $query = "SELECT p.proyecto_id,p.titulo,p.tipo,p.descripcion,MAX(t.fecha_gen) AS fecha_gen,MAX(e.nombre) AS estado,MAX(e.descripcion) AS es_descrip,MAX(e.color) AS color FROM proyectos p INNER JOIN tramites t ON t.proyecto_id=p.proyecto_id INNER JOIN detalle_tramite dt ON dt.tramite_id=t.tramite_id INNER JOIN estados e ON e.estado_id=dt.estado_id  INNER JOIN usuarios u ON u.sede_id=$user_sede GROUP BY p.proyecto_id,p.titulo,p.tipo,p.descripcion ORDER BY fecha_gen DESC";
    } else {
      if ($filter_state == "all") $query = "SELECT p.proyecto_id,p.titulo,p.tipo,p.descripcion,MAX(t.fecha_gen) AS fecha_gen,e.nombre AS estado,e.descripcion AS es_descrip,e.color, MAX(dt.fecha_publicacion) AS fecha_publicacion, GROUP_CONCAT(a.nombres,' ',a.apellidos SEPARATOR ', ')  AS autores FROM proyectos p INNER JOIN tramites t ON t.proyecto_id=p.proyecto_id INNER JOIN usuarios a ON a.usuario_id=t.estudiante_id INNER JOIN detalle_tramite dt ON dt.tramite_id=t.tramite_id INNER JOIN estados e ON e.estado_id=dt.estado_id WHERE dt.estado_id=6 GROUP BY p.proyecto_id,p.titulo,p.tipo,p.descripcion,e.nombre,e.descripcion,e.color ORDER BY fecha_gen DESC";
      if ($filter_state == 'obs') {
        if ($user_type == USER_TYPE['instructor']) $query = "SELECT p.proyecto_id,p.titulo,p.tipo,p.descripcion,MAX(t.fecha_gen) AS fecha_gen,MAX(e.nombre) AS estado,MAX(e.descripcion) AS es_descrip,MAX(e.color) AS color FROM proyectos p INNER JOIN tramites t ON t.proyecto_id=p.proyecto_id INNER JOIN detalle_tramite dt ON dt.tramite_id=t.tramite_id INNER JOIN estados e ON e.estado_id=dt.estado_id INNER JOIN observaciones o ON o.proyecto_id=t.proyecto_id WHERE dt.instructor_id=$user_id AND o.estado<>".OB_STATE['Verificada']." GROUP BY p.proyecto_id,p.titulo,p.tipo,p.descripcion ORDER BY t.fecha_gen DESC";

        if ($user_type == USER_TYPE['admin']) $query = "SELECT p.proyecto_id,p.titulo,p.tipo,p.descripcion,MAX(t.fecha_gen) AS fecha_gen,MAX(e.nombre) AS estado,MAX(e.descripcion) AS es_descrip,MAX(e.color) AS color FROM proyectos p INNER JOIN tramites t ON t.proyecto_id=p.proyecto_id INNER JOIN detalle_tramite dt ON dt.tramite_id=t.tramite_id INNER JOIN estados e ON e.estado_id=dt.estado_id INNER JOIN observaciones o ON o.proyecto_id=t.proyecto_id INNER JOIN usuarios u ON u.sede_id=$user_sede WHERE o.estado<>".OB_STATE['Verificada']." GROUP BY p.proyecto_id,p.titulo,p.tipo,p.descripcion ORDER BY t.fecha_gen DESC";
      } else {
        if ($user_type == USER_TYPE['instructor']) $query = "SELECT p.proyecto_id,p.titulo,p.tipo,p.descripcion,MAX(t.fecha_gen) AS fecha_gen,MAX(e.nombre) AS estado,MAX(e.descripcion) AS es_descrip,MAX(e.color) AS color FROM proyectos p INNER JOIN tramites t ON t.proyecto_id=p.proyecto_id INNER JOIN detalle_tramite dt ON dt.tramite_id=t.tramite_id INNER JOIN estados e ON e.estado_id=dt.estado_id  WHERE dt.instructor_id=$user_id  AND dt.estado_id=$filter_state GROUP BY p.proyecto_id,p.titulo,p.tipo,p.descripcion ORDER BY fecha_gen DESC";

        if ($user_type == USER_TYPE['admin']) $query = "SELECT p.proyecto_id,p.titulo,p.tipo,p.descripcion,MAX(t.fecha_gen) AS fecha_gen,MAX(e.nombre) AS estado,MAX(e.descripcion) AS es_descrip,MAX(e.color) AS color FROM proyectos p INNER JOIN tramites t ON t.proyecto_id=p.proyecto_id INNER JOIN detalle_tramite dt ON dt.tramite_id=t.tramite_id INNER JOIN estados e ON e.estado_id=dt.estado_id  INNER JOIN usuarios u ON u.sede_id=$user_sede WHERE dt.estado_id=$filter_state GROUP BY p.proyecto_id,p.titulo,p.tipo,p.descripcion ORDER BY fecha_gen DESC";
      }
    }

    $projects = MainModel::executeQuerySimple($query);

    return $projects->fetchAll();
  }

  // Funcion para obtener datos de un tramite u proyecto
  public static function getInfoProjectModel($project_id): array
  {
    // obtencion de datos de proyecto
    $query_project = "SELECT p.proyecto_id, p.nombre_archivo, p.titulo, p.tipo, p.descripcion,t.estudiante_generador,fecha_gen,dt.instructor_id, (SELECT CONCAT(nombres,' ',apellidos) FROM usuarios WHERE usuario_id=dt.instructor_id) AS instructor , dt.estado_id, dt.jurados,dt.fecha_revision,dt.fecha_sustentacion,dt.fecha_publicacion, dt.nota, e.nombre AS estado, e.color,e.descripcion AS es_descrip, esc.nombre AS escuela, c.nombre AS carrera,c.carrera_id
    FROM proyectos p 
    INNER JOIN tramites t ON t.proyecto_id = p.proyecto_id 
    INNER JOIN detalle_tramite dt ON dt.tramite_id = t.tramite_id 
    INNER JOIN estados e ON e.estado_id = dt.estado_id 
    INNER JOIN usuarios u ON u.usuario_id = t.estudiante_id 
    INNER JOIN carreras c ON c.carrera_id = u.carrera_id 
    INNER JOIN escuelas esc ON esc.escuela_id = c.escuela_id 
    WHERE p.proyecto_id = '$project_id'
    GROUP BY p.proyecto_id, p.titulo, p.tipo, p.descripcion,t.estudiante_generador, fecha_gen, dt.instructor_id, dt.estado_id, dt.jurados,dt.fecha_revision,dt.fecha_sustentacion,dt.fecha_publicacion, dt.nota, e.nombre,e.color,e.descripcion, esc.nombre, c.nombre,c.carrera_id, u.nombres, u.apellidos";
    $project = MainModel::executeQuerySimple($query_project)->fetch();

    // obtención de los datos de los autores
    $juries_names = [];
    if (isset($project['jurados'])) {
      $array_ids_juries = explode(",", $project['jurados']);

      foreach ($array_ids_juries as $key => $id_jury) {
        $jury = MainModel::executeQuerySimple("SELECT CONCAT(nombres,' ', apellidos) AS fullname FROM usuarios WHERE usuario_id=$id_jury");
        array_push($juries_names, $jury->fetchColumn());
      }
    }

    // obtención de los datos de los autores
    $queryAuthors = "SELECT u.usuario_id,u.nombres,u.apellidos,u.sede_id,u.carrera_id,dt.detalle_id,dt.nota
    FROM usuarios u 
    INNER JOIN tramites t ON u.usuario_id=t.estudiante_id
    INNER JOIN detalle_tramite dt ON dt.tramite_id=t.tramite_id
    INNER JOIN proyectos p ON p.proyecto_id=t.proyecto_id WHERE p.proyecto_id='$project_id'";
    $authors = MainModel::executeQuerySimple($queryAuthors)->fetchAll();

    // obtención de las observaciones del proyecto
    $obs = ObservationModel::getObservationsModel($project_id);

    $data = [
      "authors" => $authors,
      "project" => $project,
      "observations" => $obs,
      "juries" => $juries_names,
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
    $sql->bindParam(':project_id', $new_data['project_id'], PDO::PARAM_STR);

    return $sql->execute();
  }
}
