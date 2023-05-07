<?php
require_once "MainModel.php";

class ObservationModel extends MainModel
{
  // Funcion para obtener observaciones de un proyecto
  public static function getObservationsModel(string $project_id)
  {
    $queryObs = "SELECT o.observacion_id,o.descripcion,o.estado,o.fecha_gen,o.autor_id,u.nombres,u.apellidos 
    FROM observaciones o
    INNER JOIN usuarios u ON u.usuario_id=o.autor_id
    WHERE o.proyecto_id='$project_id'";
    $obs = MainModel::executeQuerySimple($queryObs);

    return $obs->fetchAll();
  }

  // Funcion hacer/crear observacion
  protected static function doObservationModel(array $data): bool
  {
    // Obteniendo datos del array
    $project_id = $data['project_id'];
    $descryption = $data['descryption'];
    $author_id = $data['author_id'];
    $state = 1;
    $date = $data['date'];

    // Inserción de registro en la tabla proyectos
    $sql_project = MainModel::connect()->prepare("INSERT INTO 
    observaciones(descripcion,proyecto_id,autor_id,estado,fecha_gen) 
    VALUES(:descryption,:project_id,:author_id,:state,:date)");

    $sql_project->bindParam(":descryption", $descryption, PDO::PARAM_STR);
    $sql_project->bindParam(":project_id", $project_id, PDO::PARAM_STR);
    $sql_project->bindParam(":author_id", $author_id, PDO::PARAM_INT);
    $sql_project->bindParam(":state", $state, PDO::PARAM_INT);
    $sql_project->bindParam(":date", $date, PDO::PARAM_STR);

    return $sql_project->execute();
  }

  //Funcion de eliminar observacion
  protected static function deleteObservationModel(int $observation_id): bool
  {
    $sql_project = MainModel::connect()->prepare("DELETE FROM observaciones WHERE observacion_id = :observation_id");
    $sql_project->bindParam(":observation_id", $observation_id, PDO::PARAM_INT);

    return $sql_project->execute();
  }

  //Funcion de eliminar observacion
  protected static function changeStateObservationModel(int $observation_id, int $new_state): bool
  {
    $sql_project = MainModel::connect()->prepare("UPDATE observaciones SET estado=:new_state WHERE observacion_id = :observation_id");
    $sql_project->bindParam(":new_state", $new_state, PDO::PARAM_INT);
    $sql_project->bindParam(":observation_id", $observation_id, PDO::PARAM_INT);

    return $sql_project->execute();
  }
}
