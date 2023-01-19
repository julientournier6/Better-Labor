<!DOCTYPE html>
<html lang="fr">
<head>

</head>

<?php
session_start();
require('config.php');
require('tools.php');
if (!isset($_SESSION["loggedin"])) {
  redirect("../espace-membre/connexion.php");
}

if (isset($_GET['own']) && $_GET['own'] == 1) {
  $own = 1;
  //Si on souhaite supprimer son propre profil:
  $id = $_SESSION["ID"];
  $role = $_SESSION["role"];
  $stmt = $conn->prepare("DELETE FROM $role WHERE ID = ?");
  $stmt->bind_param("s", $id);
}
else {
  $own = 0;
  if (!isset($_GET["id"]) || !isset($_GET["role"])) {
    redirect("index.php");
  }
  $id = $_GET["id"];
  $role = $_GET["role"];
  if (!in_array($role, array("utilisateur","chef"))) {
    redirect("index.php");
  }
  if ($_SESSION["role"] == "utilisateur") {
    redirect("index.php");
  }
  else if ($_SESSION["role"] == "chef") {
    //Si la requête vient d'un chef
    if ($role != "utilisateur") {
      redirect("index.php");
    }
    $id_chef = $_SESSION["ID"];
    $stmt = $conn->prepare("DELETE FROM $role WHERE ID = ? AND id_chef = ?");
    $stmt->bind_param("ss", $id, $id_chef);
  }
  else {
    //Si la requête vient d'un admin
    $stmt = $conn->prepare("DELETE FROM $role WHERE ID = ?");
    $stmt->bind_param("s", $id);
  }
}
//On éxécute la suppression puis on redirige de manière appropriée
if ($stmt->execute()) {
  if ($own) {
    redirect("../index.php?message=deleted");
    session_destroy();
  }
  else {
    redirect_role($_SESSION["role"], "index.php?message=deleted");
  }
}
else {
  echo "La suppression du compte a échoué: " . $conn->error;
} 

?>
</html>