<?php
function editProfile($conn, $row, $own)
{
    //On définit les variables de celui dont le profil va être modifié
    $role = $row["role"];
    $id = $row["ID"];
    $errors = array();
    $messages = array();
    $email = $conn->real_escape_string(strip_tags($_POST['email'], ENT_QUOTES));
    $prenom = $conn->real_escape_string(strip_tags($_POST['prenom'], ENT_QUOTES));
    $nom = $conn->real_escape_string(strip_tags($_POST['nom'], ENT_QUOTES));
    $password = $conn->real_escape_string(strip_tags($_POST['password'], ENT_QUOTES));

    // On définit les informations de celui qui tente de modifier un profil
    if ($own) {
        $edit_role = $role;
        $edit_id = $id;
    }
    else {
        $edit_role = $_SESSION['role'];
        $edit_id = $_SESSION['ID'];
    }

    //On  vérifie que le nouvel email du profil à modifier ne correspond pas déjà à un email dans la BDD
    $stmt = $conn->prepare("SELECT * FROM $role WHERE email = ? AND ID != ?");
    $stmt->bind_param('ss', $email, $id);
    if (!$stmt->execute()) {
        $errors[] = "Problème de communication avec le serveur. Veuillez réessayer";
        return array($errors, $messages);
    }
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $errors[] = "Nous sommes désolés, cette adresse email est déjà utilisée.";
        return array($errors, $messages);
    }

    //On sélectionne l'utilsateur qui souhaite modifier pour ensuite vérifier son mot de passe
    $stmt = $conn->prepare("SELECT * FROM $edit_role WHERE ID = ?");
    $stmt->bind_param('s', $edit_id);
    if (!$stmt->execute()) {
        $errors[] = "Problème de communication avec le serveur. Veuillez réessayer";
        return array($errors, $messages);
    }
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $result_row = $result->fetch_object();
        if (password_verify($password, $result_row->password)) {
            if (($role) == "utilisateur") {
                $telephone = $conn->real_escape_string(strip_tags($_POST['telephone'], ENT_QUOTES));
                // $date_naissance = $conn->real_escape_string(strip_tags($_POST['date_naissance'], ENT_QUOTES));
                // $genre = $conn->real_escape_string(strip_tags($_POST['genre'], ENT_QUOTES));
                $stmt = $conn->prepare("UPDATE $role SET email = ?, prenom = ?, nom = ?, telephone = ? WHERE ID = ?");
                $stmt->bind_param('sssss', $email, $prenom, $nom, $telephone, $id);
            } else {
                $stmt = $conn->prepare("UPDATE $role SET email = ?, prenom = ?, nom = ? WHERE ID = ?");
                $stmt->bind_param('ssss', $email, $prenom, $nom, $id);
            }
            if ($stmt->execute()) {
                if ($own) { $start = "Votre ";}
                else {$start = "Le ";}
                $messages[] = $start . "compte a bien été modifié.";
                //On actualise les informations de la session dans le cas où l'utilisateur modifie son propre profil
                if ($own) {
                    $_SESSION['prenom'] = $prenom;
                    $_SESSION['nom'] = $nom;
                    $_SESSION['email'] = $email;
                    if (($role) == "utilisateur") {
                        $_SESSION['telephone'] = $telephone;
                    }
                }
            } else {
                $errors[] = "Erreur de communication avec la base de données.";
            }
        } else {
            $errors[] = "Le mot de passe est incorrect.";
        }
    } else {
        $errors[] = "Nous n'avons pas pu trouver ce compte.";
    }
    return array($errors, $messages);
}

?>