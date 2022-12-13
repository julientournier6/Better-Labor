<?php
function editProfile($conn, $id, $role) {
    $errors = array();
    $messages = array();
    $email = $conn->real_escape_string(strip_tags($_POST['email'], ENT_QUOTES));
    $prenom = $conn->real_escape_string(strip_tags($_POST['prenom'], ENT_QUOTES));
    $nom = $conn->real_escape_string(strip_tags($_POST['nom'], ENT_QUOTES));
    if (($role) == "utilisateur") {
        $telephone = $conn->real_escape_string(strip_tags($_POST['telephone'], ENT_QUOTES));
        $date_naissance = $conn->real_escape_string(strip_tags($_POST['date_naissance'], ENT_QUOTES));
        $genre = $conn->real_escape_string(strip_tags($_POST['genre'], ENT_QUOTES));
        $stmt = $conn->prepare("UPDATE $role SET email = ?, prenom = ?, nom = ?, telephone = ?, date_naissance = ?, genre = ? WHERE ID = '$id'");
        $stmt->bind_param('sss', $email, $prenom, $nom, $telephone, $date_naissance, $genre);
    }
    else {
        $stmt = $conn->prepare("UPDATE $role SET email = ?, prenom = ?, nom = ? WHERE ID = '$id'");
        $stmt->bind_param('ssssss', $email, $prenom, $nom);
    }
    if ($stmt->execute()) {
        $messages[] = "Votre compte a bien été modifié.";
    }
    else {
        $errors[] = "Erreur de communication avec la base de données.";
    }
    return array($errors, $messages);
}
?>