<!DOCTYPE html>
<?php
session_start();
include("nav.php");
require('config.php');

if(!isset($_SESSION["loggedin"])){
    redirect("profile.php");
}

$new_password = $confirmpassword = "";
$messages = array();
 
if(isset($_POST["changepassword"])) {
    if(empty(trim($_POST["password"]))) {
        $messages[] = "Veuillez entrer un mot de passe";     
    } else if(strlen(trim($_POST["password"])) < 6) {
        $messages[] = "Un mot de passe doit avoir plus de 6 caractères.";
    } else if (empty(trim($_POST["confirmpassword"]))) {
        $messages[] = "Veuillez confirmer le mot de passe.";
    }else {
        $new_password = $_POST["password"];
        $confirmpassword = $_POST["confirmpassword"];
        if ($new_password != $confirmpassword) {
            $messages[] = "Les mots de passe ne correspondent pas";
        } else {
            $password = password_hash($new_password, PASSWORD_DEFAULT);
            $id = $_SESSION["id"];
            $sql = "UPDATE utilisateur SET password = '$password' WHERE id = '$id'";
            $query_update_password = $conn->query($sql);
            if ($query_update_password) {
                $messages[] = "Le mot de passe a bien été mis à jour!";
            } else {
                $messages[] = "Nous sommes désolés, nous n'avons pas pu mettre à jour le mot de passe";
            }
        }
    }
}
?>