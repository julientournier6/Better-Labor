function editQuestion() {
    edit_element = document.getElementById("edit-1");
    var imgsrc = edit_element.src;
    if (imgsrc.includes("edit")) {
      var d = document.createElement('INPUT');
      d.setAttribute('type', 'text');
      d.setAttribute('name', 'sujet');
      d.setAttribute('class', "question-title-input");
      d.setAttribute('value', document.getElementById("question-title-1").innerHTML);
      d.setAttribute('id', 'question-title-1');
      document.getElementById("question-title-1").replaceWith(d);
      edit_element.src = imgsrc.replace("edit","cancel");
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
    } else {
      content.style.display = "block";
    }
}