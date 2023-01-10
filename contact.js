var demande = document.getElementById("demande")

function validateContactForm() {
  text = demande.value;
  // text = text.replace(/\s+/g, '');
  if (text.length < 20) {
    demande.setCustomValidity("Votre demande doit faire plus de 20 caractères");
    demande.reportValidity();
    return false;
  }
  else {
    demande.setCustomValidity("");
    return true;
  }
}