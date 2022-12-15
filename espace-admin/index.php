<!DOCTYPE html>
<html lang="fr">
<head>
  	<meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet"  href="../general.css">
  	<title>Espace Membre</title>
  	<link rel="stylesheet" href="../espace-membres/sidebar.css" media="screen">
	<script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
</head>

<?php
session_start();
include('../database/config.php');
include('../database/tools.php');
if (!isset($_SESSION['loggedin'])) {
    header('Location: connexion.php');
    exit();
}
else if (isset($_SESSION['role'])) {
	if ($_SESSION['role'] != "admin") {
		redirect_role($_SESSION['role'], 'index.php');
	}
} 
?>
<html>
<body>

<?php
include('sidebar.php');
    if (isset($_GET["message"]) && $_GET["message"] == "activated") {
        echo('<div class="bar success">
        <i class="ico">&#9747;</i>' . "Votre compte a bien été activé! " . '</div>');
    }
?>

    <p><strong>ESPACE MEMBRES</strong><br />
    Bienvenue <?php echo htmlentities(trim($_SESSION['prenom']) . " " .  $_SESSION['nom']); ?> !<br />
</body>
</html>