<div class="center">
<?php
if (isset($login)) {
    if ($login->errors) {
        foreach ($login->errors as $error) {
            echo('<p class="error">' . $error . '</p>');
        }
    }
    if ($login->messages) {
        foreach ($login->messages as $message) {
            echo('<p class="error">' . $message . '</p>');
        }
    }
}
?>
<div class="logcontainer">
<form class="table" method="post" action="profile.php" name="loginform">

    <div class="table-row">
    <label class="table-cell"for="login_input_email">Email</label>
    <input id="login_input_username" class="table-cell" type="email" name="email" placeholder = "example@domain.com" required />
    </div>

    <div class="table-row">
    <label class="table-cell" for="login_input_password">Password</label>
    <input class="table-cell" id="login_input_password" type="password" name="password" autocomplete="off" placeholder = "password" required />
    </div>

    <div class="table-row">
    <label class="table-cell"></label>
    <input type="submit" class="table-cell" name="login" value="Log in" class = "confirm" />
    </div>

</form>
</div>
<br>
<a href="register.php" class = "link">Register new account</a>
</div>
</body>
</html>
