<!DOCTYPE html>
<html lang="fr">
<head>
  	<meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet"  href="../general.css">
  	<title>Espace Membre</title>
  	<link rel="stylesheet" href="../espace-membre/sidebar.css" media="screen">
	<script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
</head>

<?php
session_start();
include("../database/config.php");
include("../database/tools.php");
if (!isset($_SESSION['loggedin'])) {
    header('Location: connexion.php');
    exit();
}
else if (isset($_SESSION['role'])) {
	redirect_role($_SESSION["role"], 'index.php');
}
?>
<html>
<body>
</body>
</html>