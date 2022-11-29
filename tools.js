function addEvent(classname, functionName) {
    var elements = document.getElementsByClassName(classname);
    var i;
    for (i = 0; i < elements.length; i++) {
        elements[i].addEventListener("click", functionName);
    }
}