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
    if ($_SESSION['role'] == "chef") {
        header('Location:: ../espace-chef');
    }
}
?>
<html>
<body>
</body>
</html>