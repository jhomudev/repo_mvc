<?php

$requestFetch = true;

require_once "../config/APP.php";

session_name(NAMESESSION);
session_start();

if (isset($_POST['token'])) {
  require_once "../Controllers/loginController.php";
  $login=new loginController();

  echo $login->logoutController();

} else {
  session_unset();
  session_destroy();
  header("Location:" . SERVER_URL . "/login");
  exit();
}
