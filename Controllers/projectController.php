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
      "user_type" => $_SESSION['tipo'],
      "user_id" => $_SESSION['usuario_id'],
      "user_sede" => $_SESSION['sede_id'],
      "filter_state" => (isset($_POST['filter'])?$_POST['filter']:''),
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

    foreach (PROJECT_TYPE as $key => $value) {
      if ($data['project']['tipo'] == $value) $data['project']['tipo'] = $key;
    }

    return $data;
  }
}
