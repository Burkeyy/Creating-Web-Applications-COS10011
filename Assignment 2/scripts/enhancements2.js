"use strict";

function init() {
  //gets window path/directory
  var path = window.location.pathname;
  //creates substring from the last / to the last . (/"topic".html for example)
  var selectedMenuID = path.substring(
    path.lastIndexOf("/") + 1,
    path.lastIndexOf(".")
  );

  var selectedMenu = document.getElementById(selectedMenuID);
  selectedMenu.className = "activeItem";
}
window.addEventListener("load", init);
