<?php
$hostName = "localhost";
$userName = "root";
$pass = "";
$databaseName = "betterlabor";
$conn = new mysqli($hostName, $userName, $pass, $databaseName);
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