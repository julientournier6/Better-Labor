<?php
session_start();
//on inclue le fichier qui contient nom_de_serveur, nom_bdd, login et password d'accès à la bdd mysql
include("../database/config.php");
include("../database/tools.php");
list($errors, $messages) = sign_up($conn, "admin");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel = "stylesheet" href = "../espace-membre/formulaire_general.css"/>
    <link rel = "stylesheet" href = "../general.css"/>
    <title>Inscription administrateur Better Labor</title>
</head>
<body>
<?php
include('../nav-from-parent/nav.php');
?>
<div class="main-content maindiv-formulaire">
    <div class="div-formulaire no-padding">
        <form action="" method="post" id="inscription">
        
            <img src="../images/logo.png" id="grandlogo-formulaire"/>

            <h2 class="titre-formulaire">Inscription administrateur</h2>

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
            <div class="div-input">
                <label for="nom">Code d'activation</label>
                <input type="text" name="code" id="code" required>
            </div>

            <div class="div-input">
                <label for="nom">Votre nom</label>
                <input type="text" placeholder="Jean" name="nom" id="nom" required>
            </div>
            <div class="div-input">
                <label for="prenom">Votre prénom</label>
                <input type="text" placeholder="Marc" name="prenom" id="prenom" required>
            </div>
            <div class="div-input">
                <label for="email">Votre email</label>
                <input type="email" placeholder="example@domaine.com" name="email" id="email" required>
            </div>
            <div class="div-input">
                <label for="nom">Mot de passe</label>
                <input type="password" name="mdp1" id="mdp1" required>
            </div>
            <div class="div-input">
                <label for="nom">Confirmer le mot de passe</label>
                <input type="password" name="mdp2" id="mdp2" required>
            </div>

            <div class="div-button">
                <button name="inscription" type="submit" onclick="return validateSignupForm();" class="submit-button">
                    <span>S'inscrire</span>
                </button>
            </div>

            <a class="link" href="../espace-membre/connexion.php">Se connecter</a>
            <br class="big-margin">
        </form>
    </div>
</div>
<script src="inscription.js"></script>
<?php
make_footer(false);
?>
</body>
</html>