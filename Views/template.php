<?php
$requestFetch = false;
require_once "./Controllers/ViewController.php";
$IV = new ViewController();
$vista = $IV->getViewController();
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://unpkg.com/phosphor-icons"></script>
  <link rel="shortcut icon" href="<?php echo SERVER_URL ?>/Views/assets/iconLogo.png" type="image/x-icon">
  <link href="<?php echo SERVER_URL; ?>/Views/css/<?php echo $vista; ?>.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <title><?php echo COMPANY ?></title>
</head>

<body>
  <?php
  if ($vista == "login" || $vista == "404" || $vista == "repository") {
    require_once "./Views/contents/$vista-view.php";

    if ($vista == "student" || $vista == "project" || $vista == "repository") {
      echo '<script src="' . SERVER_URL . '/Views/js/main.js"></script>';
      echo '<script src="' . SERVER_URL . '/Views/js/' . $vista . '.js"></script>';
    }
  } else {
    session_name(NAMESESSION);
    session_start();

    require_once "Controllers/LoginController.php";
    $lc = new LoginController();

    if (!isset($_SESSION["token"])) {
      $lc->forceLogoutController();
      exit();
    }
  ?>
    <div class="container_main">
      <?php
      include "./Views/inc/header.php";
      include  "./Views/contents/" . $vista . "-view.php";
      ?>

    </div>
    <script src="<?php echo SERVER_URL; ?>/Views/js/main.js"></script>
  <?php
    if ($vista == "student" || $vista == "project" || $vista == "instructor" || $vista == "admin") {
      echo '<script src="' . SERVER_URL . '/Views/js/' . $vista . '.js"></script>';
    }

    include "./Views/inc/scriptHeader.php";
  }
  ?>
</body>