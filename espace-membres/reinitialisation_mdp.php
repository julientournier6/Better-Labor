<!DOCTYPE html>
<?php
session_start();
require('../database/config.php');

$email = "";
$errors = array();
$messages = array();
 
if(isset($_POST["email"])) {
    if(empty(trim($_POST["email"]))) {
        $errors[] = "Veuillez entrer un mail";     
    } else {
        $email = trim($_POST["email"]);
        $sql = "SELECT * FROM user WHERE email = '" . $email . "';";
        $query_check_email = $conn->query($sql);
        if ($sql && $query_check_email->num_rows == 1) {
            while ($user = mysqli_fetch_assoc($query_check_email)) {
                $mail_sent = sendmail($conn, $user, "Demande de reinitialisation de mot de passe", 'Vous avez demandé de reinitialiser votre mot de passe. <br>Si la demande vient bien de vous, veuillez cliquer sur ce <a href="nouveau_mdp.php">lien</a>.<br>Sinon, nous vous conseillons de vérifier la sécurité de votre compte.');
                if ($mail_sent) {
                    $messages = "Un mail avec le lien de reinitialisation de mot de passe vous a été envoyé.";
                } else {
                    $errors = "Une erreur d'envoi de mail est survenue. Veuillez réessayez.";
                }
            }
        }
        else {
            $errors = "Aucun compte n'a été créé avec cette adresse e-mail.";
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
            <i class="ico">&#9747;</i>' . $message . '</div>');
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
        <button type="submit" id="submitButton" onclick="validateSignupForm()" class="submitButton pure-button pure-button-primary">
          <span>Envoyer</span>
        </button>
      </div>
      <a class="link" href="donnees.html">Se connecter</a>
        
    </form>
    </div>
  </div>
  <script src="reinitialisation_mdp.js"></script>
</body>
</html>