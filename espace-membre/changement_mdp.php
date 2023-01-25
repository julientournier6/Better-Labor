<!doctype html>

<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Changement de mot de passe</title>
  <link rel="stylesheet" href="formulaire_general.css">
  <link rel="stylesheet" href="../general.css">
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

$new_password = $confirmpassword = "";
$messages = array();
$errors = array();
 
if(isset($_POST["changement_mdp"])) {
    if(empty(trim($_POST["password"]))) {
        $errors[] = "Veuillez entrer un mot de passe";     
    } else if(strlen(trim($_POST["password"])) < 6) {
        $errors[] = "Un mot de passe doit avoir au moins 6 caractères.";
    } else if (empty(trim($_POST["confirmpassword"]))) {
        $errors[] = "Veuillez confirmer le mot de passe.";
    }else {
        $new_password = $_POST["password"];
        $confirmpassword = $_POST["confirmpassword"];
        if ($new_password != $confirmpassword) {
            $errors[] = "Les mots de passe ne correspondent pas";
        } else {
            $password = password_hash($new_password, PASSWORD_DEFAULT);
            $id = $_SESSION["ID"];
            $role = $_SESSION["role"];
            $sql = "UPDATE $role SET password = '$password' WHERE ID = '$id'";
            $query_update_password = $conn->query($sql);
            if ($query_update_password) {
                $messages[] = "Le mot de passe a bien été mis à jour!";
            } else {
                $errors[] = "Nous sommes désolés, nous n'avons pas pu mettre à jour le mot de passe";
            }
        }
    }
}

include('../nav-from-parent/nav.php');
include('../espace-' . $_SESSION['role'] . '/sidebar.php');
?>
<div class="main-content maindiv-formulaire">
    <div class="div-formulaire">
      <form action="" method="post" id="changement_mdp">
        
        <img src="../images/Logo.png" id="logo-formulaire"/>
        
        <h2 class="titre-formulaire">
          <?php
          if (isset($_GET["reinitialisation"])) {
            echo "Reinitialisation de mot de passe";
          }
          else {
            echo "Changement de mot de passe";
          }
          ?>
        </h2>

        <?php
        if ($messages) {
            foreach ($messages as $message) {
            echo('<div class="bar success">
            <i class="ico">&#10004;</i>' . $message . '</div>');
            }
        }
        if ($errors) {
            foreach ($errors as $error) {
                echo('<div class="bar error">
                <i class="ico">&#9747;</i>' . $error . '</div>');
            }
        }

        ?>
        
      <div class="div-input">
        <label class="label-input" for="password">Nouveau mot de passe</label>
        <input type="password" id="password" name="password" required>
      </div>
        
      <div class="div-input">
        <label class="label-input" for="confirmpassword">Confirmer le mot de passe</label>
        <input type="password" id="confirmpassword" name="confirmpassword">
      </div>
      
      <div class="div-button">
        <button name="changement_mdp" type="submit" onclick="return validateSignupForm();" class="submit-button">
          <span>Continuer</span>
        </button>
      </div>

      <a class="link" href="index.php">Retour au profil</a>
        
    </form>
    </div>
    <br class="big-margin">
    <br class="big-margin">
    
  </div>

<!--Les 2 </div> qui suivent servent à fermer les div écrites dans sidebar.php  -->
</div>
  <script src="changement_mdp.js"></script>
<?php
make_footer(false);
?>
</div>
</body>
</html>