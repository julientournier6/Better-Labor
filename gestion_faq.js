function handleMouseOver(){
  this.children[1].style.display = "block";
}
function handleMouseOut(){
  this.children[1].style.display = "none";
}

function editQuestion() {
  alert(this.outerHTML)
  edit_element = getById("edit-question-", id);
  var imgsrc = edit_element.src;
  if (imgsrc.includes("edit")) {
    var d = document.createElement('INPUT');
    d.setAttribute('type', 'text');
    d.setAttribute('name', 'sujet');
    d.setAttribute('class', "question-title-input");
    debugger;
    questiontitle = getById("question-title-", id);
    debugger;
    d.setAttribute('value', questiontitle.innerHTML);
    d.setAttribute('id', "question-title-" + id);
    getById("question-title-", id).replaceWith(d);
    edit_element.src = imgsrc.replace("edit","cancel");
    debugger;
  }
  else {
    var d = document.createElement('p');
    d.setAttribute('class', 'question-title');
    d.setAttribute('id', 'question-title-1');
    d.innerHTML = document.getElementById("question-title-1").getAttribute('value');
    document.getElementById("question-title-1").replaceWith(d);
    edit_element.src = imgsrc.replace("cancel","edit");
  }
  var content = document.getElementById("question-content-input-1");
  if (content.style.display === "block") {
    content.style.display = "none";
  } 
  else {
    content.style.display = "block";
  }
}

function editCategory() {
  edit_element = document.getElementById("edit-category-1");
  var imgsrc = edit_element.src;
  if (imgsrc.includes("edit")) {
    var d = document.createElement('INPUT');
    d.setAttribute('type', 'text');
    d.setAttribute('name', 'name');
    d.setAttribute('class', "category-title-input");
    d.setAttribute('value', document.getElementById("category-title-1").innerHTML);
    d.setAttribute('id', 'category-title-1');
    document.getElementById("category-title-1").replaceWith(d);
    edit_element.src = imgsrc.replace("edit","cancel");
    edit_element.parentNode.children[1].innerHTML = "Cancel";

    var s = edit_element.parentNode.cloneNode(true);
    s.onclick = function(){ document.getElementById("category-form-1").submit(); editCategory();};
    s.children[1].style.display = "none";
    s.children[1].innerHTML = "Save";
    s.addEventListener('mouseover', handleMouseOver);
    s.addEventListener('mouseout', handleMouseOut);
    s_image = s.firstElementChild;
    s_image.src = "images/save.svg";
    s_image.setAttribute('id', 'save-category-1');
    s_image.parentNode.classList.add('save');
    s_image.parentNode.classList.remove('edit');
    edit_element.parentNode.parentNode.prepend(s);
  }
  else {
    var d = document.createElement('h2');
    edit_element.parentNode.children[1].innerHTML = "Edit";
    d.setAttribute('class', 'category-title');
    d.setAttribute('id', 'category-title-1');
    d.innerHTML = document.getElementById("category-title-1").getAttribute('value');
    document.getElementById("category-title-1").replaceWith(d);
    edit_element.src = imgsrc.replace("cancel","edit");

    var s_image = edit_element.parentNode.parentNode.querySelector('.save');
    s_image.remove();
  }
}

function getId(origine) {
  id_origine = origine.id;
  return id_origine[id_origine.length-1];
}

function getById(string, id) {
  element = document.getElementById(string.substring(0, id_origine.length - 2) + id);
  return element;
}