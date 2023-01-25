<?php
//Fichier pour le système de connexion avec des fonctions outils et les fonctions d'inscription / connexion

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

//On veut déterminer l'adresse de base du serveur pour pouvoir envoyer un lien d'activation
//car l'adresse n'est pas la même pour tout le monde
function get_base_url() {
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
        $start = "https://";
    }
    else {
        $start = "http://";
    }
    $url = $start . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];//on prend d'abord l'adresse actuelle
    $url = explode("espace", $url)[0];//on enlève la partie en trop"
    return $url;
}
function show_sidebar($role) {
    include('../espace-' . $role . '/sidebar.php');
}
?>