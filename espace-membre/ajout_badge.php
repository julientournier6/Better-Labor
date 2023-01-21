<!DOCTYPE html>
<html>
<?php
session_start();
include('../database/config.php');
include('../database/tools.php');
if (isset($_POST['score'])) {
    $score = $_POST['score'];
    echo "<script>console.log('Debug Objects: ' );</script>";
    if ($score >= 8) { $badge = 4;}
    else if ($score >= 6) {$badge = 3;}
    else if ($score >= 4) {$badge = 2;}
    else if ($score >= 2) {$badge = 1;}
    $role = $_SESSION["role"];
    if (isset($badge) && $role != "admin") {
        $id = $_SESSION["ID"];
        //Pas besoin de requêtes préparées car plus d'input utilisateur à ce niveau là
        $query = $conn->query("UPDATE $role SET badge = $badge WHERE ID = $id");
        $_SESSION["badge"] = $badge;
    }
}
?>
</html>