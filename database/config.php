<?php

$hostName = "localhost";
$userName = "root";
$pass = "";
$databaseName = "betterlabor";

// $conn = new mysqli($hostName, $userName, $pass, $databaseName);
$conn = new mysqli($_ENV['MYSQL_HOST'], $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASSWORD'], $_ENV['MYSQL_DATABASE']);
if ($conn->connect_error) {
  die("La connexion a échoué : " . $conn->connect_error);
}
function redirect($url) {
  ob_start();
  header('Location: '.$url);
  ob_end_flush();
  die();
}
?>