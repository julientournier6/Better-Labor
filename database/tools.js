// get all elements on the page
var elements = document.querySelectorAll("*");

// loop through the elements
for (var i = 0; i < elements.length; i++) {
  var element = elements[i];
  
  // check if the element has a 'href' property
  if (element.hasAttribute("href")) {
    // change the value of the 'href' property
    element.setAttribute("href", element.getAttribute("href"));
  }
  
  // check if the element has a 'src' property
  if (element.hasAttribute("src")) {
    // change the value of the 'src' property
    element.setAttribute("src", "new-value-for-src");
  }
}