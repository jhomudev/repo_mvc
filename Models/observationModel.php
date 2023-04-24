<?php
require_once "mainModel.php";

class observationModel extends mainModel
{
// Funcion para obtener observaciones de un proyecto
  public static function getObservationsModel(string $project_id){
    $queryObs = "SELECT o.descripcion,o.estado,o.fecha_gen,u.nombres,u.apellidos 
    FROM observaciones o
    INNER JOIN usuarios u ON u.usuario_id=o.autor_id
    WHERE o.proyecto_id='$project_id'";
    $obs = mainModel::executeQuerySimple($queryObs);

    return $obs->fetchAll();
  }

  // Funcion hacer/crear observacion
  protected static function doObservationModel(array $data):bool
  {
    // Obteniendo datos del array
    $descryption = &$data['descryption'];
    $project_id = &$data['project_id'];
    $author_id = &$data['author_id'];
    $state = &$data['state'];
    $date = &$data['date'];

    // Inserción de registro en la tabla proyectos
    $sql_project = mainModel::connect()->prepare("INSERT INTO 
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
  protected static function deleteObservationModel($project_id):bool
  {
    $sql_project = mainModel::connect()->prepare("DELETE FROM observaciones WHERE proyecto_id = :proyecto_id ");
    $sql_project->bindParam(":proyecto_id", $project_id, PDO::PARAM_STR);
    
    return $sql_project->execute();

  }

}
