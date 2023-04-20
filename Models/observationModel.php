<?php

class observationModel
{
  protected static function doObservationModel(array $datote)
  {
    // Obteniendo datos del array
    /*$descryption = &$datote['descryption'];
    $project_id = &$datote['project_id'];
    $author_id = &$datote['author_id'];
    $state = &$datote['state'];
    $date = &$datote['date'];*/

    // Inserción de registro en la tabla proyectos
    $sql_project = mainModel::connect()->prepare("INSERT INTO 
    proyectos(descripcion,proyecto_id,autor_id,estado,fecha_gen) 
    VALUES(:descryption,:project_id,:author_id,:state,:date)");

    $sql_project->bindParam(":descryption", $descryption, PDO::PARAM_STR);
    $sql_project->bindParam(":project_id", $project_id, PDO::PARAM_INT);
    $sql_project->bindParam(":author_id", $author_id, PDO::PARAM_INT);
    $sql_project->bindParam(":state", $state, PDO::PARAM_INT);
    $sql_project->bindParam(":date", $date, PDO::PARAM_STR);

    $sql_project->execute();
    return $sql_project;



  }

  protected static function deleteObservationModel($proyecto_id)
  {
    // Inserción de registro en la tabla proyectos
    $sql_project = mainModel::connect()->prepare("DELETE FROM observaciones WHERE proyecto_id = :proyecto_id ");
    $sql_project->bindParam(":proyecto_id", $proyecto_id, PDO::PARAM_INT);
    $sql_project->execute();
    return $sql_project;

  }


}



