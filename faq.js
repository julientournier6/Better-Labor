function questionClick(){
  id = getId(this);
  var imgsrc = getById("defilement-", id).src;
  if (imgsrc.includes("defilement-bas")) {
      getById("defilement-", id).src = imgsrc.replace("bas","haut");
  }
  else {
      getById("defilement-", id).src = imgsrc.replace("haut","bas");
  }
  this.classList.toggle("active");
  var content = this.nextElementSibling;
  if (content.style.display === "block") {
    content.style.display = "none";
  } else {
    content.style.display = "block";
  }
}

function getId(origine) {
  id_origine = origine.id;
  split = id_origine.split("-");
  return split[split.length - 1];
}

function getById(string, id) {
  element = document.getElementById(string + id);
  return element;
}