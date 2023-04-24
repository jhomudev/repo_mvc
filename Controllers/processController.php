<?php

if ($requestFetch) {
  require_once "./../Models/processModel.php";
} else {
  require_once "./Models/processModel.php";
}

class processController extends processModel
{
  // Función controlador generar tramite o proyecto
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
      INNER JOIN detalle_tramite dt ON t.tramite_id=dt.tramite_id WHERE t.estudiante_id=$author AND dt.estado_id<>8 AND dt.estado_id<>5";
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

  // funcion controlador obtener proyectos o tramites
  public function getProcessController()
  {
    $params = [
      "user_type" => $_SESSION['tipo'],
      "user_id" => $_SESSION['usuario_id'],
      "user_sede" => $_SESSION['sede_id'],
      "filter_state" => "",
    ];
    $projects = processModel::getProcessModel($params);

    $typePro = ["", "INNOVACIÓN", "MEJORA", "CREATIVIDAD"];
    $stateColor = ["", "black", "orange", "purple", "blue", "red", "green", "cyan", "gray"];
    $state = ["", "ENVIADO", "EN REVISIÓN", "PASADO", "EN SUSTENTACIÓN", "DESAPROBADO", "APROBADO", "PUBLICADO", "CANCELADO"];

    foreach ($projects as $key => $proj) {
      $projects[$key]["tipo"] = $typePro[$projects[$key]["tipo"]];
      $projects[$key]["clr"] = $stateColor[$projects[$key]["estado_id"]];
      $projects[$key]["estado"] = $state[$projects[$key]["estado_id"]];
    }

    return $projects;
  }

  // Funcion controlador obtener datos del proyecto
  public function getInfoProcessingController()
  {
    // $projetc_id=$_GET['id']; no funciona el GET xq nosotros asi lo definimos, analizar bien
    $url_actual = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    // Descomponemos la URL
    $componentes_url = parse_url($url_actual);

    // Obtenemos los valores de los parámetros
    parse_str($componentes_url['query'], $parametros);

    $project_id = $parametros['id'];

    $data = processModel::getInfoProcessingModel($project_id);

    $typePro = ["", "INNOVACIÓN", "MEJORA", "CREATIVIDAD"];
    $stateColor = ["", "black", "orange", "purple", "blue", "red", "green", "cyan", "gray"];

    $data['project']["tipo"] = $typePro[$data['project']["tipo"]];
    $data['project']["clr"] = $stateColor[$data['project']["estado_id"]];

    return $data;
  }
}
