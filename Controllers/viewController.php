<?php
require_once "./Models/ViewModel.php";

class ViewController extends ViewModel
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
      $response = ViewModel::getViewModel($route[0]);
    } else {
      $response = "login";
    }

    return $response;
  }
}
