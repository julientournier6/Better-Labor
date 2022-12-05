<?php
session_start();
include("../database/config.php");
if (isset($_GET["code_verification"]) && isset($_GET["email"])) {
    $sql = "SELECT * FROM chef WHERE email = '" . $_GET["email"] . "';";
    $result_of_login_check = $conn->query($sql);
    if ($result_of_login_check->num_rows == 1) {
        $result_row = $result_of_login_check->fetch_object();
        if (($result_row->email == $_GET["email"]) && ($result_row->code_verification == $_GET["code_verification"])) {
            if ($result_row->activation_expiry > date('Y-m-d H:i:s')) {
                include("tools.php");
                connect($result_row);
                redirect("espace-membre.php?message=activated");
            }
            else {
                redirect("inscription.php?message=expired");
            }
        }
        else {
            echo "lol";
        }
    }
    else {
        echo "lool";
    }
}
?>