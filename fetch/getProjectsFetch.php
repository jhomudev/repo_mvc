<?php

$requestFetch = true;

require_once "../config/APP.php";

session_name(NAMESESSION);
session_start();

if (isset($_SESSION["token"])) {
  require_once "./../Controllers/ProjectController.php";
  $project = new ProjectController();
  $projects = $project->getProjectsController();

  echo json_encode($projects);
  // print_r($_POST);
  // echo json_encode(["s"=>"hola"]);
} else {
  session_unset();
  session_destroy();
  header("Location:" . SERVER_URL . "/login");
  exit();
}
