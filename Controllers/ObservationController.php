<?php

if ($requestFetch) {
  require_once "./../Models/ObservationModel.php";
} else {
  require_once "./Models/ObservationModel.php";
}

class ObservationController extends ObservationModel
{
  // Funcion controlador para crear una observación
  public function doObservationController()
  {
    $ob = [
      "project_id" => $_POST["project_id"],
      "descryption" => $_POST["descryption"],
      "author_id" => $_SESSION["usuario_id"],
      "date" => date("Y-m-d H:i:s"),
    ];

    if (empty($_POST["descryption"]) || empty($_POST["project_id"])) {
      $alert = [
        "Alert" => "simple",
        "title" => "Campos vacios",
        "text" => "Por favor. Detalle su observación",
        "icon" => "warning"
      ];

      echo json_encode($alert);
      exit();
    }

    $stm = ObservationModel::doObservationModel($ob);

    if ($stm) {
      $alert = [
        "Alert" => "alert&reload",
        "title" => "Observación realizada",
        "text" => "La observación se realizó exitosamente",
        "icon" => "success"
      ];

      echo json_encode($alert);
    } else {
      $alert = [
        "Alert" => "simple",
        "title" => "Opps...Al parece ocurrió un error",
        "text" => "La obsrevación no se registró.",
        "icon" => "error"
      ];

      echo json_encode($alert);
    }
  }

  // Funcion controlador para eliminar una observacion
  public function deleteObservationController()
  {
    $observation_id = intval($_POST["observacion_id"]);

    if (empty($observation_id)) {
      $alert = [
        "Alert" => "simple",
        "title" => "Observación indefinida",
        "text" => "El id de la observación no esta definida",
        "icon" => "error"
      ];

      echo json_encode($alert);
      exit();
    }

    $stm = ObservationModel::deleteObservationModel($observation_id);

    if ($stm) {
      $alert = [
        "Alert" => "alert&reload",
        "title" => "Observación eliminada",
        "text" => "La observación se eliminó exitosamente",
        "icon" => "success"
      ];

      echo json_encode($alert);
    } else {
      $alert = [
        "Alert" => "simple",
        "title" => "Opps...Al parece ocurrió un error",
        "text" => "La observación no se eliminó.",
        "icon" => "error"
      ];

      echo json_encode($alert);
    }
  }

  // Funcion controlador para cambiar esdtado de la observación
  public function changeStateObservationController()
  {
    $observation_id = intval(MainModel::clearString($_POST["observacion_id"]));
    $new_state = intval(MainModel::clearString($_POST["observacion_new_state"]));

    if (empty($observation_id)) {
      $alert = [
        "Alert" => "simple",
        "title" => "Observación indefinida",
        "text" => "El id de la observación no esta definida",
        "icon" => "error"
      ];

      echo json_encode($alert);
      exit();
    }

    $stm = ObservationModel::changeStateObservationModel($observation_id, $new_state);

    if ($stm) {
      $word = ($new_state == OB_STATE['Corregida']) ? 'corregida' : ((($new_state == OB_STATE['Verificada'])) ? 'verificada' : '');
      $alert = [
        "Alert" => "alert&reload",
        "title" => "Observación " . $word,
        "text" => "La observación cambió de estado",
        "icon" => "success"
      ];

      echo json_encode($alert);
    } else {
      $alert = [
        "Alert" => "simple",
        "title" => "Opps...Al parece ocurrió un error",
        "text" => "La observación no cambió de estado.",
        "icon" => "error"
      ];

      echo json_encode($alert);
    }
  }
}
