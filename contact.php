<!doctype html>

<html lang="fr">
<head>

  <title>Formulaire de contact Better Labor</title>
  <meta charset="utf-8">

  <link rel="stylesheet" href="contact.css">
  <link rel="stylesheet" href="general.css">
  
</head>
<?php
session_start();
if (isset($_SESSION['loggedin'])) {
    $email = $_SESSION['email'];
}
else {
    $email = "";
}
include('nav.php');
include('database/config.php');
include('database/tools.php');
include('send_mail.php');

$messages = array();
$errors = array();
 
if(isset($_POST["contact"])) {
    $type = $_POST['type'];
    if ($type == "information") {
        $sujet = "Demande d'informations supplémentaires";
    }
    else if ($type == "site") {
        $sujet = "Demande d'aide par rapport au site";
    }
    else if ($type == "casque") {
        $sujet = "Demande d'aide par rapport au casque";
    }
    else {
        $sujet = "Demande commerciale";
    }
    $demande = nl2br($_POST['demande']);
    $sql = "SELECT * FROM admin";
    $result = $conn->query($sql);
    if ($result != false && $result->num_rows > 0) {
        $mail_sent = true;
        while ($result_row = mysqli_fetch_object($result)) {
            if (!sendmail($conn, $result_row, $sujet, $demande, NULL, 1)) {
                $mail_sent = false;
            }
        }
        if ($mail_sent) {
            $messages[] = "Votre demande a bien été envoyée. Notre équipe vous répondra sous peu.";
        } else {
            $errors[] = "Nous sommes désolés, votre demande n'a pas pu être envoyée. Veuillez réessayer.";
        }
    }
    else {
        $errors[] = "Nous sommes désolés, il y a un problème avec notre serveur : aucun administrateur n'a pas être trouvé.";
    }
}
?>
<body>
<div class="mainDiv">
    <div class="cardStyle">
      <form action="" method="post" id="contact">
        
        <!-- <img src="images/Logo.png" id="signupLogo"/> -->
        
        <h2 class="formTitle">Formulaire de contact</h2>

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
        <label class="inputLabel" for="password">Adresse email</label>
        <input class="input" type="email" id="email" name="email" value="<?php echo $email?>" required>
      </div>
        
      <div class="inputDiv">
        <label class="inputLabel" for="type">Type de demande</label>
        <select class="input" id="type" name="type" required>
        <option value="">Veuillez choisir une option</option>
        <option value="information">J'ai besoin d'informations supplémentaires</option>
        <option value="site">J'ai besoin d'aide pour utiliser le site</option>
        <option value="casque">J'ai besoin d'aide pour utiliser le casque</option>
        <option value="commercial">Je souhaite faire une demande commerciale</option>
        </select>
      </div>

      <div class="inputDiv">
        <label class="inputLabel" for="demande">Votre demande</label>
        <textarea class="contact-textarea" name="demande" id="demande" rows="10" maxlength="4000"></textarea>
      </div>
      
      <div class="buttonWrapper">
        <button name="contact" type="submit" id="submitButton" onclick="return validateContactForm();" class="submitButton pure-button pure-button-primary">
          <span>Continuer</span>
        </button>
      </div>
        
    </form>
    </div>
  </div>
  <script src="contact.js"></script>
<?php
make_footer(false);
?>
</body>
</html>