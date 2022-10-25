function buttonClick(){
    this.classList.toggle("active");
    var button = document.getElementsByClassName("Duration-Button");
    for (i = 0; i < button.length; i++) {
        button[i].style.background = '#e7e7ec';
    }
    this.style.background = '#DFD9F9';
}