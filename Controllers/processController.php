<?php

if ($requestFetch) {
  require_once "./../Models/processModel.php";
} else {
  require_once "./Models/processModel.php";
}

class processController extends processModel
{
  // Función controlador generar tramite o proceso
  public function generateProcessController()
  {
    $title = mainModel::clearString($_POST["tx_title"]);
    $type = mainModel::clearString($_POST["tx_type"]);
    $authors = mainModel::clearString($_POST["tx_authors"]);
    $description = mainModel::clearString($_POST["tx_descri"]);
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
      INNER JOIN detalle_tramite dt ON t.tramite_id=dt.tramite_id WHERE t.estudiante_id=$author AND dt.estado<>8";
      $chek_process = mainModel::executeQuerySimple($sql_verify);
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

    $generateProcess = processModel::generateProcessModel($arrayProcess);

    /* con el rowCount() se verifica si la operación se realizó correctamente*/
    if ($generateProcess->rowCount() > 0) {
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
}
