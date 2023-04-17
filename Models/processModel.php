<?php

require_once "mainModel.php";

// Modelo trámite
class processModel extends mainModel
{
  // Funcion general para obetener tramites
  protected static function getProcessModel(array $params)
  {
    // $params = [
    //   "user_type" => 1,
    //   "user_id" => 1231,
    //   "user_sede" => 13234,
    //   "filter_state" => 1,
    // ];
    $user_type = $params['user_type'];
    $user_id = $params['user_id'];
    $user_sede = $params['user_sede'];
    $filter_state = $params['filter_state'];

    if ($user_type == 3) $query = "SELECT p.proyecto_id,p.titulo,p.tipo,p.descripcion,dt.estado_id FROM proyectos p INNER JOIN tramites t ON t.proyecto_id=p.proyecto_id INNER JOIN detalle_tramite dt ON dt.tramite_id=t.tramite_id WHERE t.estudiante_id=$user_id";

    if ($user_type == 2) $query = "SELECT p.proyecto_id,p.titulo,p.tipo,p.descripcion,dt.estado_id FROM proyectos p INNER JOIN tramites t ON t.proyecto_id=p.proyecto_id INNER JOIN detalle_tramite dt ON dt.tramite_id=t.tramite_id WHERE dt.instructor_id=$user_id";

    if ($user_type == 1) $query = "SELECT p.proyecto_id,p.titulo,p.tipo,p.descripcion,dt.estado_id FROM proyectos p INNER JOIN tramites t ON t.proyecto_id=p.proyecto_id INNER JOIN detalle_tramite dt ON dt.tramite_id=t.tramite_id INNER JOIN usuarios u ON u.sede_id=$user_sede";

    if ($user_type == "all") $query = "SELECT p.proyecto_id,p.titulo,p.tipo,p.descripcion,dt.estado_id FROM proyectos p INNER JOIN tramites t ON t.proyecto_id=p.proyecto_id INNER JOIN detalle_tramite dt ON dt.tramite_id=t.tramite_id";

    $process = mainModel::executeQuerySimple($query);

    return $process->fetchAll();
  }

  // Funcion para obtener datos de un tramite u proyecto
  protected static function getprocessing($project_id)
  {
    $query = "SELECT (SELECT nombres,apellidos FROM usuarios u INNER JOIN tramites t ON u.usuario_id=t.esrtudiante_id INNER JOIN proyectos p ON p.proyecto=t.proyecto_id WHERE p.proyecto_id=$project_id) as authors,p.proyecto_id,p.titulo,p.tipo,p.escripcion,dt.estado_id,e.nombre AS estado FROM proyectos p INNER JOIN tramites t ON t.proyecto_id=p.proyecto_id INNER JOIN dt detalle_tramite ON dt.tramite_id=t.tramite_id INNER JOIN e estados ON e.estado_id=dt.estado_id WHERE p.proyecto_id=$project_id";

    $processing = mainModel::executeQuerySimple($query);

    return $processing;
  }

  // Función generar tramite o proceso
  protected static function generateProcessModel(array $data)
  {
    // Obteniendo datos del array
    $student_gen = &$data['student_gen'];
    $project_id = &$data['project_id'];
    $datetime_gen = &$data['datetime_gen'];
    $state = &$data['state'];
    $title = &$data['title'];
    $type = &$data['type'];
    $description = &$data['description'];
    $filename = &$data['filename'];

    // Inserción de registro en la tabla proyectos
    $sql_project = mainModel::connect()->prepare("INSERT INTO 
    proyectos(proyecto_id,titulo,tipo,descripcion,nombre_archivo) 
    VALUES(:project_id,:title,:type,:description,:filename)");

    $sql_project->bindParam(":project_id", $project_id, PDO::PARAM_STR);
    $sql_project->bindParam(":title", $title, PDO::PARAM_STR);
    $sql_project->bindParam(":type", $type, PDO::PARAM_INT);
    $sql_project->bindParam(":description", $description, PDO::PARAM_STR);
    $sql_project->bindParam(":filename", $filename, PDO::PARAM_STR);

    $sql_project->execute();

    foreach ($data["authors"] as $student) {

      $procces_id = $data['process_id'] . "_" . $student;
      $procces_id = &$procces_id;
      $student_id = &$student;

      // Inserción de registro en la tabla tramites, tramite x estudiante
      $sql_process = mainModel::connect()->prepare("INSERT INTO 
      tramites(tramite_id,estudiante_id,estudiante_generador,proyecto_id,fecha_gen) 
      VALUES(:process_id,:student_id,:student_gen,:project_id,:datetime_gen)");

      $sql_process->bindParam(":process_id", $procces_id, PDO::PARAM_STR);
      $sql_process->bindParam(":student_id", $student_id, PDO::PARAM_INT);
      $sql_process->bindParam(":student_gen", $student_gen, PDO::PARAM_INT);
      $sql_process->bindParam(":project_id", $project_id, PDO::PARAM_STR);
      $sql_process->bindParam(":datetime_gen", $datetime_gen, PDO::PARAM_STR);

      $sql_process->execute();

      // Inserción de registro en la tabla detalle_tramites, detalle_tramite x estudiante
      $sql_dt = mainModel::connect()->prepare("INSERT INTO 
      detalle_tramite(tramite_id,estado_id) 
      VALUES(:process_id,:state)");

      $sql_dt->bindParam(":process_id", $procces_id, PDO::PARAM_STR);
      $sql_dt->bindParam(":state", $state, PDO::PARAM_INT);

      $sql_dt->execute();
    }

    return $sql_project;
  }
}
