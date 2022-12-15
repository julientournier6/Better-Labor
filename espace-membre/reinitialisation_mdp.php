<!DOCTYPE html>
<?php
session_start();
require('../database/config.php');

$email = "";
$errors = array();
$messages = array();
 
if (isset($_POST["reinitialisation_mdp"])) {
  if(isset($_POST["email"])) {
    if(empty(trim($_POST["email"]))) {
        $errors[] = "Veuillez entrer un mail";     
    } else {
        $email = trim($_POST["email"]);
        $role = $_SESSION['role'];
        $sql = "SELECT * FROM $role WHERE email = '" . $email . "';";
        $query_check_email = $conn->query($sql);
        if ($sql && $query_check_email->num_rows == 1) {
          $row = $query_check_email->fetch_object();
          include("../send_mail.php");
          $code_verification = substr(md5(uniqid(rand(), true)), 16, 16);
          $sql = "UPDATE $role SET code_verification = '$code_verification' WHERE email = '$email'";
          $query_update_code = $conn->query($sql);
          if ($query_update_code) {
          $lien_activation = "127.0.0.1/Better-Labor/espace-membre/activate.php?code_verification=$code_verification&email=$email&reinitialisation_mdp=1&role=$role";
            $mail_sent = sendmail($conn, $row, "Demande de reinitialisation de mot de passe", 'Vous avez demandé de reinitialiser votre mot de passe. <br>Si la demande vient bien de vous, veuillez cliquer sur ce <a href="' . $lien_activation . '">lien</a>.<br>Sinon, nous vous conseillons de vérifier la sécurité de votre compte.');
            if ($mail_sent) {
                $messages[] = "Un mail avec le lien de reinitialisation de mot de passe vous a été envoyé.";
            } 
            else {
                $errors[] = "Une erreur d'envoi de mail est survenue. Veuillez réessayer.";
            }
          }
          else {
              $errors[] = "La requête a echoué. Veuillez réessayer.";
          }
        }
        else {
            $errors[] = "Aucun compte n'a été créé avec cette adresse e-mail.";
        }
    }
  }
}
?>

<html lang="fr">
<head>
  <meta charset="utf-8">

  <title>Reinitialisation de mot de passe</title>

  <link rel="stylesheet" href="changement_mdp.css">
  <link rel="stylesheet" href="../general.css">

</head>
<body class="background">
<div class="mainDiv">
    <div class="cardStyle">
      <form action="" method="post" name="resetpassword" id="signupForm">
        
        <img src="../images/Logo.png" id="signupLogo"/>
        
        <h2 class="formTitle">
          Reinitialisation de mot de passe
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
        <label class="inputLabel" for="email">Adresse mail</label>
        <input type="text" id="email" name="email" required>
      </div>
    
      
      <div class="buttonWrapper">
        <button name="reinitialisation_mdp" type="submit" id="submitButton" onclick="validateSignupForm()" class="submitButton pure-button pure-button-primary">
          <span>Envoyer</span>
        </button>
      </div>
      <a class="link" href="connexion.php">Se connecter</a>
        
    </form>
    </div>
  </div>
  <script src="reinitialisation_mdp.js"></script>
</body>
</html>