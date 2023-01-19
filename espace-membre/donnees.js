function buttonClick(){
    this.classList.toggle("active");
    var button = document.getElementsByClassName("Duration-button");
    for (i = 0; i < button.length; i++) {
        button[i].style.background = '#e7e7ec';
    }
    this.style.background = '#DFD9F9';
}

function editAccount() {
  request = this.id;
  window.location.href = "../espace-membre/modification_profil.php?" + request;
}

function deleteAccount() {
  request = this.id
  if (confirm("Voulez-vous vraiment supprimer ce compte? \nL'action est irréversible.")) {
    window.location.href = "../database/suppression_compte.php?" + request;
  }
}