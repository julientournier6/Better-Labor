<!DOCTYPE html>
<html lang="en">
<head>
  	<meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet"  href="../general.css">
  	<title>Espace Membre</title>
  	<link rel="stylesheet" href="espace-membre.css" media="screen">
	<script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
</head>

<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: connexion.php');
    exit();
}
else if (isset($_SESSION['role'])) {
	if ($_SESSION['role'] == "admin") {
		header('Location:: ../espace-admin');
	}
	else if ($_SESSION['role'] == "utilisateur") {
		header('Location:: ../yo.php');
	}
}
?>
<html>
<body>
<div class="wrapper hover_collapse">
	<!-- <div class="top_navbar">
		<div class="logo">Foolish Dev</div>
		<div class="menu">
			<div class="hamburger">
				<i class="fas fa-bars"></i>
			</div>

		</div>
	</div> -->

	<div class="sidebar">
		<div class="sidebar_inner">
		<ul>
			<li>
				<a href="index.php">
					<span class="icon"><img src="../images/dashboard-page.png" class="img"></span>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="modification_profil.php">
					<span class="icon"><img src="../images/profile-page.png" class="img"></span>
					<span class="text">Mon profil</span>
				</a>
			</li>
			<li>
				<a href="changement_mdp.php">
					<span class="icon2"><img src="../images/password-page.svg" class="img"></span>
					<span class="text">Mot de passe</span>
				</a>
			</li>
			<li>
				<a href="deconnexion.php">
					<span class="icon"><img src="../images/logout.png" class="img"></span>
					<span class="text">Déconnexion</span>
				</a>
			</li>

		</ul>
		</div>
	</div>
</div>
<?php
	include('sidebar.php');
    if (isset($_GET["message"]) && $_GET["message"] == "activated") {
        echo('<div class="bar success">
        <i class="ico">&#9747;</i>' . "Votre compte a bien été activé! " . '</div>');
    }
?>

    <p><strong>ESPACE MEMBRES</strong><br />
    Bienvenue <?php echo htmlentities(trim($_SESSION['prenom']) . " " .  $_SESSION['nom']); ?> !<br />

<script type="text/javascript">
var li_items = document.querySelectorAll(".sidebar ul li");
var hamburger = document.querySelector(".hamburger");
var wrapper = document.querySelector(".wrapper");

//Quand on met la souris sur la sidebar, on enleve la classe hover collapse

li_items.forEach((li_item)=>{
	li_item.addEventListener("mouseenter", ()=>{


			li_item.closest(".wrapper").classList.remove("hover_collapse");

	})
})

//Quand on enleve la souris de la sidebar, on enleve la classe hover collapse

li_items.forEach((li_item)=>{
	li_item.addEventListener("mouseleave", ()=>{

			li_item.closest(".wrapper").classList.add("hover_collapse");

	})
})

</script>
</body>
</html>