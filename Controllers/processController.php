<?php

if ($requestFetch) {
  require_once "./../Models/ProcessModel.php";
} else {
  require_once "./Models/ProcessModel.php";
}

class ProcessController extends ProcessModel
{
  // Función controlador generar tramite o proyecto
  public function generateProcessController()
  {
    $title = MainModel::clearString($_POST["tx_title"]);
    $type = MainModel::clearString($_POST["tx_type"]);
    $authors = MainModel::clearString($_POST["tx_authors"]);
    $description = MainModel::clearString($_POST["tx_descri"]);
    $file = $_FILES["file"];

    // Comprobar campos vacios
    if ($title == "" || $type == "" || $authors == "" || $description == "" || $file["name"] == "") {
      $alert = [
        "Alert" => "simple",
        "title" => "Campos vacios",
        "text" => "Por favor. Complete todos los campos.",
        "icon" => "error"
      ];

      echo json_encode($alert);
      exit();
    }

    $arrayAuthors = explode(",", $authors);
    $isHere = 0;/* acumulador , si mayor a 0; está*/
    $hasProcessAuthors = []; /* arrau de autores q ya tienen tramites */
    foreach ($arrayAuthors as $author) {
      // Comprobar que el usuario generador se haya puesto como autor
      if ($author == $_SESSION['usuario_id'])  $isHere++;

      // Comprobar que los autores no tengan tramites generados
      $sql_verify = "SELECT t.estudiante_id FROM tramites t
      INNER JOIN detalle_tramite dt ON t.tramite_id=dt.tramite_id WHERE t.estudiante_id=$author AND (dt.estado_id<>7 OR dt.nota>" . GRADE_MIN . ")";
      $chek_process = MainModel::executeQuerySimple($sql_verify);
      $author = $chek_process->fetchColumn();
      if ($author) array_push($hasProcessAuthors, $author);
    }
    if (!$isHere) {
      $alert = [
        "Alert" => "simple",
        "title" => "Oops. Inclúyete...",
        "text" => "Usted debe que incluirse como autor",
        "icon" => "error"
      ];

      echo json_encode($alert);
      exit();
    }

    if (count($hasProcessAuthors) > 0) {
      $alert = [
        "Alert" => "simple",
        "title" => "Oops...",
        "text" => "Al parecer uno de los autores ya tiene un tramite generado. Un estudiante solo puede tener un trámite",
        "icon" => "error"
      ];

      echo json_encode($alert);
      exit();
    }

    // Subida de archivo a servidor y obtencion de nombre
    $filename = strtotime("now") . "_" . $file['name'];
    $filename = str_replace(' ', '_', $filename);
    $file_tmp = $file['tmp_name'];

    // Mover el archivo a una ubicación permanente en el servidor
    $dir_destiny = '../uploads/';
    $fileRute = $dir_destiny . $filename;
    move_uploaded_file($file_tmp, $fileRute);

    // Datos del form a enviar
    $arrayProcess = [
      "process_id" => "TR_" . uniqid(),
      "authors" => explode(",", $authors),
      "student_gen" => $_SESSION["usuario_id"],
      "project_id" => "PR_" . uniqid(),
      "datetime_gen" => date('Y-m-d H:i:s'),
      "title" => $title,
      "type" => $type,
      "description" => $description,
      "filename" => $filename,
      "state" => 1,
    ];

    $generateProcess = ProcessModel::generateProcessModel($arrayProcess);

    // $generateProcess obtiene un booleano 
    if ($generateProcess) {
      $alert = [
        "Alert" => "alert&reload",
        "title" => "Trámite generado",
        "text" => "Su trámite se generó exitosamente.",
        "icon" => "success"
      ];
    } else {
      $alert = [
        "Alert" => "simple",
        "title" => "Ocurrio un error inesperado...",
        "text" => "No pudimos registrar su trámite",
        "icon" => "error"
      ];
    }
    echo json_encode($alert);
  }

