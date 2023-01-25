<?php
function sign_up($conn, $role) {
    //Fonction d'inscription
    $errors = array();
    $messages = array();
    $expiry = 1 * 24 * 60 * 60;
    //on vérifie que le visiteur a correctement envoyé le formulaire
    if (isset($_POST['inscription'])) {
        //on teste l'existence des variables et on vérifie qu'elle ne sont pas vides
        if (
            isset($_POST['email']) && !empty($_POST['email']) &&
            !($role != "utilisateur" && (!isset($_POST['mdp1']) || empty($_POST['mdp1'])
            || !isset($_POST['mdp2']) || empty($_POST['mdp2']))))
            {
            if (!$conn->connect_errno) {
                $email = $conn->real_escape_string(strip_tags($_POST['email'], ENT_QUOTES));
                $prenom = $conn->real_escape_string(strip_tags($_POST['prenom'], ENT_QUOTES));
                $nom = $conn->real_escape_string(strip_tags($_POST['nom'], ENT_QUOTES));
                if ($role != 'utilisateur') {
                    $password = $conn->real_escape_string(strip_tags($_POST['mdp1'], ENT_QUOTES));
                }
                else {
                    $password = substr(md5(uniqid(rand(), true)), 12, 12);
                }
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $code_verification = substr(md5(uniqid(rand(), true)), 16, 16);
                $activation_expiry = date('Y-m-d H:i:s', time() + $expiry);
                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                //On vérifie que le compte n'est pas déjà utilisé:
                if (count_rows_where($conn, $role, "email", $email) > 0) {
                    $errors[] = "Nous sommes désolés, cette adresse email est déjà utilisée.";
                    return array($errors, $messages);
                }
                else {
                    //Comme l'interface de connexion est la même pour les chefs et employés, on vérifie l'autre table également
                    if ($role == 'utilisateur' && count_rows_where($conn, 'chef', "email", $email) > 0) {
                        $errors[] = "Nous sommes désolés, cette adresse email est déjà utilisée.";
                        return array($errors, $messages);
                    }
                    
                    if ($role == 'chef' && (count_rows_where($conn, 'utilisateur', "email", $email) > 0)) {
                        $errors[] = "Nous sommes désolés, cette adresse email est déjà utilisée.";
                        return array($errors, $messages);
                    }
                }
                //On prépare les statements SQL en fonction du rôle et donc des inputs donnés:
                if ($role == 'utilisateur') {
                    $telephone = $conn->real_escape_string(strip_tags($_POST['telephone'], ENT_QUOTES));
                    $date_naissance = $conn->real_escape_string(strip_tags($_POST['date_naissance'], ENT_QUOTES));
                    $date_today = new DateTime();
                    $interval = date_create_from_format("Y-m-d", $date_naissance)->diff($date_today);
                    $years = $interval->y;
                    if ($years < 18) {
                        $errors[] = "Votre employé doit avoir plus de 18 ans";
                        return array($errors, $messages);       
                    }
                    $genre = $_POST['genre'];
                    $stmt = $conn->prepare("INSERT INTO $role (email, id_chef, password, prenom, nom, telephone, date_naissance, genre)
                    VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param('ssssssss', $email, $_SESSION['ID'], $password_hash, $prenom, $nom, $telephone, $date_naissance, $genre);
                }
                else if ($role == 'admin') {
                    $code_admin = $conn->real_escape_string(strip_tags($_POST['code'], ENT_QUOTES));
                    $stmt = $conn->prepare("SELECT * FROM code_admin WHERE code = ? AND valide = 1");
                    $stmt->bind_param('s', $code_admin);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if (!$result->num_rows) {
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
                //On exécute le code càd on inscrit le compte
                if ($stmt->execute()) {
                    include("../send_mail.php");
                    //On sélectionne le compte pour pouvoir envoyer un mail de confirmation
                    $stmt = $conn->prepare("SELECT * FROM $role WHERE email = ?");
                    $stmt->bind_param('s', $email);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows == 1) {
                        $result_row = $result->fetch_object();
                        if ($role == 'admin' || $role == 'chef') {
                            $url = get_base_url();
                            //On remplace le + par son équivalent pour les requêtes GET
                            $email = str_replace("+", "%2B", $email);
                            $lien_activation = $url . "espace-membre/activate.php?code_verification=$code_verification&email=$email&role=$role";
                            $messages[] = 'Votre compte a bien été créé';
                            if ($role == 'admin') {
                                $stmt = $conn->prepare("UPDATE code_admin SET valide = 0 WHERE code = ?");
                                $stmt->bind_param('s', $code_admin);
                                $stmt->execute();
                            }
                            if (sendmail($conn, $result_row, 'Confirmez votre email', 'Veuillez cliquer <a href="' . $lien_activation . '">ici</a> pour confirmer votre email et activer votre compte.')) {
                                $messages[] ='Nous vous avons envoyé un mail de confirmation pour confirmer votre compte.';
                            }
                            else {
                                $errors[] = "Le mail d'activation de compte n'a pas pu être envoyé.";
                            }
                        }
                        else {
                            $messages[] = "L'employé a bien été ajouté";
                            $lien = "127.0.0.1/BetterLabor/Better-Labor/espace-membre/connexion.php";
                            if (sendmail($conn, $result_row, 'Votre compte Better Labor', 'Vous êtes inscrit à notre plateforme. Voici vos identifiants:
                                <br>Email : ' . $email . 
                                '<br>Mot de passe : ' . $password . 
                                '<br><br>Veuillez cliquer <a href="' . $lien . '">ici</a> pour vous connecter. 
                                <br>Vous pouvez ensuite changer votre mot de passe.')) {
                                $messages[] = "Un mail a été envoyé à l'employé avec son mot de passe.";
                            }
                            else {
                                $errors[] = "Le mail de création de compte n'a pas pu être envoyé à votre employé.";
                            }
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
?>