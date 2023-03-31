<?php
require_once "./Models/viewModel.php";

class viewController extends viewModel
{

  // Controlador para obtener plantilla
  public function getTemplateController()
  {
    return require_once "./Views/template.php";
  }

  // Controlador para obtener vista
  public function getViewController()
  {
    if (isset($_GET["view"])) {
      $route = explode("/", $_GET["view"]);
      $response = viewModel::getViewModel($route[0]);
    } else {
      $response = "login";
    }

    return $response;
  }
}
