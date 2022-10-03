<!DOCTYPE html>
<?php
session_start();
include("nav.php");
if (isset($_SESSION['loggedin']) AND $_SESSION['loggedin'] == 1)
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != 1 || !isset($_SESSION["id"])){
    redirect("profile.php");
}

$new_password = $confirm_password = "";
$messages = array();
 
if(isset($_POST["resetpassword"])) {
    if(empty(trim($_POST["new_password"]))) {
        $messages[] = "Please enter the new password.";     
    } else if(strlen(trim($_POST["new_password"])) < 6) {
        $messages[] = "Password must have atleast 6 characters.";
    } else if (empty(trim($_POST["confirm_password"]))) {
        $messages[] = "Please confirm the password.";
    }else {
        $new_password = $_POST["new_password"];
        $confirm_password = $_POST["confirm_password"];
        if ($new_password != $confirm_password) {
            $messages[] = "Password did not match.";
        } else {
            $password = password_hash($new_password, PASSWORD_DEFAULT);
            $id = $_SESSION["id"];
            $sql = "UPDATE user SET password = '$password' WHERE id = '$id'";
            $query_update_password = $conn->query($sql);
            if ($query_update_password) {
                $messages[] = "Password was updated!";
            } else {
                $messages[] = "Sorry, we could not update the password";
            }
        }
    }
}
?>
<div class="center">
<?php 
if ($messages) {
        foreach ($messages as $error) {
            echo('<p class="error">' . $error . '</p>');
        }
    }
?>

    <div class="regcontainer">
        <form class="table" action="" method="post"> 
            <div class="table-row">
                <label class="table-cell">New Password</label>
                <input type="password" name="new_password" class="table-cell" required>
            </div>
            <div class="table-row">
                <label class="table-cell">Confirm Password</label>
                <input type="password" name="confirm_password" class="table-cell" required>
            </div>
            <div class="table-row">
                <label class="table-cell"></label>
                <input type="submit" name="resetpassword" class="table-cell" value="Reset password">
            </div>
        </form>
    </div>   
    <br>
    <a class="link" href="profile.php">Cancel</a>
</div> 
</body>
</html>