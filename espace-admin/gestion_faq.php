<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">

  <title>Tableau de bord FAQ</title>

  <link rel="stylesheet" href="../faq.css">
  <script src="gestion_faq.js"></script>
  <script src="../tools.js"></script>

</head>

<body class="background">
  <div class="faq">

  <h1 class="title">Gestion de la FAQ</h1>
<?php
session_start();
include('FAQManager.php');
$obj = new FAQManager();
$obj->connect("../database/config.php");

if (isset($_POST["nom"])) {
  $obj->saveCategory($_POST);
}
if (isset($_POST["save-question"])) {
  $obj->saveQuestion($_POST);
}
if (isset($_POST["delete-question"])) {
  $obj->deleteQuestion($_POST['id']);
}
if (isset($_POST["delete-category"])) {
  $obj->deleteCategory($_POST['id']);
}
if (isset($_POST["add-question"])) {
  $obj->addQuestion($_POST["id"]);
}
if (isset($_POST["add-category"])) {
  $obj->addCategory();
}
if (isset($_POST["move-question"])) {
  $obj->moveQuestion($_POST["id"], $_POST["step"]);
}
if (isset($_POST["move-category"])) {
  echo "yo";
  $obj->moveCategory($_POST["id"], $_POST["step"]);
}
echo $obj->display_admin();

// if (isset($_POST["save-category"])) 
// {$obj->saveCategory($_POST);}
// if (isset($_POST["save-question"])) 
// {$obj->saveQuestion($_POST);}

if (isset($_SESSION['admin']) AND $_SESSION['admin'] == 1) {
    echo $obj->display_admin();
} 
else {
    //echo "Cette page n'est pas accessible.";
}
?>
<script>
const el = document.getElementsByClassName("side-button");

for (var i=0; i<el.length; i++) {
  el[i].addEventListener('mouseover', handleMouseOver);
  el[i].addEventListener('mouseout', handleMouseOut);
}
addEvent("editQuestion", editQuestion);
addEvent("editCategory", editCategory);
addEvent("deleteQuestion", deleteQuestion);
addEvent("deleteCategory", deleteCategory);
addEvent("add-question", addQuestion);
addEvent("add-category", addCategory);
addEvent("moveupCategory", moveupCategory);
addEvent("movedownCategory", movedownCategory);
addEvent("moveupQuestion", moveupQuestion);
addEvent("movedownQuestion", movedownQuestion);
</script>