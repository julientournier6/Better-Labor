<?php
$herogu = false;
if ($herogu) {
  // $hostname = $_ENV["MYSQL_HOST"];
  // $userName = $_ENV["MYSQL_USER"];
  // $pass = $_ENV["MYSQL_PASSWORD"];
  // $databaseName = ["MYSQL_DATABASE"];

    $hostName = "herogu.garageisep.com";
    $userName = "MZdD21NaxX_betterlabo";
    $pass = "IsFwuk8VfFuUP8vx";
    $databaseName = "P9VdwiMT4I_betterlabo";
}
else {
  $hostName = "localhost";
  $userName = "root";
  $pass = "";
  $databaseName = "betterlabor";
}
$conn = new mysqli($hostName, $userName, $pass, $databaseName);
// $conn = new PDO("mysqlhost:host=$hostName;dbname=$databaseName", $userName, $pass);
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