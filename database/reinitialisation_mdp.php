<?php
if (isset($_POST["reinitialisation_mdp"])) {
  if(isset($_POST["email"])) {
    if(empty(trim($_POST["email"]))) {
        $errors[] = "Veuillez entrer un mail";     
    } else {
        $email = trim($_POST["email"]);
        $role = $_POST['role'];
        $sql = "SELECT * FROM $role WHERE email = '" . $email . "';";
        $query_check_email = $conn->query($sql);
        if ($sql && $query_check_email->num_rows == 1) {
          $row = $query_check_email->fetch_object();
          include("../send_mail.php");
          $code_verification = substr(md5(uniqid(rand(), true)), 16, 16);
          $sql = "UPDATE $role SET code_verification = '$code_verification' WHERE email = '$email'";
          $query_update_code = $conn->query($sql);
          if ($query_update_code) {
            $url = get_base_url();
            $lien_activation = $url . "espace-membre/activate.php?code_verification=$code_verification&email=$email&reinitialisation_mdp=1&role=$role";
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