<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel = "stylesheet" href = "../espace-membre/inscription.css"/>
    <link rel = "stylesheet" href = "../general.css"/>
    <title>Connexion Better Labor</title>
</head>
<?php
session_start();
include("../database/config.php");
include("../database/tools.php");

list($errors, $messages) = sign_in($conn, false);
?>
<body>
<?php
include('../nav-from-parent/nav.php');
?>
    <div class="log-container">
        <div class="logo">
            <img class="better" src="../images/logo.jpg">
        </div>

        <div class="title"><b>Vos identifiants de connexion </b></div>

        <?php
        if ($errors) {
            foreach ($errors as $error) {
                echo('<div class="bar error">
                <i class="ico">&#9747;</i>' . $error . '</div>');
            }
        }
        ?>

        <div class="inputs">
            <form action="" method="post">
                <input type="email" placeholder="Adresse e-mail " name="email">
                <br> 
                <input type="password" placeholder="Votre mot de passe" name="password">
                <br>
                <button type="submit" name="connexion"><b>Se connecter </b></button>
            </form>
            <a class="link" href="reinitialisation_mdp.php">Mot de passe oublié?</a>
            <a class="link" href="../espace-chef/inscription.php">S'inscrire</a>
            <br class="big-margin">
        </div>
    </div>
<?php
make_footer(false);
?>
</body>
</html>