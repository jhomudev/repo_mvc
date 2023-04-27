<?php

if ($requestFetch) {
  require_once "./../Models/ProcessModel.php";
} else {
  require_once "./Models/ProcessModel.php";
}

class ProcessController extends ProcessModel
{
  // Función controlador generar tramite o proyecto
  public function generateProcessController()
  {
    $title = MainModel::clearString($_POST["tx_title"]);
    $type = MainModel::clearString($_POST["tx_type"]);
    $authors = MainModel::clearString($_POST["tx_authors"]);
    $description = MainModel::clearString($_POST["tx_descri"]);
    $file = $_FILES["file"];

    // Comprobar campos vacios
    if ($title == "" || $type == "" || $authors == "" || $description == "" || $file["name"] == "") {
      $alert = [
        "Alert" => "simple",
        "title" => "Campos vacios",
        "text" => "Por favor. Complete todos los campos.",
        "icon" => "error"
      ];

      echo json_encode($alert);
      exit();
    }

    // Comprobar que los autores no tengan tramites generados
    $arrayAuthors = explode(",", $authors);
    $hasProcess = false;
    foreach ($arrayAuthors as $author) {
      $sql_verify = "SELECT t.estudiante_id FROM tramites t
      INNER JOIN detalle_tramite dt ON t.tramite_id=dt.tramite_id WHERE t.estudiante_id=$author AND dt.estado_id<>8 AND dt.estado_id<>5";
      $chek_process = MainModel::executeQuerySimple($sql_verify);
      if ($chek_process->rowCount() > 0) $hasProcess = true;
    }
    if ($hasProcess) {
      $alert = [
        "Alert" => "simple",
        "title" => "Oops...",
        "text" => "Al parecer uno de los autores ya tiene un tramite generado. Un estudiante solo puede tener un trámite",
        "icon" => "error"
      ];

      echo json_encode($alert);
      exit();
    }

    // Subida de archivo a servidor y obtencion de nombre
    $filename = strtotime("now") . "_" . $file['name'];
    $file_tmp = $file['tmp_name'];

    // Mover el archivo a una ubicación permanente en el servidor
    $dir_destiny = '../uploads/';
    $fileRute = $dir_destiny . $filename;
    move_uploaded_file($file_tmp, $fileRute);

    // Datos del form a enviar
    $arrayProcess = [
      "process_id" => "TR_" . uniqid(),
      "authors" => explode(",", $authors),
      "student_gen" => $_SESSION["usuario_id"],
      "project_id" => "PR_" . uniqid(),
      "datetime_gen" => date('Y-m-d H:i:s'),
      "title" => $title,
      "type" => $type,
      "description" => $description,
      "filename" => $filename,
      "state" => 1,
    ];

    $generateProcess = ProcessModel::generateProcessModel($arrayProcess);

    // $generateProcess obtiene un booleano 
    if ($generateProcess) {
      $alert = [
        "Alert" => "clear",
        "title" => "Trámite generado",
        "text" => "Su trámite se generó exitosamente.",
        "icon" => "success"
      ];
    } else {
      $alert = [
        "Alert" => "simple",
        "title" => "Ocurrio un error inesperado...",
        "text" => "No pudimos registrar su trámite",
        "icon" => "error"
      ];
    }
    echo json_encode($alert);
  }

  // Funcion copntrolador cambiar estado
  public function changeStateProcessController()
  {
    $project_id = $_POST['proyecto_id'];
    $new_state = $_POST['new_state'];

    if (empty($project_id) || empty($new_state)) {
      $alert = [
        "Alert" => "simple",
        "title" => "Campos vacios",
        "text" => "Por favor. Complete todos los campos.",
        "icon" => "error"
      ];

      echo json_encode($alert);
      exit();
    }

    $stm = ProcessModel::changeStateProcessModel($project_id, $new_state);

    if ($stm) {
      $alert = [
        "Alert" => "simple",
        "title" => "Operación realizada",
        "text" => "El proyecto cambio de estado",
        "icon" => "success"
      ];

      echo json_encode($alert);
    } else {
      $alert = [
        "Alert" => "simple",
        "title" => "Opps...Al parece ocurrió un error",
        "text" => "La operación no se realizó.",
        "icon" => "error"
      ];

      echo json_encode($alert);
    }
  }

  // Funcion copntrolador asignar instructor a tramite en tabla dt
  public function assignIstructorController()
  {
    $instructor_id = $_POST['instructor_id'];
    $project_id = $_POST['project_id'];

    if (empty($instructor_id) || empty($project_id)) {
      $alert = [
        "Alert" => "simple",
        "title" => "Campos vacios",
        "text" => "Por favor. Complete todos los campos.",
        "icon" => "error"
      ];

      echo json_encode($alert);
      exit();
    }

    $stm = ProcessModel::assignIstructorModel($instructor_id, $project_id);

    if ($stm) {
      $alert = [
        "Alert" => "simple",
        "title" => "Asignación realizada",
        "text" => "El instructor se asignó exitosamente.",
        "icon" => "success"
      ];

      echo json_encode($alert);
    } else {
      $alert = [
        "Alert" => "simple",
        "title" => "Opps...Al parece ocurrió un error",
        "text" => "No se pudo asignar el instructor.",
        "icon" => "error"
      ];

      echo json_encode($alert);
    }
  }

  // Funcion controlador asignar la nota..nota distinta por alumno/tramite
  public function assignProcessGradeController()
  {
    $process_array=["12121","144443"];/* id de tramite de cada alumno */
    $grades_array=[16,20]; /* nota de cada tramite */

    if (empty($process_array) || empty($grades_array)) {
      $alert = [
        "Alert" => "simple",
        "title" => "Campos vacios",
        "text" => "Por favor. Complete los datos necesarios.",
        "icon" => "error"
      ];

      echo json_encode($alert);
      exit();
    }else if(($grades_array)!==($process_array)){/* Corregir con metodo de obtencion de longitud */
      $alert = [
        "Alert" => "simple",
        "title" => "Calificaciones no asignadas",
        "text" => "Por favor. Asigne las calificaciones a todos los alumnos.",
        "icon" => "error"
      ];

      echo json_encode($alert);
      exit();
    }

    foreach ($process_array as $key => $process) {
      $stm = ProcessModel::assignProcessGradeModel($grades_array[$key], $process[$key]);
    }

    if ($stm) {
      $alert = [
        "Alert" => "simple",
        "title" => "Calificaciones asignadas",
        "text" => "Los trámites se calificaron exitosamente.",
        "icon" => "success"
      ];

      echo json_encode($alert);
    } else {
      $alert = [
        "Alert" => "simple",
        "title" => "Opps...Al parece ocurrió un error",
        "text" => "Las calificaciones no se asignaron.",
        "icon" => "error"
      ];

      echo json_encode($alert);
    }
  }
}
