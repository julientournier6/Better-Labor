<?php
function connect($row) {
    $_SESSION['loggedin'] = 1;
    $_SESSION['id'] = $row->id;
    $_SESSION['email'] = $row->email;
    $_SESSION['prenom'] = $row->prenom;
    $_SESSION['nom'] = $row->nom;
}
?>