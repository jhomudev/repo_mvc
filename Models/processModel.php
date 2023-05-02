<?php

require_once "ProjectModel.php";

// Modelo trámite
class ProcessModel extends ProjectModel
{
  // Función generar tramite o proceso
  protected static function generateProcessModel(array $data): bool
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
    $sql_project = ProjectModel::createProjectModel($project_id, $title, $type, $description, $filename);

    foreach ($data["authors"] as $student) {

      $procces_id = $data['process_id'] . "_" . $student;
      $procces_id = &$procces_id;
      $student_id = &$student;

      // Inserción de registro en la tabla tramites, tramite x estudiante
      $sql_process = MainModel::connect()->prepare("INSERT INTO 
      tramites(tramite_id,estudiante_id,estudiante_generador,proyecto_id,fecha_gen) 
      VALUES(:process_id,:student_id,:student_gen,:project_id,:datetime_gen)");

      $sql_process->bindParam(":process_id", $procces_id, PDO::PARAM_STR);
      $sql_process->bindParam(":student_id", $student_id, PDO::PARAM_INT);
      $sql_process->bindParam(":student_gen", $student_gen, PDO::PARAM_INT);
      $sql_process->bindParam(":project_id", $project_id, PDO::PARAM_STR);
      $sql_process->bindParam(":datetime_gen", $datetime_gen, PDO::PARAM_STR);

      $sql_process->execute();

      // Inserción de registro en la tabla detalle_tramites, detalle_tramite x estudiante
      $sql_dt = MainModel::connect()->prepare("INSERT INTO 
      detalle_tramite(tramite_id,estado_id) 
      VALUES(:process_id,:state)");

      $sql_dt->bindParam(":process_id", $procces_id, PDO::PARAM_STR);
      $sql_dt->bindParam(":state", $state, PDO::PARAM_INT);

      $sql_dt->execute();
    }

    return $sql_project;
  }

  // Funcion para editar el campo estado
  protected static function changeStateProcessModel(int $new_state,  string $project_id = null, int $dt = null): bool
  {

    if (isset($dt)) {
      $sql_project = MainModel::connect()->prepare("UPDATE detalle_tramite SET estado_id = :new_state WHERE detalle_id= :dt");
      $sql_project->bindParam(":new_state", $new_state, PDO::PARAM_INT);
      $sql_project->bindParam(":dt", $dt, PDO::PARAM_STR);

      return $sql_project->execute();
    }

    $sql_project = MainModel::connect()->prepare("UPDATE detalle_tramite dt INNER JOIN tramites t ON dt.tramite_id=t.tramite_id SET dt.estado_id = :new_state WHERE t.proyecto_id= :project_id");
    $sql_project->bindParam(":new_state", $new_state, PDO::PARAM_INT);
    $sql_project->bindParam(":project_id", $project_id, PDO::PARAM_STR);

    return $sql_project->execute();
  }

  // Funcion para asignar un instructor al tramite
  protected static function assignInstructorModel(int $instructor_id, string $project_id): bool
  {
    $stament = MainModel::connect()->prepare('UPDATE detalle_tramite dt INNER JOIN tramites t ON dt.tramite_id=t.tramite_id INNER JOIN proyectos p ON p.proyecto_id=t.proyecto_id SET dt.instructor_id = :instructor_id WHERE t.proyecto_id= :project_id');
    $stament->bindParam(':instructor_id', $instructor_id, PDO::PARAM_INT);
    $stament->bindParam(':project_id', $project_id, PDO::PARAM_STR);

    return $stament->execute();
  }

  // Funcion para asignar la nota..nota distinta por alumno/tramite
  protected static function assignProcessGradeModel(int $nota, string $dt_id): bool
  {
    $stament = MainModel::connect()->prepare('UPDATE detalle_tramite SET nota = :nota WHERE detalle_id = :dt_id');
    $stament->bindParam(':nota', $nota);
    $stament->bindParam(':dt_id', $dt_id);

    return $stament->execute();
  }

  // Funcion para pasar proyecto a area academica
  protected static function passProcessModel(string $project_id, string $fecha_revision)
  {
    $stament = MainModel::connect()->prepare('UPDATE detalle_tramite dt INNER JOIN tramites t ON dt.tramite_id=t.tramite_id INNER JOIN proyectos p ON p.proyecto_id=t.proyecto_id SET dt.estado_id = 3, dt.fecha_revision=:fecha_revision WHERE t.proyecto_id= :project_id');
    $stament->bindParam(':fecha_revision', $fecha_revision, PDO::PARAM_STR);
    $stament->bindParam(':project_id', $project_id, PDO::PARAM_STR);

    return $stament->execute();
  }


  //funcion para agendar sustentación y asignar jurados
  protected static function scheduleProjectPresentationModel(array $data): bool
  {
    $stament = MainModel::connect()->prepare('UPDATE detalle_tramite dt INNER JOIN tramites t ON dt.tramite_id=t.tramite_id INNER JOIN proyectos p ON p.proyecto_id=t.proyecto_id SET dt.estado_id=4, dt.jurados = :jurados, dt.fecha_sustentacion=:fecha_sustentacion WHERE t.proyecto_id= :project_id');
    $stament->bindParam(':project_id', $data['project_id']);
    $stament->bindParam(':jurados', $data['jurados']);
    $stament->bindParam(':fecha_sustentacion', $data['fecha_sustentacion']);

    return $stament->execute();
  }
  //funcion para agendar sustentación y asignar jurados
  protected static function uploadProjectModel($fecha_publicacion, $project_id): bool
  {
    $stament = MainModel::connect()->prepare('UPDATE detalle_tramite dt INNER JOIN tramites t ON dt.tramite_id=t.tramite_id INNER JOIN proyectos p ON p.proyecto_id=t.proyecto_id SET dt.estado_id=6, dt.fecha_publicacion=:fecha_publicacion WHERE t.proyecto_id= :project_id');
    $stament->bindParam(':project_id', $project_id);
    $stament->bindParam(':fecha_publicacion', $fecha_publicacion);

    return $stament->execute();
  }
}
