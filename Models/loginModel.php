<?php

require_once "MainModel.php";

class LoginModel extends MainModel
{

  // Función para inicio de sesión
  protected static function LoginModel(array $data)
  {
    $sql = MainModel::connect()->prepare("SELECT * FROM usuarios WHERE correo = :email AND password = :password AND isActive=1");
    $sql->bindParam(':email', $data['email']);
    $sql->bindParam(':password', $data['password']);
    $sql->execute();

    return $sql;
  }
}
