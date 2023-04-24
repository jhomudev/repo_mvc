<?php

if ($requestFetch) {
  require_once "./../Models/projectModel.php";
} else {
  require_once "./Models/projectModel.php";
}

class projectController extends projectModel
{
  // funcion controlador obtener proyectos o tramites
  public function getProjectsController()
  {
    $params = [
      "user_type" => $_SESSION['tipo'],
      "user_id" => $_SESSION['usuario_id'],
      "user_sede" => $_SESSION['sede_id'],
      "filter_state" => "",
    ];
    $projects = projectModel::getProjectsModel($params);

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
  public function getInfoProjectController()
  {
    // $projetc_id=$_GET['id']; no funciona el GET xq nosotros asi lo definimos, analizar bien
    $url_actual = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    // Descomponemos la URL
    $componentes_url = parse_url($url_actual);

    // Obtenemos los valores de los parámetros
    parse_str($componentes_url['query'], $parametros);

    $project_id = $parametros['id'];

    $data = projectModel::getInfoProjectModel($project_id);

    $typePro = ["", "INNOVACIÓN", "MEJORA", "CREATIVIDAD"];
    $stateColor = ["", "black", "orange", "purple", "blue", "red", "green", "cyan", "gray"];

    $data['project']["tipo"] = $typePro[$data['project']["tipo"]];
    $data['project']["clr"] = $stateColor[$data['project']["estado_id"]];

    return $data;
  }
}
