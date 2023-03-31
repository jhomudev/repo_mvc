<?php

require_once "mainModel.php";

class loginModel extends mainModel
{

  // Función para inicio de sesión
  protected static function loginModel(array $data)
  {
    $sql = mainModel::connect()->prepare("SELECT * FROM usuarios WHERE correo = :email AND password = :password AND isActive=1");
    $sql->bindParam(':email', $data['email']);
    $sql->bindParam(':password', $data['password']);
    $sql->execute();

    return $sql;
  }
}
