<?php 
// MODELO PROCESSMODEL

// ....Crear un metodo estatico protegido, llamado "editProcessModel" que edite un proyecto. Recibira un array como parametro:
/* $array = [
  "project_id" => "id del poryecto a editar",
  "datetime_gen" => date('Y-m-d H:i:s'),
  "title" => "nuevo titulo del proyecto",
  "type" => "nuevo tiipo de proyecto",
  "description" => "nueva descripcion del proyecto",
  "filename" => "nuevo nombre de archivo del poryecto",
]; */


/* ....Crear un metodo estatico protegido, llamado "changeStateProcesstModel" que cambie el estado de un tramite. El metodo recibira dos parametros:
	-proccess_id :  id del tramite a modificar
	-new_state   :  nuevo estado a actualizar
Este metodo editará el campo estado de la base de datos.
*/

// MODELO OBSMODEL

// ....Crear una clases llamada  "observationModel".

// ....Crea un metodo protegido statico llamado "doObservationModel". Este metodo creará un registro en la tabla observaciones. recibira un array como parametro:
/* $array=[
  "descryption"=>"descripcion de la observación",
  "proyecto_id"=>"id del Proyecto observado",
  "author_id"=>"id del usuario autor de la observación",
  "state"=>"estado de la observación: 0=por corregir, 1= corregido",
  "date"=>"fecha de la creación de la observacion",
] */

/*....Crea un metodo protegido statico llamado "deleteObservationModel". Este metodo eliminará una observacion de la tabla observaciones. Recibira un parámetro:
-proyecto_id: id del proyecto a eliminar */



// CONTROLADORES TRAMITE PROCESO
?>