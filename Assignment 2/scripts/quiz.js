/*
Author: Anthony Burke 103358702
Target: quiz.html
Purpose: script for quiz.html
created: 24/09/2020
Last updated: NA
credits: 
*/

"use strict";

function validate() {
  var score = 0;
  var errMsg = "";
  var result = true;
  var firstname = document.getElementById("GivenName").value;
  var lastname = document.getElementById("FamName").value;
  var id = document.getElementById("stuID").value;
  var students = document.getElementById("students").checked;
  var educators = document.getElementById("educators").checked;
  var pets = document.getElementById("pets").checked;
  var competitor = document.getElementById("competitor").value;
  var q4Answer = document.getElementById("Q4").value;
  var date = document.getElementById("Date").value;

  // gets input from Q1 and scores it
  var q1Answer = getQ1Answer();
  if (q1Answer == "Bridge") {
    score += 1;
  } else {
    score += 0;
  }

  if (competitor == "") {
    errMsg = errMsg + "You must select an answer for Question 2.\n";
    result = false;
  } else if (competitor == "Google Class") {
    score += 1;
  } else {
    score += 0;
  }

  if (!(students || educators || pets)) {
    errMsg += "You must select an answer for Question 3.\n";
    result = false;
  } else if (students && educators && !pets) {
    score += 1;
  } else if (!(students && educators)) {
    score += 0;
  }

  if (q4Answer.toLowerCase() == "Learning Management System".toLowerCase()) {
    score += 1;
  } else if (
    q4Answer.toLowerCase() == "Learning Management Systems".toLowerCase()
  ) {
    score += 1;
  }

  if (date == "2008") {
    score += 1;
  } else {
    score += 0;
  }

  if (score == 0) {
    errMsg += "You cannot submit if you score 0 on this Quiz";
    result = false;
  }

  if (parseInt(localStorage.attempts) >= 3) {
    errMsg += "Max attempts reached";
    result = false;
  }

  if (errMsg != "") {
    alert(errMsg);
  }

  if (result) {
    storeResults(firstname, lastname, id, score);
  }

  return result;
}

function prefillform() {
  if (localStorage.fname != undefined) {
    document.getElementById("GivenName").value = localStorage.fname;
    document.getElementById("FamName").value = localStorage.lname;
    document.getElementById("stuID").value = localStorage.id;
  }
}

function getQ1Answer() {
  var answer = "";
  var q1Array = document
    .getElementById("q1Answer")
    .getElementsByTagName("input");
  for (var i = 0; i < q1Array.length; i++) {
    if (q1Array[i].checked) answer = q1Array[i].value;
  }
  return answer;
}

function storeResults(firstname, lastname, id, score) {
  if (localStorage.attempts == undefined) {
    localStorage.attempts = 1;
  } else {
    localStorage.attempts = parseInt(localStorage.attempts) + 1;
  }

  localStorage.score = score;
  localStorage.fname = firstname;
  localStorage.lname = lastname;
  localStorage.id = id;
}

function init() {
  var quizform = document.getElementById("quizform");
  quizform.onsubmit = validate;
  prefillform();
}

window.addEventListener("load", init);
