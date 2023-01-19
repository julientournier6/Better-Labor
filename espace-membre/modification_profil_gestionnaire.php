<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href = "modification_profil_gestionnaire.css"/>
    <link rel="icon" href="./ico image.ico" type="image/x-icon">
    <title>Modification de profil</title>
</head>
<script src="donnees.js"></script>
<script src="../tools.js"></script>
<body>
<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
  header('Location: ../espace-membre/connexion.php');
  exit();
}
include('../database/config.php');
include('../database/tools.php');

$errors = array();
$messages = array();

if ($_SESSION["role"] == "utilisateur") {
    header('Location: ../espace-membre/modification_profil.php?own=1');
    exit();
    //on redirige vers la bonne page
}
if (isset($_GET["own"])) {
    $own = $_GET["own"];
    //si own == 1 on veut modifier son propre profil, sinon celui d'un autre
    if ($own == 1) {
            $row = $_SESSION;
            $role = $_SESSION["role"];
            $delete_request = "own=$own";
        }
    else {
        if ($_SESSION["role"] != "admin") {
            header('Location: ../espace-membre/modification_profil_gestionnaire.php?own=1');
            exit();
        }
        $role = "chef";
        $id = $_GET["id"];
        $delete_request = "own=$own&role=$role&id=$id";
        $stmt = $conn->prepare("SELECT * FROM $role WHERE ID = ?");
        $stmt->bind_param('s', $id);
        if (!$stmt->execute()) {
            header('Location: ../espace-admin/index.php?error=communication');
            exit();
        }
        else {
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $row = $result->fetch_array();
                $row['role'] = $role;
            }
            else {
                header('Location: ../espace-admin/index.php?error=notfound');
                exit();
            }
        }
    }
}
else {
    header('Location: ../index.php');
    exit();
}

include("../database/gestion_profil.php");
if (isset($_POST['modification-profil'])) {
    list($errors, $messages) = editProfile($conn, $row, $own);
    //Si la modification de profil a bien eu lieu, on actualise les informations sur la page (secondaire)
    if (!empty($messages)){
        if ($own) {
            $row = $_SESSION;
        }
        else {
            $stmt = $conn->prepare("SELECT * FROM $role WHERE ID = ?");
            $stmt->bind_param('s', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $row = $result->fetch_array();
            }
        }
    }
}

include('../nav-from-parent/nav.php');
include('../espace-' . $_SESSION['role'] . '/sidebar.php');

?>

    

    <form class="modification" method="POST" action="">
        
        <h1>      
        <?php  
        if (!$own) { echo "Gestion de compte"; }
        else { echo "Mon compte";}
        ?>
        </h1>
        <h4>
        <?php
        if ($role == 'chef') {
            echo "Chef de chantier";
        }
        else {
            echo "Administrateur";
        }
        ?></h4>
        
        <br>
        <hr/>
        <?php
        if (isset($messages) && $messages) {
            foreach ($messages as $message) {
            echo('<div class="bar success">
            <i class="ico">&#10004;</i>' . $message . '</div>');
            }
        }
        if (isset($errors) && $errors) {
            foreach ($errors as $error) {
                echo('<div class="bar error">
                <i class="ico">&#9747;</i>' . $error . '</div>');
            }
        }
        ?>
        <div class="column">
            <div class="inputbox">
                <label>Prénom</label>
                <input type="text" value="<?php echo $row["prenom"]; ?>" name="prenom">
            </div>      
        
            <div class="inputbox">
                <label>Nom</label>
                <input type="text" value="<?php echo $row["nom"]; ?>" name="nom">
            </div>  
        </div> 
          
        <div class="column">
            <div class="inputbox">
                <label>Adresse e-mail</label>
                <input type="email" value="<?php echo $row["email"]; ?>" name="email" placeholder="Adresse e-mail">
            </div>  
       
            <div class="inputbox">  
                <label>Votre mot de passe actuel</label>
                <input type="password" name="password" placeholder="Entrez votre le mot de passe">
            </div> 
        </div>
        
        <br>
        <button type="submit" name="modification-profil" class="submit"><b>Modifier le profil</b></button> 
        <button type="button" id="<?php echo $delete_request ?>" class="delete-account"><b>Supprimer le compte</b></button> 
    </form>
<!--Les 2 </div> qui suivent servent à fermer les div écrites dans sidebar.php  -->
</div>
<?php
make_footer(false);
?>
</div>

<script>
addEvent("delete-account", deleteAccount)
</script>
</body>
</html>