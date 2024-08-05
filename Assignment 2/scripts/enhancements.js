"use strict";

function init() {
  var time = 0;

  //calls timer function every second
  var interval = setInterval(timer, 1000);
  function timer() {
    time += 1;
    var timeDisplay = document.getElementById("timeDisplay");
    timeDisplay.textContent = 200 - time;
    if (time == 200) {
      timeDisplay.textContent = "Times up!!";
      document.getElementById("submit").remove();
      clearInterval(interval);
    }
  }
}
// add new event instead of overriding .onload
window.addEventListener("load", init);
