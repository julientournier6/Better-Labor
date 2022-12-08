<?php
session_start();
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['admin'])) {
    header('Location: connexion.php');
    exit();
}
?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Espace membre</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet"  href="../general.css">
</head>

<body>
    <?php
    if (isset($_GET["message"]) && $_GET["message"] == "activated") {
        echo('<div class="bar success">
        <i class="ico">&#9747;</i>' . "Votre compte a bien été activé! " . '</div>');
    }
    ?>
    <p><strong>ESPACE MEMBRES</strong><br />
        Bienvenue <?php echo htmlentities(trim($_SESSION['prenom']) . " " .  $_SESSION['nom']); ?> !<br />
        <a href="../gestion_utilisateurs.php">Dashboard</a>
        <a href="modification_profil.php">Mes informations personnelles</a>
        <a href="changement_mdp.php">Changer de mot de passe</a>
        <a href="deconnexion.php">Déconnexion</a>
    </p>
</body>

</html>