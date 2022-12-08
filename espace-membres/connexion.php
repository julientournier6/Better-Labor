<?php
session_start();
$errors = array();
//on inclue le fichier qui contient nom_de_serveur, nom_bdd, login et password d'accès à la bdd mysql
include("../database/config.php");
//on vérifie que le visiteur a correctement envoyé le formulaire
if (isset($_POST['connexion'])) {
   if ((isset($_POST['email']) && !empty($_POST['email'])) && (isset($_POST['password']) && !empty($_POST['password']))) {
       //on se connecte à la bdd
       if (!$conn->connect_errno) {
           $email = $conn->real_escape_string($_POST['email']);
           $sql = "SELECT * FROM chef WHERE email = '" . $email . "';";
           $result_of_login_check = $conn->query($sql);
           if ($result_of_login_check->num_rows == 1) {
               $result_row = $result_of_login_check->fetch_object();
               if (password_verify($_POST['password'], $result_row->password)) {
                    include("tools.php");
                    connect($result_row);
                    redirect("index.php");
               } 
               else {
                   $errors[] = "Mauvais mot de passe. Veuillez réessayer.";
               }
           } 
           else if ($result_of_login_check->num_rows == 0){
                $errors[] = "Ce mail ne correspond à aucun compte.";
           }
           else {
            $errors[] = "Il y a un problème dans la base de données, votre compte existe en double. Veuillez contacter notre support.";
           }
       } 
       else {
           $errors[] = "Il y a un problème de connexion à notre base de données. Veuillez réessayer.";
       }
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel = "stylesheet" href = "connexion.css"/>
    <link rel = "stylesheet" href = "../general.css"/>
    <title>BetterLabor</title>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img class="better" src="../logo.jpg">
        </div>

        <div class="title"><b>Vos identifiants de connexion </b></div>

        <?php
        if ($errors) {
            foreach ($errors as $error) {
                echo('<div class="bar error">
                <i class="ico">&#9747;</i>' . $error . '</div>');
            }
        }
        ?>

        <div class="inputs">
            <form action="" method="post">
                <input type="text" placeholder="Adresse e-mail " name="email">
                <br> 
                <input type="password" placeholder="Votre mot de passe" name="password">
                <br>
                <button type="submit" name="connexion"><b>Se connecter </b></button>
            </form>
            <a class="link" href="reinitialisation_mdp.php">Mot de passe oublié?</a>
            <a class="link" href="inscription.php">S'inscrire</a>
            <br class="big-margin">
        </div>
    </div>
</body>
</html>