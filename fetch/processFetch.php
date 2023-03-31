<?php

$requestFetch = true;

require_once "../config/APP.php";

session_start();

if (isset($_SESSION["token"])) {
  require_once "./../Controllers/processController.php";
  $user = new processController();

  if (isset($_POST["tx_title"]) && isset($_POST["tx_type"]) && isset($_POST["tx_authors"]) && isset($_POST["tx_descri"]) && isset($_FILES["file"])) {
    echo $user->generateProcessController();
  }
} else {
  session_unset();
  session_destroy();
  header("Location:" . SERVER_URL . "/login");
  exit();
}
