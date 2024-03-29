var password = document.getElementById("password")
  , confirm_password = document.getElementById("confirmpassword");

function validatePassword() {
  if (password.value == null || password.value.length < 6) {
    password.setCustomValidity("Veuillez entrer un mot de passe de plus de 6 caractères");
    password.reportValidity();
    return false;
  }
  else if (password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Les mots de passe ne correspondent pas!");
    confirm_password.reportValidity();
    return false; 
  }
  else {
    confirm_password.setCustomValidity('');
    password.setCustomValidity('');
    return true;
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;

function validateSignupForm() {
  if (!validatePassword()) {
    return false;
  }
  else {
    return true;
  }
}