<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">

  <title>Reinitialisation de mot de passe</title>

  <link rel="stylesheet" href="formulaire_general.css">
  <link rel="stylesheet" href="../general.css">

</head>

<?php
session_start();
include('../database/config.php');
include('../database/tools.php');
$email = "";
$errors = array();
$messages = array();

//Vérification du formulaire :
include('../database/reinitialisation_mdp.php');

include('../nav-from-parent/nav.php');
?>

<body>

<div class="maindiv-formulaire">
    <div class="div-formulaire no-padding">
      <form action="" method="post" name="resetpassword" id="resetpassword">
        
        <img src="../images/Logo.png" id="grandlogo-formulaire"/>
        
        <h2 class="titre-formulaire">
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
        
      <div class="div-input">
        <label for="type_compte" >Type de compte</label>
        <select name="role" id="type_compte">
          <option value="">-- Choisissez une option --</option>
          <option value="utilisateur">Utilisateur</option>
          <option value="chef">Chef de chantier</option>
          <option value="admin">Administrateur</option>
        </select>
      </div>

      <div class="div-input">
        <label for="email">Adresse mail</label>
        <input type="email" id="email" name="email" required>
      </div>
      
      <div class="div-button">
        <button name="reinitialisation_mdp" type="submit" class="submit-button">
          <span>Envoyer</span>
        </button>
      </div>
      <a class="link" href="connexion.php">Se connecter</a>
      <br class="big-margin">

    </form>
    </div>
  </div>
  <script src="reinitialisation_mdp.js"></script>
<!--Les 2 </div> qui suivent servent à fermer les div écrites dans sidebar.php  -->
</div>
<?php
make_footer(true);
?>
</div>
</body>
</html>