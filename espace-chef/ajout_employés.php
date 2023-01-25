<!DOCTYPE html>
<html lang="fr">
<head>
  	<meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet"  href="../general.css">
	<link rel ="stylesheet" href = "../tableau.css"/>
	<link rel="stylesheet"  href="../espace-admin/espace-admin.css">
    <link rel = "stylesheet" href = "../espace-chef/ajout_employés.css">
    <link rel = "stylesheet" href = "../espace-membre/formulaire_general.css">

  	<title>Ajout d'employé</title>
	<script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
</head>

<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../espace-membre/connexion.php');
    exit();
}
else if (isset($_SESSION['role'])) {
	if ($_SESSION['role'] == "admin") {
		header('Location:: ../espace-admin');
	}
	else if ($_SESSION['role'] == "utilisateur") {
		header('Location:: ../espace-utilisateur');
	}
}

include('../database/config.php');
include('../database/tools.php');
include("../database/inscription.php");
list($errors, $messages) = sign_up($conn, "utilisateur");

include('../nav-from-parent/nav.php');
include('sidebar.php');
?>

<body>

<body>
<div class="main-content maindiv-formulaire no-margin-top">
    <div class="div-formulaire">
        <form action="" method="post" id="inscription">
        
            <h2 class="titre-formulaire no-margin-top">Ajout d'employé </h2>

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
            ?>
            <div class="div-input">
                <label for="nom">Nom</label>
                <input type="text" placeholder="Jean" name="nom" id="nom" required>
            </div>
            <div class="div-input">
                <label for="prenom">Prénom</label>
                <input type="text" placeholder="Marc" name="prenom" id="prenom" required>
            </div>
            <div class="div-input">
                <label for="date_naissance">Date de naissance</label>
                <input type="date" placeholder="example@domaine.com" name="date_naissance" id="date_naissance" value="1990-01-01" required>
            </div>
            <div class="div-input">
                <label for="email">Adresse e-mail</label>
                <input type="email" placeholder="example@domaine.com" name="email" id="email" required>
            </div>
            <div class="div-input">
                <label for="tel">Numéro de téléphone</label>
                <input type="tel" name="telephone" id="tel" required>
            </div>
            <div class="radio">
                    <p>Genre : </p>
                    <input type="radio" name="genre" value="1"><p>Femme</p>
                    <input type="radio" name="genre" value="0"><p>Homme</p>
            </div>

            <div class="div-button">
                <button name="inscription" type="submit" class="submit-button">
                    <span>Ajouter</span>
                </button>
            </div>

            <a class="link" href="index.php">Retour</a>

        </form>
    </div>
</div>
    <!-- <div class="log-container">

        <div class="title"><b>Ajout d'employés</b></div>

        <div class="inputs">
            <form action="" method="post" id="inscription">
                <input type="text" placeholder="Nom" name="nom" id="nom" required>
                <br>
                <input type="text" placeholder="Prénom" name="prenom" id="prenom" required>
                <br>
                <input type="date" placeholder="Date de naissance" name="date_naissance" id="date_naiss" value="1990-01-01" required>
                <br>
                <input type="text" placeholder="Adresse e-mail" name="email" id="email" required>
                <br>
                <input type="tel" placeholder="Numéro de téléphone" name="telephone" id="tel" required>
                <br>
                <div class = "radio">
                    <p>Genre : </p> 
                    <input type="radio" name="genre" value="1"><p>Femme</p>
                    <input type="radio" name="genre" value="0"><p>Homme</p>
                </div>
                <button type="submit" name="inscription"><b>Ajouter</b></button>
            </form>
            <a class="link" href="index.php">Retour</a>
            <br>
        </div>
    </div> -->
</div>
<?php
make_footer(false);
?>
</div>
</body>
</html>