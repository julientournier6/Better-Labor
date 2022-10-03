<?php include("nav.php");?>
<?php
if (isset($registration)) {
    if ($registration->errors) {
        foreach ($registration->errors as $error) {
            echo('<p class="error">' . $error . '</p>');
        }
    }
    if ($registration->messages) {
        foreach ($registration->messages as $message) {
            echo('<p class="error">' . $message . '</p>');
        }
    }
}
?>

<div class="center">
<div class="regcontainer">
<form class="table" method="post" action="register.php" name="registerform">
    <div class="table-row">
    <label class="table-cell" for="login_input_email">Email</label>
    <input id="login_input_email"  type="email" name="email" placeholder = "example@domain.com" required />
    </div>

    <div class="table-row">
    <label class="table-cell"for="login_input_username">First Name</label>
    <input id="login_input_username" class="table-cell" type="text" pattern="^[A-Za-z]+(\s[A-Za-z]+){0,2}$" name="firstname" placeholder = "John"required />
    </div>

    <div class="table-row">
    <label class="table-cell"for="login_input_username">Last Name</label>
    <input id="login_input_username" class="table-cell" type="text" pattern="^[A-Za-z]+(\s[A-Za-z]+){0,2}$" name="lastname" placeholder = "Smith"required />
    </div>

    <div class="table-row">
    <label class="table-cell"for="login_input_password_new">Password (min. 6 characters)</label>
    <input id="login_input_password_new" class="table-cell" type="password" name="password_new" pattern=".{6,}" required autocomplete="off" placeholder = "password"/>
    </div>

    <div class="table-row">
    <label class="table-cell"for="login_input_password_repeat">Repeat password</label>
    <input id="login_input_password_repeat" class="table-cell" type="password" name="password_repeat" pattern=".{6,}" required autocomplete="off" placeholder = "password"/>
    </div>

    <div class="table-row">
    <label class="table-cell" for="subscribed"> Subscribe to our newsletter</label>
    <input class="table-cell" type="checkbox" id="subscribed" name="subscribed" value="true" checked>
    </div>

    <div class="table-row">
    <label class="table-cell"></label>
    <input class="table-row" type="submit"  name="register" value="Register" >
    </div>
</form>
</div>
<br>
<a class="backto" href="profile.php">Back to Login Page</a>
</div>
</body>
</html>