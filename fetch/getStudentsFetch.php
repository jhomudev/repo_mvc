<?php

$requestFetch = true;

require_once "../config/APP.php";

session_name(NAMESESSION);
session_start();

if (isset($_SESSION["token"])) {
  require_once "./../Controllers/ProcessController.php";
  $words = $_POST['words'];
  $IP = new ProcessController();
  $students = $IP->executeQuerySimple("SELECT CONCAT(nombres,' ',apellidos) AS fullname, correo, usuario_id AS id FROM usuarios WHERE tipo=" . USER_TYPE['student'] . " AND carrera_id=" . $_SESSION['carrera_id'] . " AND CONCAT(nombres,' ',apellidos) LIKE '%$words%' OR tipo=" . USER_TYPE['student'] . " AND carrera_id=" . $_SESSION['carrera_id'] . " AND  usuario_id LIKE '%$words%'");

  echo json_encode($students->fetchAll());
} else {
  session_unset();
  session_destroy();
  header("Location:" . SERVER_URL . "/login");
  exit();
}
