<?php

$requestFetch = true;

require_once "../config/APP.php";

session_name(NAMESESSION);
session_start();

if (isset($_SESSION["token"])) {
  require_once "./../Controllers/ProcessController.php";
  require_once "./../Controllers/ProjectController.php";
  $IP_process = new ProcessController();
  $IP_project = new ProjectController();

  if (empty($_POST['tx_project_id'])) echo $IP_process->generateProcessController();
  else echo $IP_project->editProjectController();
} else {
  session_unset();
  session_destroy();
  header("Location:" . SERVER_URL . "/login");
  exit();
}
