<?php

if ($requestFetch) {
  require_once "./../Models/LoginModel.php";
} else {
  require_once "./Models/LoginModel.php";
}

class LoginController extends LoginModel
{
  // Función controlador para inicio de sesión
  public function LoginController()
  {
    $email = MainModel::clearString($_POST['tx_correo']);
    $password = MainModel::clearString($_POST['tx_password']);

    // Comprabar campos vacios
    if ($email == "" || $password == "") {
      echo '
      <script>
        Swal.fire({
          icon: "error",
          title: "Campos vacios",
          text: "Por favor. complete todos los campos",
          confirmButtonText: "Aceptar",
        });
      </script>
      ';

      exit();
    }

    $data_login = [
      "email" => $email,
      "password" => $password,
    ];

    $data_user = LoginModel::LoginModel($data_login);

    if ($data_user->rowCount() > 0) {
      $data_user = $data_user->fetch();
      $data_user['token'] = md5(uniqid(mt_rand(), true));

      session_name(NAMESESSION);
      session_start();
      $_SESSION = $data_user;
      if ($_SESSION['tipo'] == USER_TYPE['admin']) header("Location: " . SERVER_URL . "/admin");
      if ($_SESSION['tipo'] == USER_TYPE['instructor']) header("Location: " . SERVER_URL . "/instructor");
      if ($_SESSION['tipo'] == USER_TYPE['student']) header("Location: " . SERVER_URL . "/student");
    } else {
      echo '
      <script>
        Swal.fire({
          icon: "error",
          title: "Acceso denegado",
          text: "El usuario y/o contraseña son incorrectos",
          confirmButtonText: "Aceptar",
        });
      </script>
      ';
    }
  }

  // Funcion controlador para forzar cierre de sesión si no esta logeado
  public function forceLogoutController()
  {
    session_name(NAMESESSION);
    session_unset();
    session_destroy();

    if (headers_sent()) echo '<script> window.location.href=' . SERVER_URL . '/login </script>';
    else header("Location: " . SERVER_URL . "/login");
  }

  // Funcion controlador para forzar inicio de sesión si ya esta logeado
  public function forceLogin()
  {
    session_name(NAMESESSION);
    session_start();
    if (isset($_SESSION['token'])) {
      if ($_SESSION['tipo'] == 1) header("Location: " . SERVER_URL . "/admin");
      if ($_SESSION['tipo'] == 2) header("Location: " . SERVER_URL . "/instructor");
      if ($_SESSION['tipo'] == 3) header("Location: " . SERVER_URL . "/student");
    }
  }

  // Funcion controlador para cerrar sesión
  public static function logoutController()
  {
    session_unset();
    session_destroy();

    $alert = [
      "Alert" => "reload"
    ];

    echo json_encode($alert);
  }
}
