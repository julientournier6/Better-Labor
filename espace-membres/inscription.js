var password = document.getElementById("mdp1")
  , confirm_password = document.getElementById("mdp2")
  , email = document.getElementById("email")
  , nom = document.getElementById("nom")
  , prenom = document.getElementById("prenom");


enableSubmitButton();

function validatePassword() {
    if(password.value != confirm_password.value) {
        confirm_password.setCustomValidity("Les mots de passe ne correspondent pas!");
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
    if (nom.value == null) {
        nom.setCustomValidity("Veuillez entrer votre nom)");
        return false;
    }
    if (prenom.value == null) {
        prenom.setCustomValidity("Veuillez entrer votre prénom)");
        return false;
    }
    else if (email.value == null) {
        email.setCustomValidity("Veuillez entrer un email)");
        return false;
    }
    else if (password.value == null || password.value.length < 7) {
        password.setCustomValidity("Veuillez entrer un mot de passe de plus de 6 caractères");
        return false;
    }
  
  if (!validatePassword()) {
    return false;
  }
  return true;
  
}