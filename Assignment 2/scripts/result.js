/*
Author: Anthony Burke 103358702
Target: result.html
Purpose: script for result.html
created: 26/09/2020
Last updated: NA
credits: 
*/

"use strict";

function getResults() {
  document.getElementById("attempts").textContent = localStorage.attempts;
  document.getElementById("score").textContent = localStorage.score;
  document.getElementById("name").textContent =
    localStorage.fname + " " + localStorage.lname;
  document.getElementById("id").textContent = localStorage.id;
}

function init() {
  getResults();

  if (parseInt(localStorage.attempts) >= 3) {
    var linkremove = document.getElementById("link");
    linkremove.remove();
  }
}

window.onload = init;
