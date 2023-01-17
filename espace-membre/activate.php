<?php
session_start();
include("../database/config.php");
include("../database/tools.php");

//Page vers laquelle redirigent les liens d'activation de compte
//Le lien d'activation est accompagné d'attributs GET qui donnent les informations nécessaires à l'activation
if (isset($_GET["code_verification"]) && isset($_GET["email"]) && isset($_GET["role"])) {
    $role = $_GET["role"];
    $sql = "SELECT * FROM $role WHERE email = '" . $_GET["email"] . "';";
    $result_of_login_check = $conn->query($sql);
    if ($result_of_login_check->num_rows == 1) {
        $result_row = $result_of_login_check->fetch_object();
        if (($result_row->email == $_GET["email"]) && ($result_row->code_verification == $_GET["code_verification"])) {
            if (!isset($_GET["reinitialisation_mdp"])) {
                if ($result_row->activation_expiry > date('Y-m-d H:i:s')) {
                    $id = $result_row->id;
                    //On active le compte:
                    $sql = "UPDATE $role SET activated = 1 WHERE ID = '$id'";
                    $query_activate = $conn->query($sql);
                    if ($query_activate) {
                        connect($result_row, $role);
                        redirect_role($role, "index.php?message=activated");
                    } else {
                        redirect_role($role, "index.php?message=error");
                    }
                }
                else {
                    redirect_role($role, "inscription.php?message=activated");
                }
            }
            else {
                connect($result_row, $role);
                redirect("changement_mdp.php?reinitialisation=1");
            }
        }
        else {
            redirect_role($role, "inscription.php?message=invalid");
        }
    }
    else {
        redirect_role($role, "inscription.php?message=invalid");
    }
}
?>