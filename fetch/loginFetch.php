<?php

$requestFetch = true;

require_once "../config/APP.php";

session_start();

if (5==5) {
  
} else {
  session_unset();
  session_destroy();
  header("Location:" . SERVER_URL . "/login");
  exit();
}
