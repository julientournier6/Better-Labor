<?php

class Registration
{
    private $conn = null;
    public $errors = array();
    public $messages = array();
    public function __construct()
    {
        if (isset($_POST["register"])) {
            $this->registerNewUser();
        }
    }

    private function registerNewUser()
    {
        if (empty($_POST['password_new']) || empty($_POST['password_repeat'])) {
            $this->errors[] = "Empty Password";
        } elseif ($_POST['password_new'] !== $_POST['password_repeat']) {
            $this->errors[] = "Password and password repeat are not the same";
        } elseif (strlen($_POST['password_new']) < 6) {
            $this->errors[] = "Password has a minimum length of 6 characters";
        }  elseif (empty($_POST['email'])) {
            $this->errors[] = "Email cannot be empty";
        } elseif (empty($_POST['firstname'])) {
            $this->errors[] = "First Name cannot be empty";
        } elseif (empty($_POST['lastname'])) {
            $this->errors[] = "Last Name cannot be empty";
        } elseif (strlen($_POST['email']) > 64) {
            $this->errors[] = "Email cannot be longer than 64 characters";
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Your email address is not in a valid email format";
        } elseif (!empty($_POST['email'])
            && strlen($_POST['email']) <= 64
            && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
            && !empty($_POST['password_new'])
            && !empty($_POST['password_repeat'])
            && ($_POST['password_new'] === $_POST['password_repeat'])
        ) {
            include("config.php");
            $this->conn = $conn;

            if (!$this->conn->connect_errno) {

                $email = $this->conn->real_escape_string(strip_tags($_POST['email'], ENT_QUOTES));
                $firstname = $this->conn->real_escape_string(strip_tags($_POST['firstname'], ENT_QUOTES));
                $lastname = $this->conn->real_escape_string(strip_tags($_POST['lastname'], ENT_QUOTES));
                $password = $_POST['password_new'];
                $subscribed = 0;
                if (isset($_POST['subscribed'])) $subscribed = 1;

                $password_hash = password_hash($password, PASSWORD_DEFAULT);

                $sql = "SELECT * FROM user WHERE email = '" . $email . "';";
                $query_check_email = $this->conn->query($sql);

                if ($query_check_email->num_rows == 1) {
                    $this->errors[] = "Sorry, that email address is already taken.";
                } else {
                    $sql = "INSERT INTO user (email, password, firstname, lastname, subscribed)
                            VALUES('" . $email . "', '" . $password_hash . "', '" . $firstname . "', '" . $lastname . "','" . $subscribed . "');";
                    $query_new_user_insert = $this->conn->query($sql);

                    if ($query_new_user_insert) {
                        $this->messages[] = 'Your account has been created successfully. You can now <nobr><a href="profile.php">Log in</a></nobr>';
                    } else {
                        $this->errors[] = "Sorry, your registration failed. Please try again.";
                    }
                }
            } else {
                $this->errors[] = "Sorry, no database connection.";
            }
        } else {
            $this->errors[] = "An unknown error occurred.";
        }
    }
}
