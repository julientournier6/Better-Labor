<?php
include_once('../database/tools.php');
function connect($row, $role) {
    //Fonction qui doit être appelée à la fin du processus du connexion (définit les variables de session)
    $_SESSION['loggedin'] = 1;
    $_SESSION['ID'] = $row->ID;
    $_SESSION['email'] = $row->email;
    $_SESSION['prenom'] = $row->prenom;
    $_SESSION['nom'] = $row->nom;
    $_SESSION['role'] = $role;
    if ($role == 'utilisateur') {
        $_SESSION['genre'] = $row->genre;
        $_SESSION['date_naissance'] = $row->date_naissance;
        $_SESSION['telephone'] = $row->telephone;
    }
    if ($role == 'utilisateur' || $role == 'chef') {
        $_SESSION['badge'] = $row->badge;
    }
}

function sign_in($conn, $admin) {
    if ($admin) {
        return specific_sign_in($conn, "admin");
    }
    else {
        list($errors, $messages) = specific_sign_in($conn, "chef");
        if (in_array("Ce mail ne correspond à aucun compte.", $errors)) {
            return specific_sign_in($conn, "utilisateur");
        }
        return (array($errors, $messages));
    }
}
function specific_sign_in($conn, $role) {
    $errors = array();
    $messages = array();
    if (isset($_POST['connexion'])) {
        if ((isset($_POST['email']) && !empty($_POST['email'])) && (isset($_POST['password']) && !empty($_POST['password']))) {
            if (!$conn->connect_errno) {
                $email = $conn->real_escape_string($_POST['email']);
                $stmt = $conn->prepare("SELECT * FROM $role WHERE email = ?");
                $stmt->bind_param('s', $email);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows == 1) {
                    $result_row = $result->fetch_object();
                    if (password_verify($_POST['password'], $result_row->password)) {
                        connect($result_row, $role);
                        redirect_role($role, 'index.php');
                    } 
                    else {
                        $errors[] = "Mauvais mot de passe. Veuillez réessayer.";
                    }
                } 
                else if ($result->num_rows == 0){
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
        else {
            $errors[] = "Veuillez saisir votre mail et votre mot de passe.";
        }
     }
    return array($errors, $messages);
}

?>