  // Funcion copntrolador cambiar estado
  public function changeStateProcessController()
  {
    $project_id = $_POST['proyecto_id'];
    $new_state = $_POST['new_state'];

    if (empty($project_id) || empty($new_state)) {
      $alert = [
        "Alert" => "simple",
        "title" => "Campos vacios",
        "text" => "Por favor. Complete todos los campos.",
        "icon" => "error"
      ];

      echo json_encode($alert);
      exit();
    }

    $stm = ProcessModel::changeStateProcessModel($new_state, $project_id);

    if ($stm) {
      $alert = [
        "Alert" => "simple",
        "title" => "Operación realizada",
        "text" => "El proyecto cambio de estado",
        "icon" => "success"
      ];
    } else {
      $alert = [
        "Alert" => "simple",
        "title" => "Opps...Al parece ocurrió un error",
        "text" => "La operación no se realizó.",
        "icon" => "error"
      ];
    }

    echo json_encode($alert);
  }

  // Funcion copntrolador asignar instructor a tramite en tabla dt
  public function assignInstructorController()
  {
    $instructor_id = $_POST['instructor_id'];
    $project_id = $_POST['project_id'];

    if (empty($instructor_id) || empty($project_id)) {
      $alert = [
        "Alert" => "simple",
        "title" => "Campos vacios",
        "text" => "Por favor. Complete todos los campos.",
        "icon" => "error"
      ];

      echo json_encode($alert);
      exit();
    }

    $stm_ins = ProcessModel::assignInstructorModel($instructor_id, $project_id);
    $stm_state = ProcessModel::changeStateProcessModel(2, $project_id);

    if ($stm_ins && $stm_state) {
      $alert = [
        "Alert" => "alert&reload",
        "title" => "Asignación realizada",
        "text" => "El instructor se asignó exitosamente.",
        "icon" => "success"
      ];
    } else {
      $alert = [
        "Alert" => "simple",
        "title" => "Opps...Al parece ocurrió un error",
        "text" => "No se pudo asignar el instructor.",
        "icon" => "error"
      ];
    }
    echo json_encode($alert);
    exit();
  }

  // Funcion controlador asignar la nota..nota distinta por alumno/tramite
  public function assignProcessGradeController()
  {
    $grade = intval($_POST['nota']);
    $dt_id = $_POST['detalle_id'];

    if (empty($grade) || empty($dt_id)) {
      $alert = [
        "Alert" => "simple",
        "title" => "Campos vacios",
        "text" => "Por favor. Asigne la nota correspondiente.",
        "icon" => "error"
      ];

      echo json_encode($alert);
      exit();
    }

    $stm = ProcessModel::assignProcessGradeModel($grade, $dt_id);

    if ($stm) {

      ProcessModel::changeStateProcessModel(5, null, $dt_id);

      $alert = [
        "Alert" => "simple",
        "title" => "Calificación asignada",
        "text" => "El trámite se calificó exitosamente.",
        "icon" => "success"
      ];
    } else {
      $alert = [
        "Alert" => "simple",
        "title" => "Opps...Al parece ocurrió un error",
        "text" => "Las calificaciones no se asignaron.",
        "icon" => "error"
      ];
    }
    echo json_encode($alert);
    exit();
  }

  // Funcion controlador para cancelar tramite
  public function cancelProcessController()
  {
    $proyecto_id = MainModel::clearString($_POST['proyecto_id']);

    if (empty($proyecto_id)) {
      $alert = [
        "Alert" => "simple",
        "title" => "Proyecto no definido",
        "text" => "No se realizó la cancelación.",
        "icon" => "error"
      ];

      echo json_encode($alert);
      exit();
    }

    $stm = ProcessModel::changeStateProcessModel(7, $proyecto_id);

    if ($stm) {
      $alert = [
        "Alert" => "alert&reload",
        "title" => "Trámite cancelado",
        "text" => "El trámite se canceló. Puede generar otro si desea.",
        "icon" => "success"
      ];
    } else {
      $alert = [
        "Alert" => "simple",
        "title" => "Opps...Al parece ocurrió un error",
        "text" => "El trámite no se canceló.",
        "icon" => "error"
      ];
    }

    echo json_encode($alert);
    exit();
  }

