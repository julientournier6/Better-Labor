<!DOCTYPE html>
<html lang="fr">
<head>
  	<meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex, nofollow">
    <link rel = "stylesheet"  href="../general.css">
	<link rel ="stylesheet" href = "../tableau.css"/>
	<link rel ="stylesheet" href = "espace-admin.css"/>
  	<title>Espace Admin</title>
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
include('../nav-from-parent/nav.php');
include('sidebar.php');
    if (isset($_GET["message"]) && $_GET["message"] == "activated") {
        echo('<div class="bar success">
        <i class="ico">&#9747;</i>' . "Votre compte a bien été activé! " . '</div>');
    }
?>

<div class="espace-admin">
<p class="espace-admin-title">Espace Administrateur</p>
<p class="espace-admin-subtitle">Bienvenue <?php echo htmlentities(trim($_SESSION['prenom']) . " " .  $_SESSION['nom']); ?> !</p>
<?php
$messages = array();
include("../database/fetch_data.php");
$tableName="chef";
$columns= ['id', 'email','nom','prenom','statut'];
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
                        <th>Statut</th>
                    </tr>
                </thead>
                
                <tbody>
        <?php
            if(is_array($fetchData)){      
            foreach($fetchData as $data){
        ?>
                    <tr class="row" id="$data['id']">
                        <td><?php echo $data['nom']; ?></td>
                        <td><?php echo $data['prenom']; ?></td>
                        <td><?php echo $data['email']; ?></td>
                        <td><?php 
                        if ($data['statut'] == 0) {
                            echo '<img class ="tailleCercle" src = "../images/résultat-vert.png">';
                        }
                        else {
                            echo '<img class ="tailleCercle" src = "../images/résultat-rouge.png">';    
                        }
                            ?>
                        </td> 
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
   
            <p class = "nombreEmploye">
                <?php echo count_rows($conn, "chef"); ?> chefs
            </p>
            <div class="boutons_employes">
                <button class="AjoutEmployés bouton-important">
                    Ajouter un chef
                </button>
            </div>
    </div>
</div>
<!--Les 2 </div> qui suivent servent à fermer les div écrites dans sidebar.php  -->
</div>
<?php
make_footer(true);
?>
</div>
</body>
</html>
<script src="gestion_chefs.js"></script>
<script>
addEvent('row', rowClick)
</script>
</body>
</html>