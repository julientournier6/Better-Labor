<div class="center">
<br>
<p class="bigtext">Hey, <?php echo $_SESSION['firstname'] . " ". $_SESSION['lastname']; ?>. You are logged in .</p>

<div>
<a class="link" href="profile.php?logout">Logout</a>
</div>
<br>
<div>
<a class="link" href="resetpassword.php">Reset password</a>
</div>
<br>
<?php if(isset($_SESSION['admin']) AND $_SESSION['admin'] == 1) : ?>
<div>
   <a class="link" href="panel.php">Admin Panel</a>
</div>
   <?php endif; ?>
</div>
</body>
</html>