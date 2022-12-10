<?php
session_start();
//on inclue le fichier qui contient nom_de_serveur, nom_bdd, login et password d'accès à la bdd mysql
include("../database/config.php");
include("../database/tools.php");
list($errors, $messages) = sign_up($conn, "chef");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel = "stylesheet" href = "inscription.css"/>
    <link rel = "stylesheet" href = "../general.css"/>
    <title>BetterLabor</title>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img class="better" src="../logo.jpg">
        </div>

        <div class="title"><b>Vos informations personnelles</b></div>

        <div class="inputs">
        <?php
        if (isset($messages) && $messages) {
            foreach ($messages as $message) {
            echo('<div class="bar success">
            <i class="ico">&#10004;</i>' . $message . '</div>');
            }
        }
        if (isset($errors) && $errors) {
            foreach ($errors as $error) {
                echo('<div class="bar error">
                <i class="ico">&#9747;</i>' . $error . '</div>');
            }
        }
        if (isset($_GET["message"]) && $_GET["message"] == "expired") {
            echo('<div class="bar error">
            <i class="ico">&#9747;</i>' . "Ce lien d'activation a expiré! Veuillez vous inscrire à nouveau. " . '</div>');
        }
        if (isset($_GET["message"]) && $_GET["message"] == "invalid") {
            echo('<div class="bar error">
            <i class="ico">&#9747;</i>' . "Erreur : le lien saisi est invalide" . '</div>');
        }
        if (isset($_GET["message"]) && $_GET["message"] == "error") {
            echo('<div class="bar error">
            <i class="ico">&#9747;</i>' . "Il y a un problème de communication avec la base de données, veuillez réessayer plus tard." . '</div>');
        }

        ?>
            <form action="" method="post" id="inscription">
                <input type="text" placeholder="Votre nom" name="nom" required>
                <br> 
                <input type="text" placeholder="Votre prenom" name="prenom" required>
                <br>
                <input type="text" placeholder="Adresse e-mail" name="email" required>
                <br>
                <input type="password" placeholder="Saisir votre mot de passe" name="mdp1" required>
                <br>
                <input type="password" placeholder="Entrez à nouveau le mot de passe" name="mdp2" required>
                <br>
                <button type="submit" name="inscription"><b>S'inscrire</b></button>
            </form>
            <a class="link" href="connexion.php">Se connecter</a>
            <br>
        </div>
    </div>

</body>
</html>