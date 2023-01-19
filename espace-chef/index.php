<!DOCTYPE html>
<html lang="fr">
<head>
  	<meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet"  href="../general.css">
	<link rel ="stylesheet" href = "../tableau.css"/>
	<link rel="stylesheet"  href="../espace-admin/espace-admin.css">
    <link rel="stylesheet"  href="../libraries/nouislider.css">
  	<title>Espace Membre Better Labor</title>
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
<body>
<?php
include('../nav-from-parent/nav.php');
include('sidebar.php');
?>

<?php
$messages = array();
include("../database/fetch_data.php");
include('../database/tools.php');
include("../database/config.php");
$tableName="utilisateur";
$columns= ['ID', 'email','nom','prenom','date_naissance'];
$fetchData = fetch_data($conn, $tableName, $columns);
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
	<p class="espace-admin-title">Espace Chef de chantier</p>
	<p class="espace-admin-subtitle">Bienvenue <?php echo htmlentities(trim($_SESSION['prenom']) . " " .  $_SESSION['nom']); ?> !</p>
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
                    <th>Date de naissance</th>
                    <th>Conditions de travail</th>
                </tr>
                </thead>
                
                <tbody>
        <?php
            if(is_array($fetchData)){      
            foreach($fetchData as $data){
        ?>
                    <tr class="row" id="<?php echo $data['ID']; ?>">
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
   
            <p class = "nombreEmploye"><?php echo count_rows_where($conn, 'utilisateur', 'id_chef', $_SESSION['ID']);?>/50 employés</p>
            <div class="boutons_employes">
                <button class="AjoutEmployés bouton-important" onclick="location.href='ajout_employés.php'" type="button">
                    Ajouter des employés
                </button>
            
                <!-- <button class="AjoutSlot2 bouton-important">
                    Ajouter des slots 
                </button> -->
            </div>
    </div>
</div>
</div>
<script src="../libraries/nouislider.js"></script>
<script src="../espace-admin/gestion_utilisateurs.js"></script>
<script src="../tools.js"></script>
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
}
;

addEvent('row', rowClick);
</script>

<?php
make_footer(false);
?>
</div>  
</body>
</html>