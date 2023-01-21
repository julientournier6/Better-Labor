<!doctype html>
<html>
<head>
    <link rel="stylesheet"  href="../general.css">
    <link rel="stylesheet"  href="../espace-membre/sidebar.css" media="screen">
</head>

<body>
<div class="main-container">
<div class="content">
<div class="wrapper hover_collapse">

	<div class="sidebar">
		<div class="sidebar_inner">
		<ul>
			<li>
				<a href="../espace-chef/index.php">
					<span class="icon"><img src="../images/manage_users.png" class="img"></span>
					<span class="text">Mes Employés</span>
				</a>
			</li>
			<li>
				<a href="../espace-membre/modification_profil_gestionnaire.php?own=1">
					<span class="icon"><img src="../images/profile-page.png" class="img"></span>
					<span class="text">Mon compte</span>
				</a>
			</li>
			<li>
				<a href="../espace-membre/changement_mdp.php">
					<span class="icon2"><img src="../images/password-page.svg" class="img"></span>
					<span class="text">Mot de passe</span>
				</a>
			</li>
			<li>
				<a href="../espace-membre/quiz.php">
					<span class="icon"><img src="../images/quiz.png" class="img"></span>
					<span class="text">Quiz</span>
				</a>
			</li>
			<li>
				<a href="../espace-membre/deconnexion.php">
					<span class="icon"><img src="../images/logout.png" class="img"></span>
					<span class="text">Déconnexion</span>
				</a>
			</li>

		</ul>
		</div>
	</div>
</div>
<script type="text/javascript">
var li_items = document.querySelectorAll(".sidebar ul li");
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