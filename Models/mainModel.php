<?php
if ($requestFetch) require_once "../config/SERVER.php";
else require_once "./config/SERVER.php";

class mainModel
{

  // Funcion para conectar a la BD
  protected static function connect()
  {
    $connection = new PDO(SGBD, USER, PASS);
    $connection->exec("SET CHARACTER SET utf8");
    return $connection;
  }

  //Funcion para ejecutar consultas simples 
  protected static function executeQuerySimple($query)
  {
    $sql = self::connect()->prepare($query);
    $sql->execute();
    return $sql;
  }

  // Encriptación de cadenas
  public function encryption(string $string): string
  {
    $output = FALSE;
    $key = hash('sha256', SECRET_KEY);
    $iv = substr(hash('sha256', SECRET_IV), 0, 16);
    $output = openssl_encrypt($string, METHOD, $key, 0, $iv);
    $output = base64_encode($output);
    return $output;
  }

  // Desencriptación de cadenas
  protected static function decryption(string $string): string
  {
    $key = hash('sha256', SECRET_KEY);
    $iv = substr(hash('sha256', SECRET_IV), 0, 16);
    $output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
    return $output;
  }

  // Generar codigos aleatorios
  protected static function generateRandomcode(string $letter, int $length, int $num): string
  {
    for ($i = 0; $i < $length; $i++) {
      $random = rand(0, 9);
      $letter .= $random;
    }
    return "$letter-$num";
  }

  // Funcion para limpiar cadenas, para evitar inyecciones SQL
  protected static function clearString(string $string): string
  {
    $string = trim($string);
    $string = stripslashes($string);
    $string = str_ireplace("<script>", "", $string);
    $string = str_ireplace("</script>", "", $string);
    $string = str_ireplace("</script src", "", $string);
    $string = str_ireplace("</script type=", "", $string);
    $string = str_ireplace("SELECT * FROM", "", $string);
    $string = str_ireplace("DELETE FROM", "", $string);
    $string = str_ireplace("UPDATE", "", $string);
    $string = str_ireplace("INSERT INTO", "", $string);
    $string = str_ireplace("DROP TABLE", "", $string);
    $string = str_ireplace("DROP DATABASE", "", $string);
    $string = str_ireplace("TRUNCATE TABLE", "", $string);
    $string = str_ireplace("SHOW TABLES", "", $string);
    $string = str_ireplace("SHOW DATABASES", "", $string);
    $string = str_ireplace("<?php", "", $string);
    $string = str_ireplace("?>", "", $string);
    $string = str_ireplace("--", "", $string);
    $string = str_ireplace(">", "", $string);
    $string = str_ireplace("<", "", $string);
    $string = str_ireplace("[", "", $string);
    $string = str_ireplace("]", "", $string);
    $string = str_ireplace("^", "", $string);
    $string = str_ireplace("==", "", $string);
    $string = str_ireplace(";", "", $string);
    $string = str_ireplace("::", "", $string);
    $string = stripslashes($string);
    $string = trim($string);
    return $string;
  }

  // Funcion para validar datos de los inputs,retorna un bool dependiendo si el dato es correcto
  protected static function verifyInputData(string $filter, string $string): bool
  {
    if (preg_match("/^$filter$/", $string)) return true;
    else return false;
  }

  // Funcion para validar fechas de los inputs, retorna un bool dependiendo si el dato es correcto
  protected static function verifyInputDate(string $date): bool
  {
    $values_array = explode("-", $date);
    if (count($values_array) == 3 && checkdate($values_array[1], $values_array[0], $values_array[2])) {
      return true;
    } else return false;
  }

  // Funcion para paginación de filas/registros
  protected static function pagerRows($page, $num_pages, $url, $num_buttons)
  {
    $tabla = "";
    // Esta funcionalidad no es necesaria para eel funcionamiento, x el moento lo dejamos
  }
}
