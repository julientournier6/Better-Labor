<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href = "modification_profil.css"/>
    <link rel="icon" href="./ico image.ico" type="image/x-icon">
    <title>Modification de profil</title>
</head>
<body>
<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
  header('Location: ../espace-membre/connexion.php');
  exit();
}
include('../database/config.php');
include('../database/tools.php');
$table = "utilisateur";
$errors = array();
$messages = array();
if (isset($_GET["own"])) {
    $own = $_GET["own"];
    //si own == 1 on veut modifier son propre profil, sinon celui d'un autre
    if ($own == 1) {
        if ($_SESSION["role"] == "utilisateur") {
            $row = $_SESSION;
        }
        else {
            //on redirige vers la bonne page
            header('Location: ../espace-membre/modification_profil_gestionnaire.php');
            exit();
        }
    }
    else {
        if ($_SESSION["role"] == "utilisateur") {
            $row = $_SESSION;//pas la permission de changer un profil autre que le sien
        }
        else {
            $id = $_GET["id"];
            $stmt = $conn->prepare("SELECT * FROM $table WHERE ID = ?");
            $stmt->bind_param('s', $id);
            if (!$stmt->execute()) {
                $errors[] = "Problème de communication avec le serveur. Veuillez réessayer"; 
            }
            else {
                $result = $stmt->get_result();
                if ($result->num_rows == 1) {
                    $row = $result->fetch_array();
                    $row['role'] = $table;
                }
                else {
                    $errors[] = "L'utilisateur n'a pas été trouvé.";
                }
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
    if (!empty($messages)) {
        $stmt = $conn->prepare("SELECT * FROM $table WHERE ID = ?");
        $stmt->bind_param('s', $row['ID']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $row = $result->fetch_array();
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
        else { echo "Mon compte"; }
        ?>
        </h1>
        <h4>Employé</h4>
        
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
                <input type="text" name="prenom" value="<?php echo $row["prenom"]; ?>">
            </div>
        
            <div class="inputbox">
                <label>Nom</label>
                <input type="text" name="nom" value="<?php echo $row["nom"]; ?>">
            </div>  
        </div> 
          
        <div class="column">
            <div class="inputbox">
                <label>Adresse e-mail</label>
                <input type="email" name="email" value="<?php echo $row["email"]; ?>">
            </div>

            <div class="inputbox">
               <label>Numéro de telephone</label>
               <input type="tel" name="telephone" value="<?php echo $row["telephone"]; ?>">
            </div>  
        </div>  
        
        <div class="midlle">    
            <div class="inputbox">  
                <label>Votre mot de passe actuel</label>
                <input type="password" name="password" placeholder="Entrez votre mot de passe">
            </div> 
        </div>
        
        <br>
        <button type="submit" name="modification-profil"><b>Modifier le profil</b></button> 
    </form>

<!--Les 2 </div> qui suivent servent à fermer les div écrites dans sidebar.php  -->
</div>
<?php
make_footer(false);
?>
</div>
</body>
</html>
