var password = document.getElementById("mdp1")
  , confirm_password = document.getElementById("mdp2")
  , email = document.getElementById("email")
  , nom = document.getElementById("nom")
  , prenom = document.getElementById("prenom")
  , code = document.getElementById("code");

function validatePassword() {
    if(password.value != confirm_password.value) {
        confirm_password.setCustomValidity("Les mots de passe ne correspondent pas!");
        confirm_password.reportValidity();
        return false;
    } else {
        confirm_password.setCustomValidity('');
        return true;
    }
}

function validateSignupForm() {
  if (code.value.length != 20) {
    code.setCustomValidity("Le code d'activation doit faire 20 caractères");
    code.reportValidity();
    return false;
  }
  if (nom.value == '') {
      nom.setCustomValidity("Veuillez entrer votre nom");
      nom.reportValidity();
      return false;
  }
  if (prenom.value == '') {
      prenom.setCustomValidity("Veuillez entrer votre prénom");
      prenom.reportValidity();
      return false;
  }
  else if (email.value == '') {
      email.setCustomValidity("Veuillez entrer un email");
      email.reportValidity();
      return false;
  }
  else if (password.value == '' || password.value.length < 7) {
      password.setCustomValidity("Veuillez entrer un mot de passe de plus de 6 caractères");
      password.reportValidity();
      return false;
  }
  
  if (!validatePassword()) {
    return false;
  }
  password.setCustomValidity('');
  email.setCustomValidity('');
  confirm_password.setCustomValidity('');
  nom.setCustomValidity('');
  prenom.setCustomValidity('');
  code.setCustomValidity('');
  return true;
  
  
}