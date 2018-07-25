<?php

$dsn = "mysql:host=localhost;dbname=books;charset=utf8";
$options = [
  PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
];
try {
  $pdo = new PDO($dsn, "root", "asdasd", $options);
} catch (Exception $e) {
  error_log($e->getMessage());
  exit('Error en la conexion a la base de datos...');
}

?>