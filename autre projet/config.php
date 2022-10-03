<?php
$hostName = "localhost";
$userName = "root";
$pass = "";
$databaseName = "saith";
$conn = new mysqli($hostName, $userName, $pass, $databaseName);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
function redirect($url) {
  ob_start();
  header('Location: '.$url);
  ob_end_flush();
  die();
}
?>