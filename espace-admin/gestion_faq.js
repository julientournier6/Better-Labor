function handleMouseOver(){
  this.children[1].style.display = "block";
}
function handleMouseOut(){
  this.children[1].style.display = "none";
}

function editQuestion() {
  id = getId(this.children[0]);
  edit_element = getById("edit-question-", id);
  var imgsrc = edit_element.src;
  if (imgsrc.includes("edit")) {
    var d = document.createElement('INPUT');
    d.setAttribute('type', 'text');
    d.setAttribute('name', 'sujet');
    d.setAttribute('class', "question-title-input");
    questiontitle = getById("question-title-", id);
    d.setAttribute('value', questiontitle.innerHTML);
    d.setAttribute('id', "question-title-" + id);
    getById("question-title-", id).replaceWith(d);
    edit_element.src = imgsrc.replace("edit","cancel");
    edit_element.parentNode.children[1].innerHTML = "Cancel";
  }
  else {
    var d = document.createElement('p');
    d.setAttribute('class', 'question-title');
    d.setAttribute('id', 'question-title-' + id);
    d.innerHTML = getById("question-title-", id).getAttribute('value');
    getById("question-title-", id).replaceWith(d);
    edit_element.src = imgsrc.replace("cancel","edit");
    edit_element.parentNode.children[1].innerHTML = "Edit";
  }
  var content = getById("question-content-input-", id);
  if (content.style.display === "block") {
    content.style.display = "none";
  } 
  else {
    content.style.display = "block";
  }
}

function editCategory() {
  id = getId(this.children[0]);
  edit_element = getById("edit-category-", id);
  var imgsrc = edit_element.src;
  if (imgsrc.includes("edit")) {
    var d = document.createElement('INPUT');
    d.setAttribute('type', 'text');
    d.setAttribute('name', 'nom');
    d.setAttribute('class', "category-title-input");
    d.setAttribute('value', getById("category-title-", id).innerHTML);
    d.setAttribute('id', 'category-title-' + id);
    getById("category-title-", id).replaceWith(d);
    edit_element.src = imgsrc.replace("edit","cancel");
    edit_element.parentNode.children[1].innerHTML = "Cancel";

    var s = edit_element.parentNode.cloneNode(true);
    s.onclick = function(){ getById("category-form-", id).submit();};
    s.children[1].style.display = "none";
    s.children[1].innerHTML = "Save";
    s.addEventListener('mouseover', handleMouseOver);
    s.addEventListener('mouseout', handleMouseOut);
    s_image = s.firstElementChild;
    s_image.src = "../images/save.svg";
    s_image.setAttribute('id', 'save-category-' + id);
    s_image.parentNode.classList.add('save');
    s_image.parentNode.classList.remove('edit');
    edit_element.parentNode.parentNode.prepend(s);
    getById()
  }
  else {
    var d = document.createElement('h2');
    edit_element.parentNode.children[1].innerHTML = "Edit";
    d.setAttribute('class', 'category-title');
    d.setAttribute('id', 'category-title-' + id);
    d.innerHTML = getById("category-title-", id).getAttribute('value');
    getById("category-title-", id).replaceWith(d);
    edit_element.src = imgsrc.replace("cancel","edit");

    var s_image = edit_element.parentNode.parentNode.querySelector('.save');
    s_image.remove();
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

function deleteQuestion() {
  id = getId(this.children[0]);
  fetch("gestion_faq.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
    },
    body: `delete-question=${1}&id=${id}`,
  });
  window.location.reload();
}

function deleteCategory() {
  id = getId(this.children[0]);
  fetch("gestion_faq.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
    },
    body: `delete-category=${1}&id=${id}`,
  });
  window.location.reload();
}

function addQuestion() {
  id = getId(this);
  fetch("gestion_faq.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
    },
    body: `add-question=${1}&id=${id}`,
  })
  // .then((response) => response.text())
  // .then((res) => (alert(res)));
  window.location.reload();
}
function addCategory() {
  fetch("gestion_faq.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
    },
    body: `add-category=${1}`,
  })
  // .then((response) => response.text())
  // .then((res) => (alert(res)));
  window.location.reload();
}

function moveupCategory() {
  id = getId(this);
  moveCategory(id, -1);
}
function movedownCategory() {
  id = getId(this);
  moveCategory(id, 1);
}

function moveCategory(id, step) {
  fetch("gestion_faq.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
    },
    body: `move-category=${1}&step=${step}&id=${id}`,
  })
  // .then((response) => response.text())
  // .then((res) => (alert(res)));
  window.location.reload();
}

function moveupQuestion() {
  id = getId(this);
  moveQuestion(id, -1);
}
function movedownQuestion() {
  id = getId(this);
  moveQuestion(id, 1);
}

function moveQuestion(id, step) {
  fetch("gestion_faq.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
    },
    body: `move-question=${1}&step=${step}&id=${id}`,
  })
  // .then((response) => response.text())
  // .then((res) => (alert(res)));
  window.location.reload();
}

