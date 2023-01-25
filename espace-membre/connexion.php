<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel = "stylesheet" href = "../espace-membre/formulaire_general.css"/>
    <link rel = "stylesheet" href = "../general.css"/>
    <title>Connexion Better Labor</title>
</head>
<?php
session_start();
include("../database/config.php");
include("../database/tools.php");
include("../database/connexion.php");
list($errors, $messages) = sign_in($conn, false);

include('../nav-from-parent/nav.php');
?>
<body>

<div class="main-content maindiv-formulaire">
    <div class="div-formulaire no-padding">
        <form action="" method="post" id="connexion">
        
            <img src="../images/Logo.png" id="grandlogo-formulaire"/>

            <h2 class="titre-formulaire">Vos identifiants de connexion</h2>
                
            <?php
            if ($errors) {
                foreach ($errors as $error) {
                    echo('<div class="bar error">
                    <i class="ico">&#9747;</i>' . $error . '</div>');
                }
            }
            ?>

            <div class="div-input">
                <label for="email">Adresse e-mail</label>
                <input type="email" placeholder="example@domaine.com" name="email" id="email" required>
            </div>
            <div class="div-input">
                <label for="nom">Mot de passe</label>
                <input type="password" name="password" required>
            </div>

            <div class="div-button">
                <button name="connexion" type="submit" class="submit-button">
                    <span>Se connecter</span>
                </button>
            </div>

            <a class="link" href="reinitialisation_mdp.php">Mot de passe oublié?</a>
            <a class="link" href="../espace-chef/inscription.php">S'inscrire</a>
            <br class="big-margin">
        </form>
    </div>
</div>

<?php
make_footer(false);
?>

</body>
</html>