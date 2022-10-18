function questionClick(){
    var imgsrc = document.getElementById("defilement").src;
    if (imgsrc.includes("defilement-bas")) {
        document.getElementById("defilement").src = imgsrc.replace("bas","haut");
    }
    else {
        document.getElementById("defilement").src = imgsrc.replace("haut","bas");
    }
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }
}