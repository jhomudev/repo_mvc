<?php

if ($requestFetch) {
  require_once "./../Models/ProjectModel.php";
} else {
  require_once "./Models/ProjectModel.php";
}

class ProjectController extends ProjectModel
{
  // funcion controlador obtener proyectos o tramites
  public function getProjectsController()
  {
    $params = [
      "user_type" => isset($_SESSION['tipo']) ? $_SESSION['tipo'] : '',
      "user_id" => isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : '',
      "user_sede" => isset($_SESSION['sede_id']) ? $_SESSION['sede_id'] : '',
      "filter_state" => isset($_POST['filter']) ? $_POST['filter'] : '',
      "words" => isset($_POST['words']) ? $_POST['words'] : '',
    ];

    $projects = ProjectModel::getProjectsModel($params);

    foreach ($projects as $key => $proj) {
      foreach (PROJECT_TYPE as $type => $value) {
        if ($projects[$key]['tipo'] == $value) $projects[$key]['tipo'] = $type;
      }
    }

    return $projects;
  }

  // Funcion controlador obtener datos del proyecto
  public function getInfoProjectController()
  {
    // $projetc_id=$_GET['id']; no funciona el GET xq nosotros asi lo definimos, analizar bien
    $url_actual = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    // Descomponemos la URL
    $componentes_url = parse_url($url_actual);

    // Obtenemos los valores de los parámetros
    parse_str($componentes_url['query'], $parametros);

    $project_id = $parametros['id'];

    $data = ProjectModel::getInfoProjectModel($project_id);

    if (isset($_SESSION['tipo'])) {
      if ($_SESSION['tipo'] == USER_TYPE['student']) {
        if ($data['project']['estado_id'] == 5) {
          $data['project']['estado'] = ($data['project']['nota'] > GRADE_MIN) ? 'APROBADO' : 'DESAPROBADO';
          $data['project']['color'] = ($data['project']['nota'] > GRADE_MIN) ? '#41b753' : '#ed3847';
          $data['project']['es_descrip'] = ($data['project']['nota'] > GRADE_MIN) ? 'Aprobaste la sustentación. Los detalles de la sustentación puede verlos en la vista de tu proyecto.' : 'Lastimosamente no pasaste la sustentación. Puedes generar otro proceso.';
        }
      }
    }


    foreach (PROJECT_TYPE as $key => $value) {
      if ($data['project']['tipo'] == $value) $data['project']['tipo'] = $key;
    }

    return $data;
  }

  // funcion controlador para editar proyecto
  public function editProjectController()
  {
    $project_id = MainModel::clearString($_POST["tx_project_id"]);
    $title = MainModel::clearString($_POST["tx_title"]);
    $type = MainModel::clearString($_POST["tx_type"]);
    $description = MainModel::clearString($_POST["tx_descri"]);
    $file = $_FILES["file"];

    // Comprobar campos vacios
    if ($title == "" || $type == "" || $description == "" || $file["name"] == "") {
      $alert = [
        "Alert" => "simple",
        "title" => "Campos vacios",
        "text" => "Por favor. Complete todos los campos.",
        "icon" => "error"
      ];

      echo json_encode($alert);
      exit();
    }

    // Subida de archivo a servidor y obtencion de nombre
    $filename = strtotime("now") . "_" . $file['name'];
    $filename = str_replace(' ', '_', $filename);
    $file_tmp = $file['tmp_name'];

    // Mover el archivo a una ubicación permanente en el servidor
    $dir_destiny = '../uploads/';
    $fileRute = $dir_destiny . $filename;
    move_uploaded_file($file_tmp, $fileRute);

    // Datos del form a enviar
    $new_data = [
      "project_id" => $project_id,
      "title" => $title,
      "type" => $type,
      "description" => $description,
      "filename" => $filename,
    ];

    $stm = ProjectModel::editProjectModel($new_data);

    // $stm obtiene un booleano 
    if ($stm) {
      $alert = [
        "Alert" => "alert&reload",
        "title" => "Proyecto actualizado",
        "text" => "Su proyecto se actualizó exitosamente.",
        "icon" => "success"
      ];
    } else {
      $alert = [
        "Alert" => "simple",
        "title" => "Ocurrio un error inesperado...",
        "text" => "No pudimos actualizar el proyecto.",
        "icon" => "error"
      ];
    }
    echo json_encode($alert);
  }
}