  // Funcion controlador para pasar tramite a area academica
  public function passProcessController()
  {
    $proyecto_id = MainModel::clearString($_POST['proyecto_id']);
    $fecha_revision = date('Y-m-d H:i:s');

    if (empty($proyecto_id)) {
      $alert = [
        "Alert" => "simple",
        "title" => "Proyecto no definido",
        "text" => "No se delegó el proyecto.",
        "icon" => "error"
      ];

      echo json_encode($alert);
      exit();
    }

    $Obs = ObservationModel::getObservationsModel($proyecto_id);
    $Obs = MainModel::executeQuerySimple("SELECT * FROM observaciones WHERE proyecto_id='$proyecto_id' AND estado<>" . OB_STATE['Verificada'] . "")->fetchAll();
    $hasObs = count($Obs) > 0;

    if ($hasObs) {
      $alert = [
        "Alert" => "simple",
        "title" => "Proyecto con observaciones",
        "text" => "El proyecto tiene observaciones por corregir aún. Para pasarlas tiene que verificarlas antes.",
        "icon" => "error"
      ];

      echo json_encode($alert);
      exit();
    }

    $stm = ProcessModel::passProcessModel($proyecto_id, $fecha_revision);

    if ($stm) {
      $alert = [
        "Alert" => "alert&reload",
        "title" => "Proyecto delegado",
        "text" => "El proyecto se derivó al área académica.",
        "icon" => "success"
      ];
    } else {
      $alert = [
        "Alert" => "simple",
        "title" => "Opps...Al parece ocurrió un error",
        "text" => "No se derivó el proyecto.",
        "icon" => "error"
      ];
    }

    echo json_encode($alert);
    exit();
  }

