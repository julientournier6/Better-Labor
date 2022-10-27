<?php
session_start();
include('database/CMS.php');
$obj = new simpleCMS();
$obj->connect();

if (isset($_POST["add"]))
{$obj->write($_POST, $categ);}
if (isset($_POST["update"])) 
{$obj->update($_POST, $_POST["contentid"]);}

if (isset($_SESSION['admin']) AND $_SESSION['admin'] == 1) {
    echo $obj->display_admin($categ);
} 
else {
    echo $obj->display_public($categ);
}

include("gestion_faq.html");
function saveCategory() {
    include('config.php');
    $id = $_POST["id"];
    $name = $_POST["name"];
    $messages = array();
    $sql = "SELECT * FROM category WHERE ID = '$id'";
    $query_check_datetime = $conn->query($sql);
    $sql = "UPDATE category SET name = '$name' WHERE ID = '$id'";
    $query_update = $conn->query($sql);
    if ($query_update) {
      $messages[] = "La catégorie a bien été modifiée";
    }
    else {
      $messages[] = "Désolé, la catégorie n'a pas pu être modifiée";
    }
  }
function saveQuestion() {
  $id = $_POST["id"];
  $sujet = $_POST["name"];
  $reponse = $_POST["reponse"];
  $messages = array();
}
function deleteCategory() {
  $id = $_POST["id"];
  $q = "DELETE FROM categorie WHERE id = '$id'";
}
function deleteQuestion() {
  $id = $_POST["id"];
  $q = "DELETE FROM question WHERE id = '$id";
}
function moveupClick() {

}
function movedown() {

}
?>