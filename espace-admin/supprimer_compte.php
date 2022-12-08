<!DOCTYPE html>
<html lang="fr">
<head>

</head>

<?php
session_start();
require('database/config.php');
if (isset($_GET["utilisateur"])) {
    //vérifier si admin ou propriétaire du compte
    //rediriger en fonction de si c'est un admin ou utilisateur
    $sql = 'DELETE FROM utilisateur WHERE id = ?';
    if ($conn->query($sql) === true) {
        redirect("index.php");
      }else {
        echo "La suppression du compte a échoué: " . $conn->error;
      }
}