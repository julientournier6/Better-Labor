<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel = "stylesheet" href = "barre_profil.css" type="text/css"/>
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
                            <li><a href="espace-membre/modification_profil_gestionnaire.php?own=1">Mon compte</a></li>
                            <li><a href="espace-membre/changement_mdp.php">Mot de passe</a></li>
                            <li><a href="espace-membre/deconnexion.php">Se déconnecter</a></li>
                            ';
                        }
                        else if ($_SESSION['role'] == 'chef') {
                            echo '
                            <li><a href="espace-chef/sindex.php">Mes employés</a></li>
                            <li><a href="espace-membre/modification_profil_gestionnaire.php?own=1">Mon compte</a></li>
                            <li><a href="espace-membre/modification_mdp.php">Mot de passe</a></li>
                            <li><a href="espace-membre/quiz.php">Quiz</a></li>
                            <li><a href="espace-membre/deconnexion.php">Se déconnecter</a></li>
                            ';
                        }
                        else {
                            echo '                            
                            <li><a href="index.php">Mes employés</a></li>
                            <li><a href="espace-membre/modification_profil_gestionnaire.php?own=1">Mon compte</a></li>
                            <li><a href="espace-membre/modification_mdp.php">Mot de passe</a></li>
                            <li><a href="espace-membre/quiz.php">Quiz</a></li>
                            <li><a href="espace-membre/deconnexion.php">Se déconnecter</a></li>
                            ';
                        }
                        ?>

                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</body>
