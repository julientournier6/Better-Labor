function buttonClick(){
    this.classList.toggle("active");
    var button = document.getElementsByClassName("Duration-button");
    for (i = 0; i < button.length; i++) {
        button[i].style.background = '#e7e7ec';
    }
    this.style.background = '#DFD9F9';
}

function modifyAccount() {

}

function deleteAccount() {
    if (confirm("Voulez-vous vraiment supprimer ce compte?")) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("txtHint").innerHTML = this.responseText;
          }
        };
        xmlhttp.open("GET","supprimer_compte.php?q="+str,true);
        xmlhttp.send();
    }
}