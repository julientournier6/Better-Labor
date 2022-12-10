<?php
function connect($row, $role) {
    $_SESSION['loggedin'] = 1;
    $_SESSION['id'] = $row->ID;
    $_SESSION['email'] = $row->email;
    $_SESSION['prenom'] = $row->prenom;
    $_SESSION['nom'] = $row->nom;
    $_SESSION['role'] = $role;
}

function count_rows($conn, $table) {
    $sql = "SELECT COUNT(*) AS count FROM $table";
    $result = $conn->query($sql);
    $result_row = $result->fetch_array();
    $count = $result_row['count'];
    return "$count chefs";
}

function count_rows_where($conn, $table, $column, $value) {
    $stmt = $conn->prepare("SELECT * FROM $table WHERE $column = ?");
    $stmt->bind_param('s', $value);
    $stmt->execute();
    $result = $stmt->get_result();
    return ($result->num_rows);
}
function sign_up($conn, $role) {
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
            if (!$conn->connect_errno) {
                $email = $conn->real_escape_string(strip_tags($_POST['email'], ENT_QUOTES));
                $prenom = $conn->real_escape_string(strip_tags($_POST['prenom'], ENT_QUOTES));
                $nom = $conn->real_escape_string(strip_tags($_POST['nom'], ENT_QUOTES));
                $password = $conn->real_escape_string(strip_tags($_POST['mdp1'], ENT_QUOTES));
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $code_verification = substr(md5(uniqid(rand(), true)), 16, 16);
                $activation_expiry = date('Y-m-d H:i:s', time() + $expiry);
                if (count_rows_where($conn, $role, "email", $email) > 0) {
                    $errors[] = "Nous sommes désolés, cette adresse email est déjà utilisée.";
                    return array($errors, $messages);
                }
                if ($role == 'utilisateur') {
                    $telephone = $conn->real_escape_string(strip_tags($_POST['telephone'], ENT_QUOTES));
                    $date_naissance = $conn->real_escape_string(strip_tags($_POST['telephone'], ENT_QUOTES));
                    $genre = $_POST['genre'];
                    $stmt = $conn->prepare("INSERT INTO $role (email, password, prenom, nom, code_verification, activation_expiry, telephone, date_naissance, genre)
                    VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param('ssssss', $email, $password_hash, $prenom, $nom, $code_verification, $activation_expiry, $telephone, $date_naissance, $genre);
                }
                else if ($role == 'admin') {
                    $code_admin = $conn->real_escape_string(strip_tags($_POST['code'], ENT_QUOTES));
                    if (count_rows_where($conn, "code_admin", "code", $code_admin) == 0) {
                        $errors[] = "Ce code est invalide";
                        return array($errors, $messages);
                    }
                    $stmt = $conn->prepare("INSERT INTO $role (email, password, prenom, nom, code_verification, activation_expiry)
                    VALUES(?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param('ssssss', $email, $password_hash, $prenom, $nom, $code_verification, $activation_expiry);
                }
                else if ($role == 'chef') {
                    $stmt = $conn->prepare("INSERT INTO $role (email, password, prenom, nom, code_verification, activation_expiry)
                    VALUES(?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param('ssssss', $email, $password_hash, $prenom, $nom, $code_verification, $activation_expiry);
                }
                else {
                    $errors[] = "Erreur : votre rôle n'a pas été défini. Essayez de vous déconnecter puis de vous reconnecter.";
                    return array($errors, $messages);
                }
                if ($stmt->execute()) {
                    include("../send_mail.php");
                    $stmt = $conn->prepare("SELECT * FROM $role WHERE email = ?");
                    $stmt->bind_param('s', $email);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows == 1) {
                        $result_row = $result->fetch_object();
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
                else {
                    $errors[] = "Nous sommes désolés, votre inscription a echoué en raison d'une erreur de communication avec notre serveur";
                }
            }
            else {
                $errors[] = "Erreur de connexion avec la base de données.";
            }
        }
    }
    return array($errors, $messages);
}

function sign_in($conn, $role) {
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
                         include("../database/tools.php");
                         connect($result_row, "chef");
                         redirect("index.php");
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