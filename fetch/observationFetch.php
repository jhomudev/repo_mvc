<?php

$requestFetch = true;

require_once "../config/APP.php";

session_name(NAMESESSION);
session_start();

if (isset($_SESSION["token"])) {
  require_once "./../Controllers/ObservationController.php";
  $process = new ObservationController();
  if(isset($_POST['observacion_new_state'])) echo $process->changeStateObservationController();
  else if (isset($_POST['observacion_id'])) echo $process->deleteObservationController();
  else echo $process->doObservationController();
} else {
  session_unset();
  session_destroy();
  header("Location:" . SERVER_URL . "/login");
  exit();
}
