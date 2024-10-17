/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/***/ (() => {

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

/***/ }),

/***/ "./resources/sass/admin/app.scss":
/*!***************************************!*\
  !*** ./resources/sass/admin/app.scss ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/front/js/app": 0,
/******/ 			"front/css/app": 0,
/******/ 			"admin/css/app": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["front/css/app","admin/css/app"], () => (__webpack_require__("./resources/js/app.js")))
/******/ 	__webpack_require__.O(undefined, ["front/css/app","admin/css/app"], () => (__webpack_require__("./resources/sass/admin/app.scss")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["front/css/app","admin/css/app"], () => (__webpack_require__("./resources/sass/app.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;