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
    <link rel="stylesheet"  href="../libraries/nouislider.css">
  	<title>Espace Administrateur</title>
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
?>

<div class="main-content espace-admin">
<?php
if (isset($_GET["message"]) && $_GET["message"] == "activated") {
    echo('<div class="bar success">
    <i class="ico">&#10004;</i>' . "Votre compte a bien été activé! " . '</div>');
}
if (isset($_GET["message"]) && $_GET["message"] == "deleted") {
    echo('<div class="bar success">
    <i class="ico">&#10004;</i>' . "Le compte a bien été supprimé!" . '</div>');
}
if (isset($_GET["error"]) && $_GET["error"] == "notfound") {
    echo('<div class="bar error">
    <i class="ico">&#9747;</i>' . "Le compte n'a pas été trouvé, nous sommes désolés. " . '</div>');
}
if (isset($_GET["error"]) && $_GET["error"] == "communication") {
    echo('<div class="bar error">
    <i class="ico">&#9747;</i>' . "Problème de communication avec le serveur. Veuillez réessayer" . '</div>');
}
?>
    <p class="espace-admin-title">Espace Administrateur</p>
    <p class="espace-admin-subtitle">Bienvenue <?php echo htmlentities(trim($_SESSION['prenom']) . " " .  $_SESSION['nom']); ?> !</p>
    <p class="espace-admin-secondary-title">Gestion des chefs de chantier</p>
<?php
$messages = array();
include("../database/fetch_data.php");
$tableName="chef";
$columns= ['ID', 'email','nom','prenom','statut'];
$fetchData = fetch_data($conn, $tableName, $columns);
?>

<!-- Tableau pour les chefs de chantier -->
    <div class ="conteneur">
        <form method = "GET" action="" name="recherche" class="recherche-form" id="recherche-form-chef">
            <a class="recherche-submit recherche-element" id="recherche-submit-chef">
                <img src="../images/search.svg">
            </a>
            <input class="recherche-element recherche-text" type = "text" name = "text-chef" placeholder = "Nom, prénom ou email" value="<?php if (isset($_GET['text-chef'])) {echo $_GET['text-chef'];}?>">
        </form>
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
                    <tr class="row-chef" id="<?php echo $data['ID']; ?>">
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

<?php
$messages = array();
$tableName="utilisateur";
$columns= ['ID', 'email','nom','prenom','date_naissance','statut'];
$fetchData2 = fetch_data($conn, $tableName, $columns);
?>
<!-- Tableau pour les utilisateurs -->
    <p class="espace-admin-secondary-title">Gestion des utilisateurs</p>
    <div class ="conteneur">
        <form method = "GET" action="" name="recherche" class="recherche-form" id="recherche-form">
                <a class="recherche-submit recherche-element" id="recherche-submit">
                    <img src="../images/search.svg">
                </a>
                <input class="recherche-element recherche-text" type = "text" name = "text" placeholder = "Nom, prénom, email ou téléphone" value="<?php if (isset($_GET['text'])) {echo $_GET['text'];}?>">
                <div class="recherche-select">
                    <select name="genre" id="auto-submit">
                        <option value="none">Genre</option>
                        <option value="0" <?php if (isset($_GET['genre']) && $_GET['genre'] == 0) {echo "selected";}?>>Homme</option>
                        <option value="1" <?php if (isset($_GET['genre']) && $_GET['genre'] == 1) {echo "selected";}?>>Femme</option>
                    </select>
                </div>
                <p class="age-texte">Age</p>
                <div class="recherche-age">
                    <div id="slider">
                    </div>
                </div>
                <input type="hidden" name="agemin" id="agemin" value="<?php if (isset($_GET['agemin'])) {echo $_GET['agemin'];}?>"> 
                <input type="hidden" name="agemax" id="agemax" value="<?php if (isset($_GET['agemax'])) {echo $_GET['agemax'];}?>">
            </form>
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
            if(is_array($fetchData2)){      
            foreach($fetchData2 as $data){
        ?>
                    <tr class="row" id="<?php echo $data['ID']; ?>">
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
                            <?php echo $fetchData2; ?>
                        </td>
                    </tr>
        <?php
        }?>
                    </tbody>
                </table>
            </div>
   
            <p class = "nombreEmploye">
                <?php echo count_rows($conn, "utilisateur"); ?> utilisateurs
            </p>
            <div class="boutons_employes">
                <button class="AjoutEmployés bouton-important">
                    Ajouter un utilisateur
                </button>
            </div>
        </div>
    </div>
<!--Les 2 </div> qui suivent servent à fermer les div écrites dans sidebar.php  -->
</div>

<?php
make_footer(false);
?>

</div>
<script src="../libraries/nouislider.js"></script>
<script src="../tools.js"></script>
<script src="gestion_utilisateurs.js"></script>
<script>
var slider = document.getElementById('slider');
var input_agemin = document.getElementById('agemin');
var input_agemax = document.getElementById('agemax');

if (input_agemin.value) {
    agemin = parseInt(input_agemin.value);
}
else {
    agemin = 18;
}
if (input_agemax.value) {
    agemax = parseInt(input_agemax.value);
}
else {
    agemax = 75;
}
noUiSlider.create(slider, {
    start: [agemin, agemax],
    connect: true,
    range: {
        'min': 18,
        'max': 75
    },
    tooltips: true,
    step: 1,
});


const el = document.getElementById('recherche-submit');
el.onclick = function(){ 
    var slider = document.getElementById('slider');
    var numbers = slider.noUiSlider.get(true);
    agemin = numbers[0];
    agemax = numbers[1];

    input_agemin.value = agemin;
    input_agemax.value = agemax;
    document.getElementById("recherche-form").submit();
}
const el_genre = document.getElementById('auto-submit');
el_genre.onclick = function() {
    document.getElementById("recherche-form").submit();
};

addEvent('row', rowClick);

const el2 = document.getElementById('recherche-submit-chef');
el2.onclick = function(){ 
    document.getElementById("recherche-form-chef").submit();
}

addEvent('row-chef', chefrowClick);

</script>
</body>
</html>
