<?php
//Fichier pour le système de connexion avec des fonctions outils et les fonctions d'inscription / connexion
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

function redirect_role($role, $page) {
    //Fonction outil qui permet de générer un lien vers l'espace correspondant au rôle de l'utilisateur
    $root = '..';
    if ($role == "utilisateur") {
        $lien =  $root . '/espace-utilisateur/';
    }
    else if ($role == "admin") {
        $lien = $root . '/espace-admin/';
    }
    else if ($role == 'chef') {
        $lien = $root . '/espace-chef/';
    }
    redirect($lien . $page);
}

function count_rows($conn, $table) {
    $sql = "SELECT COUNT(*) AS count FROM $table";
    $result = $conn->query($sql);
    $result_row = $result->fetch_array();
    $count = $result_row['count'];
    return $count;
}

function count_rows_where($conn, $table, $column, $value) {
    $stmt = $conn->prepare("SELECT * FROM $table WHERE $column = ?");
    $stmt->bind_param('s', $value);
    $stmt->execute();
    $result = $stmt->get_result();
    return ($result->num_rows);
}
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

//On veut déterminer l'adresse de base du serveur pour pouvoir envoyer un lien d'activation
//car l'adresse n'est pas la même pour tout le monde
function get_base_url() {
    *st
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https' : 'http' . $_SERVER['SERVER_NAME'] . "://" . $_SERVER['REQUEST_URI'];//on prend d'abord l'adresse actuelle
    $url = explode("espace", $url)[0];//on enlève la partie en trop"
    return $url;
}
function show_sidebar($role) {
    include('../espace-' . $role . '/sidebar.php');
}
?>