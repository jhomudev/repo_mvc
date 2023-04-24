<?php

$requestFetch = true;

require_once "../config/APP.php";

session_name(NAMESESSION);
session_start();

if (isset($_SESSION["token"])) {
  require_once "./../Controllers/projectController.php";
  $project = new projectController();
  $projects = $project->getProjectsController();

  echo json_encode($projects);
  // echo json_encode(["s"=>"hola"]);
} else {
  session_unset();
  session_destroy();
  header("Location:" . SERVER_URL . "/login");
  exit();
}
