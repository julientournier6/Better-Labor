<?php
session_start();
include("../database/config.php");
if (isset($_GET["code_verification"]) && isset($_GET["email"])) {
        $sql = "SELECT * FROM chef WHERE email = '" . $_GET["email"] . "';";
        $result_of_login_check = $conn->query($sql);
        if ($result_of_login_check->num_rows == 1) {
            $result_row = $result_of_login_check->fetch_object();
            if (($result_row->email == $_GET["email"]) && ($result_row->code_verification == $_GET["code_verification"])) {
                if (!isset($_GET["reinitialisation_mdp"])) {
                    if ($result_row->activation_expiry > date('Y-m-d H:i:s')) {
                        $id = $result_row->id;
                        $sql = "UPDATE chef SET activated = 1 WHERE ID = '$id'";
                        $query_activate = $conn->query($sql);
                        if ($query_activate) {
                            include("tools.php");
                            connect($result_row, 'chef');
                            redirect("index.php?message=activated");
                        } else {
                            redirect("inscription.php?message=error");
                        }
                    }
                    else {
                        redirect("inscription.php?message=expired");
                    }
                }
                else {
                    include("tools.php");
                    connect($result_row, 'chef');
                    redirect("changement_mdp.php?reinitialisation=1");
                }
            }
            else {
                redirect("inscription.php?message=invalid");
            }
        }
        else {
            redirect("inscription.php?message=invalid");
        }
    }
?>