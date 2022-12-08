<?php
function connect($row, $role) {
    $_SESSION['loggedin'] = 1;
    $_SESSION['id'] = $row->ID;
    $_SESSION['email'] = $row->email;
    $_SESSION['prenom'] = $row->prenom;
    $_SESSION['nom'] = $row->nom;
    $_SESSION['role'] = $role;
}
?>