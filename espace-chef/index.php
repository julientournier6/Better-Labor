<!DOCTYPE html>
<html lang="fr">
<head>
  	<meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet"  href="../general.css">
	<link rel ="stylesheet" href = "../tableau.css"/>
  	<title>Espace Membre</title>
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
	<?php
$messages = array();
include("../database/fetch_data.php");
include("../database/config.php");
$tableName="utilisateur";
$columns= ['email','nom','prenom','date_naissance'];
$fetchData = fetch_data($conn, $tableName, $columns);
?>
    <div class ="conteneur">
        <div class="conteneur-tableau">
            <table class="tableau">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Date de naissance</th>
                    <th>Conditions de travail</th>
                </tr>
                </thead>
                
                <tbody>
        <?php
            if(is_array($fetchData)){      
            foreach($fetchData as $data){
        ?>
                    <tr>
                        <td><?php echo $data['nom']; ?></td>
                        <td><?php echo $data['prenom']; ?></td>
                        <td><?php echo $data['email']; ?></td>
                        <td><?php echo $data['date_naissance']; ?></td>
                        <td><img class ="tailleCercle" src = "../images/résultat-vert.png"></td> 
                    </tr>
        <?php
        }}else{ ?>
                    <tr>
                        <td colspan="8">
                            <?php echo $fetchData; ?>
                        </td>
                    </tr>
        <?php
        }?>
                    </tbody>
                </table>
            </div>
   
            <p class = "nombreEmploye">xx/50 employés</p>
            <div class="boutons_employes">
                <button class="AjoutEmployés bouton-important">
                    Ajouter des employés
                </button>
            
                <button class="AjoutSlot2 bouton-important">
                    Ajouter des slots 
                </button>
            </div>
    </div>
</body>
</html>