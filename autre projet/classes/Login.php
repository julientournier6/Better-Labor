<?php
class Login
{
    private $conn = null;
    public $errors = array();
    public $messages = array();

    public function __construct()
    {
        session_start();
        if (isset($_GET["logout"])) {
            $this->doLogout();
        }
        elseif (isset($_POST["login"])) {
            $this->dologinWithPostData();
        }
    }
    private function dologinWithPostData()
    {
        if (empty($_POST['email'])) {
            $this->errors[] = "Email field was empty.";
        } elseif (empty($_POST['password'])) {
            $this->errors[] = "Password field was empty.";
        } elseif (!empty($_POST['email']) && !empty($_POST['password'])) {
            include("config.php");
            $this->conn = $conn;
            if (!$this->conn->connect_errno) {
                $email = $this->conn->real_escape_string($_POST['email']);
                $sql = "SELECT * FROM user WHERE email = '" . $email . "';";
                $result_of_login_check = $this->conn->query($sql);
                if ($result_of_login_check->num_rows == 1) {
                    $result_row = $result_of_login_check->fetch_object();
                    if (password_verify($_POST['password'], $result_row->password)) {
                        $_SESSION['id'] = $result_row->id;
                        $_SESSION['email'] = $result_row->email;
                        $_SESSION['firstname'] = $result_row->firstname;
                        $_SESSION['lastname'] = $result_row->lastname;
                        $_SESSION['admin'] = $result_row->admin;
                        $_SESSION['loggedin'] = 1;
                        $_SESSION['subscribed'] = $result_row->subscribed;
                    } else {
                        $this->errors[] = "Wrong password. Try again.";
                    }
                } else {
                    $this->errors[] = "This user does not exist.";
                }
            } else {
                $this->errors[] = "Database connection problem.";
            }
        }
    }
    public function doLogout()
    {
        $_SESSION = array();
        session_destroy();
        $this->messages[] = "You have been logged out.";
    }
    
    public function isUserLoggedIn()
    {
        if (isset($_SESSION['loggedin']) AND $_SESSION['loggedin'] == 1) {
            return true;
        }
        return false;
    }
}
