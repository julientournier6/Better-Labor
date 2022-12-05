<?php
session_start();
//on inclue le fichier qui contient nom_de_serveur, nom_bdd, login et password d'accès à la bdd mysql
include("../database/config.php");
$errors = array();
$messages = array();
$expiry = 1 * 24 * 60 * 60;
//on vérifie que le visiteur a correctement envoyé le formulaire
if (isset($_POST['inscription'])) {
    //on teste l'existence des variables et on vérifie qu'elle ne sont pas vides
    if (
        (isset($_POST['email']) && !empty($_POST['email'])) && (isset($_POST['mdp1']) && !empty($_POST['mdp1']))
        && (isset($_POST['mdp2']) && !empty($_POST['mdp2']))
    ) {
        //si les variables existent, on vérifie que les deux mots de passe sont différents
        if (!$conn->connect_errno) {
            $email = $conn->real_escape_string(strip_tags($_POST['email'], ENT_QUOTES));
            $prenom = $conn->real_escape_string(strip_tags($_POST['prenom'], ENT_QUOTES));
            $nom = $conn->real_escape_string(strip_tags($_POST['nom'], ENT_QUOTES));
            $password = $conn->real_escape_string(strip_tags($_POST['mdp1'], ENT_QUOTES));
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $code_verification = substr(md5(uniqid(rand(), true)), 16, 16);
            $activation_expiry = date('Y-m-d H:i:s', time() + $expiry);

            $sql = "SELECT * FROM chef WHERE email = '" . $email . "';";
            $query_check_email = $conn->query($sql);
            if ($query_check_email->num_rows == 1) {
                $errors[] = "Nous sommes désolés, cette adresse email est déjà utilisée.";
            } else {
                $sql = "INSERT INTO chef (email, password, prenom, nom, code_verification, activation_expiry)
            VALUES('" . $email . "', '" . $password_hash . "', '" . $prenom . "', '" . $nom . "','" . $code_verification . "', '" . $activation_expiry . "');";
                $query_new_user_insert = $conn->query($sql);
                if ($query_new_user_insert) {
                    include("../send_mail.php");
                    $sql = "SELECT * FROM chef WHERE email = '" . $email . "';";
                    $result_of_login_check = $conn->query($sql);
                    if ($result_of_login_check->num_rows == 1) {
                        $result_row = $result_of_login_check->fetch_object();
                        $lien_activation = "127.0.0.1/Better-Labor/espace-membres/activate.php?code_verification=$code_verification&email=$email";
                        $messages[] = 'Votre compte a bien été créé';
                        if (sendmail($conn, $result_row, 'Confirmez votre email', 'Veuillez cliquer <a href="' . $lien_activation . '">ici</a> pour confirmer votre email et activer votre compte.')) {
                            $messages[] ='Nous vous avons envoyé un mail de confirmation pour confirmer votre compte.';
                        }
                        else {
                            $errors[] = "Le mail d'activation de compte n'a pas pu être envoyé.";
                        }
                    } else {
                        $errors[] = "Nous sommes désolés, votre inscription a echoué. Veuillez réessayer.";
                    }
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel = "stylesheet" href = "inscription.css"/>
    <link rel = "stylesheet" href = "../general.css"/>
    <title>BetterLabor</title>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img class="better" src="../logo.jpg">
        </div>

        <div class="title"><b>Vos informations personnelles</b></div>

        <div class="inputs">
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
        if (isset($_GET["message"]) && $_GET["message"] == "expired") {
            echo('<div class="bar success">
            <i class="ico">&#9747;</i>' . "Ce lien d'activation a expiré! Veuillez vous inscrire à nouveau. " . '</div>');
        }

        ?>
            <form action="" method="post" id="inscription">
                <input type="text" placeholder="Votre nom" name="nom" required>
                <br> 
                <input type="text" placeholder="Votre prenom" name="prenom" required>
                <br>
                <input type="text" placeholder="Adresse e-mail" name="email" required>
                <br>
                <input type="password" placeholder="Saisir votre mot de passe" name="mdp1" required>
                <br>
                <input type="password" placeholder="Entrez à nouveau le mot de passe" name="mdp2" required>
                <br>
                <button type="submit" name="inscription"><b>S'inscrire</b></button>
            </form>
            <a class="link" href="connexion.php">Se connecter</a>
        </div>
    </div>
</body>
</html>