  // Funcion controlador para agendar sustentación y asignar jurados
  public function scheduleProjectPresentationController()
  {
    $project_id = MainModel::clearString($_POST['proyecto_id']);
    $carrera_id = MainModel::clearString($_POST['carrera_id']);
    $jurados = MainModel::clearString($_POST['jurados']);
    $fecha = MainModel::clearString($_POST['fecha']);
    $hora = MainModel::clearString($_POST['hora']);

    if (empty($project_id) || empty($fecha) || empty($hora)  || empty($jurados)) {
      $alert = [
        "Alert" => "simple",
        "title" => "Campos vacios",
        "text" => "Por favor. complete todos los campos.",
        "icon" => "error"
      ];

      echo json_encode($alert);
      exit();
    }

    // obtención de archivo , instructor_id y carrera_id de proyecto 
    $project = ProjectModel::getInfoProjectModel($project_id);

    $instructor_id = $project['project']['instructor_id'];
    $file = SERVER_URL . "/uploads/" . $project['project']['nombre_archivo'];

    if ($carrera_id != $project['project']['carrera_id']) {
      $alert = [
        "Alert" => "simple",
        "title" => "Jurado de otra carrera",
        "text" => "Los jurados deben pertenecer a la misma carrera del proyecto.",
        "icon" => "error"
      ];

      echo json_encode($alert);
      exit();
    }

    $f_actual = new DateTime();
    $fecha_sustentacion =  new DateTime($fecha . ' ' . $hora);
    $diff_dates = $f_actual->diff($fecha_sustentacion)->days;
    if ($diff_dates < 4) {
      $alert = [
        "Alert" => "simple",
        "title" => "Fecha inválida",
        "text" => "La fecha de agenda no puede ser menor de 4 dias a la fecha actual",
        "icon" => "error"
      ];

      echo json_encode($alert);
      exit();
    }

    // obtenación de correos de estudiantes
    $authors_mails = MainModel::executeQuerySimple("SELECT correo FROM usuarios u 
    INNER JOIN tramites t ON u.usuario_id=t.estudiante_id
    WHERE t.proyecto_id='$project_id'")->fetchAll();

    // Obtencion de correo de jurados
    $array_ids_juries = explode(",", $jurados);

    $juries_mails = [];
    foreach ($array_ids_juries as $key => $id_jury) {
      if ($id_jury == $instructor_id) {
        $alert = [
          "Alert" => "simple",
          "title" => "Asesor como jurado",
          "text" => "El asesor del proyecto no puede ser un jurado. Por favor asigne a otro jurado.",
          "icon" => "error"
        ];

        echo json_encode($alert);
        exit();
      }

      $mail = MainModel::executeQuerySimple("SELECT correo FROM usuarios WHERE usuario_id=$id_jury");
      array_push($juries_mails, $mail->fetchColumn());
    }

    // data para agenda
    $fecha_sustentacion = $fecha_sustentacion->format('Y-m-d H:i:s');
    $data = [
      "project_id" => $project_id,
      "jurados" => $jurados,
      "fecha_sustentacion" => $fecha_sustentacion,
    ];

    // Comversión de fecha a texto
    $fecha_sustentacion = date("d \d\\e M \d\\e Y", strtotime($fecha_sustentacion));

    $stm_schedule = ProcessModel::scheduleProjectPresentationModel($data);

    // Envio de correo a estudiantes autores
    $title_project = MainModel::executeQuerySimple("SELECT titulo FROM proyectos WHERE proyecto_id='$project_id'")->fetchColumn();
    foreach ($authors_mails as $key => $author_mail) {
      $message = "Buenos días. Su proyecto '$title_project' fue agendado para sustentación en la siguiente fecha: \r\n $fecha_sustentacion.\r\n Por favor, llegar a la hora indicada o minutos antes.";
      $stm_mail_student = MainModel::sendMail($author_mail['correo'], "PROYECTO AGENDADO PARA SUSTENTACIÓN", $message);
    }
    // Envio de correo a jurados
    foreach ($juries_mails as $key => $jury_mail) {
      $message = "Buenos días. A sido elegido como jurado para la sustentación de un proyecto. La fecha de la sustentación es la siguiente:\r\n $fecha_sustentacion.\r\n Por favor, llegar a la hora indicada o minutos antes. En caso de no presentarse, recibirá una sanción.";
      $stm_mail_jury = MainModel::sendMail($jury_mail, "DELEGACIÓN COMO JURADO DE SUTENTACIÓN", $message, $file);
    }

    if ($stm_schedule && $stm_mail_jury && $stm_mail_student) {
      $alert = [
        "Alert" => "alert&reload",
        "title" => "Proyecto agendado",
        "text" => "El proyecto se agendó. Se enviaron los correos correspódientes a los jurados y a los alumnos.",
        "icon" => "success"
      ];
    } else {
      $alert = [
        "Alert" => "simple",
        "title" => "Opps...Al parece ocurrió un error",
        "text" => "No se agendó la sustentación.",
        "icon" => "error"
      ];
    }

    echo json_encode($alert);
    exit();
  }

  // Funcion controlador para subir proyecto a repo/ no tiene metodo model
  public function uploadProjectController()
  {
    $project_id = MainModel::clearString($_POST['proyecto_id']);
    $fecha_publicacion = date('Y-m-d H:i:s');

    if (empty($project_id)) {
      $alert = [
        "Alert" => "simple",
        "title" => "Projecto no definido",
        "text" => "No se encontró el proyecto",
        "icon" => "error"
      ];

      echo json_encode($alert);
      exit();
    }

    // cambio de estado a publicado
    $stm = ProcessModel::uploadProjectModel($fecha_publicacion, $project_id);

    if ($stm) {
      $alert = [
        "Alert" => "alert&reload",
        "title" => "Proyecto publicado",
        "text" => "El proyecto se publicó en el repositorio.",
        "icon" => "success"
      ];
    } else {
      $alert = [
        "Alert" => "simple",
        "title" => "Opps...Al parece ocurrió un error",
        "text" => "El proyecto no se logró publicar.",
        "icon" => "error"
      ];
    }

    echo json_encode($alert);
    exit();
  }
}
