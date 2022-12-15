<!doctype html>

<html lang="fr">
<head>
  <meta charset="utf-8">

  <title>Changement de mot de passe</title>

  <link rel="stylesheet" href="changement_mdp.css">
  <link rel="stylesheet" href="../general.css">
  
</head>
<body>
<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
  header('Location: ../espace-membre/connexion.php');
  exit();
}
include('../nav-from-parent/nav.php');
include('../database/config.php');
include('../database/tools.php');
include('../espace-' . $_SESSION['role'] . '/sidebar.php');

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
            $id = $_SESSION["id"];
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
?>
<div class="mainDiv">
    <div class="cardStyle">
      <form action="" method="post" id="changement_mdp">
        
        <img src="../images/Logo.png" id="signupLogo"/>
        
        <h2 class="formTitle">
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
        
      <div class="inputDiv">
        <label class="inputLabel" for="password">Nouveau mot de passe</label>
        <input type="password" id="password" name="password" required>
      </div>
        
      <div class="inputDiv">
        <label class="inputLabel" for="confirmpassword">Confirmer le mot de passe</label>
        <input type="password" id="confirmpassword" name="confirmpassword">
      </div>
      
      <div class="buttonWrapper">
        <button name="changement_mdp" type="submit" id="submitButton" onclick="return validateSignupForm();" class="submitButton pure-button pure-button-primary">
          <span>Continuer</span>
          <span id="loader"></span>
        </button>
      </div>
      <a class="link" href="index.php">Retour au profil</a>
        
    </form>
    </div>
  </div>
  <script src="changement_mdp.js"></script>
<?php
make_footer(false);
?>
</body>
</html>