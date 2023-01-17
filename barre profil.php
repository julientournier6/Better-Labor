<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href = "barre_profil.css" type="text/css"/>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <title>Better Labor</title>
</head>
<body>
    
    <div class="container">
        <nav>
            <input type="checkbox" id="check">
            <label for="check" class="checkbtn">
                <i class="fas fa-bars"></i>
            </label>
            <a class="logo-nav" href="index.php">
            <img src="images/logo.jpg" width="300px" height="100px">
            </a>
            <ul class="all">
                <li class="main"><a href="Découvrir.php"><b>Decouvrir</b></a></li>
                <li class="main"><a href="#"><b>Devenir partenaire</b></a></li>
                <li class="main"><a href="Nous.php"><b>Nous</b></a></li>
                <li class="main"><a href="espace-membre"><b>Mon profil</b></a>
                    <ul class="droplist">
                        <?php
                        if ($_SESSION['role'] == 'admin') {
                            echo '
                            <li><a href="espace-admin/index.php">Dashboard</a></li>
                            <li><a href="espace-admin/gestion_faq.php">Gestion FAQ</a></li>
                            <li><a href="espace-membre/modification_profil.php">Mon compte</a></li>
                            <li><a href="espace-membre/changement_mdp.php">Mot de passe</a></li>
                            <li><a href="espace-membre/deconnexion.php">Se déconnecter</a></li>
                            ';
                        }
                        else if ($_SESSION['role'] == 'chef') {
                            echo '
                            <li><a href="espace-membre/index.php">Mes employés</a></li>
                            <li><a href="espace-membre/modification_profil.php">Mon compte</a></li>
                            <li><a href="espace-membre/modification_mdp.php#">Mot de passe</a></li>
                            <li><a href="espace-membre/deconnexion.php">Se déconnecter</a></li>
                            ';
                        }
                        else {

                        }
                        ?>

                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</body>
