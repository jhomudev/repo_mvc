<?php

require_once "mainModel.php";

class processModel extends mainModel
{

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
      detalle_tramite(tramite_id,estado) 
      VALUES(:process_id,:state)");

      $sql_dt->bindParam(":process_id", $procces_id, PDO::PARAM_STR);
      $sql_dt->bindParam(":state", $state, PDO::PARAM_INT);

      $sql_dt->execute();
    }

    return $sql_project;
  }
}
