/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/


var speed = 50; /* The speed/duration of the effect in milliseconds */

function typeWriter(i, txt, el) {
  if (i < txt.length) {
    document.getElementById(el).innerHTML += txt.charAt(i);
    i++;
    setTimeout(function () {
      typeWriter(i, txt, el);
    }, speed);
  }
}
function cleanByTag(e) {
  var classOrder = this.dataset["class"];
  e.target.classList.remove("bg-primary");
  e.target.classList.add("bg-secondary");
  document.querySelectorAll(".clean-tag").forEach(function (e) {
    e.classList.remove("d-none");
  });
  document.querySelectorAll("a[data-listclass]:not([data-listclass*='" + classOrder + "'])").forEach(function (e) {
    e.classList.add("bg-primary");
    e.classList.remove("bg-secondary");
  });
  document.querySelectorAll("li[data-listclass*='" + classOrder + "']").forEach(function (e) {
    e.classList.remove("d-none");
  });
  document.querySelectorAll("li[data-listclass]:not([data-listclass*='" + classOrder + "'])").forEach(function (e) {
    e.classList.add("d-none");
  });
  document.querySelectorAll("div[data-listclass*='" + classOrder + "']").forEach(function (e) {
    e.classList.remove("d-none");
  });
  document.querySelectorAll("div[data-listclass]:not([data-listclass*='" + classOrder + "'])").forEach(function (e) {
    e.classList.add("d-none");
  });
}
function resetTags(event) {
  event.target.classList.add("d-none");
  document.querySelectorAll("li[data-listclass]").forEach(function (e) {
    e.classList.remove("d-none");
  });
  document.querySelectorAll("div[data-listclass]").forEach(function (e) {
    e.classList.remove("d-none");
  });
  document.querySelectorAll(".order").forEach(function (e) {
    e.classList.remove("bg-secondary");
    e.classList.add("bg-primary");
  });
}
document.addEventListener('DOMContentLoaded', function (event) {
  if (document.querySelector("#title")) {
    var i = 0; /* The text */
    //let txt = document.querySelector("#title").dataset.title;
    //typeWriter(i,txt,"title");
  }
  document.querySelectorAll(".order").forEach(function (e) {
    e.addEventListener("click", cleanByTag, false);
    e.addEventListener("touchstart", cleanByTag, false);
  });
  document.querySelectorAll(".clean-tag").forEach(function (e) {
    e.addEventListener("click", resetTags, false);
    e.addEventListener("touchstart", resetTags, false);
  });
  document.querySelectorAll("pre > code").forEach(function (el) {
    var button = document.createElement("button");
    button.className = "copy-button";
    button.innerHTML = "Cliquez pour copier";
    el.parentNode.insertBefore(button, el);
    button.addEventListener("click touchstart", function (e) {
      var text = el.innerText;
      navigator.clipboard.writeText(text);
      button.innerHTML = "Copié !";
    });
  });
});
/******/ })()
;