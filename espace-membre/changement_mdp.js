var password = document.getElementById("password")
  , confirm_password = document.getElementById("confirmpassword");

enableSubmitButton();

function validatePassword() {
  if (password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Les mots de passe ne correspondent pas!");
    return false;
  } else if (password.value == null || password.value.length < 6) {
    password.setCustomValidity("Veuillez entrer un mot de passe de plus de 6 caractères");
    return false;
  } else {
    confirm_password.setCustomValidity('');
    return true;
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;

function enableSubmitButton() {
  document.getElementById('submitButton').disabled = false;
  document.getElementById('loader').style.display = 'none';
}

function disableSubmitButton() {
  document.getElementById('submitButton').disabled = true;
  document.getElementById('loader').style.display = 'unset';
}

function validateSignupForm() {
  if (!validatePassword()) {
    return false;
  }
  else {
    return true;
  }
}