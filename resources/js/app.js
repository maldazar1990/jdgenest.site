import '../../node_modules/bootstrap-5/';
import '@fortawesome/fontawesome-free/js/all.min.js';
import "./component/commentaire.js";

const APIURI = 'https://'+window.location.host+'/api/';

function cleanByTag (e) {
    let classOrder = this.dataset.class;
    e.target.classList.remove("bg-primary");
    e.target.classList.add("bg-secondary");
    document.querySelectorAll(".clean-tag").forEach(function(e){
        e.classList.remove("d-none");
    });
    document.querySelectorAll("a[data-listclass]:not([data-listclass*='"+classOrder+"'])").forEach(function(e){
        e.classList.add("bg-primary");
        e.classList.remove("bg-secondary");
    });
    document.querySelectorAll("li[data-listclass*='"+classOrder+"']").forEach(function(e){
        e.classList.remove("d-none");
    });
    document.querySelectorAll("li[data-listclass]:not([data-listclass*='"+classOrder+"'])").forEach(function(e) {
        e.classList.add("d-none");
    });
    document.querySelectorAll("div[data-listclass*='"+classOrder+"']").forEach(function(e){
        e.classList.remove("d-none");
    });
    document.querySelectorAll("div[data-listclass]:not([data-listclass*='"+classOrder+"'])").forEach(function(e) {
        e.classList.add("d-none");
    });

}

function resetTags(event) {
    event.target.classList.add("d-none");
        document.querySelectorAll("li[data-listclass]").forEach(function(e){
            e.classList.remove("d-none");
    });
    document.querySelectorAll("div[data-listclass]").forEach(function(e){
        e.classList.remove("d-none");
    });
    document.querySelectorAll(".order").forEach(function(e){
        e.classList.remove("bg-secondary");
        e.classList.add("bg-primary");
    });
}

document.addEventListener('DOMContentLoaded', (event) => {

    if (document.querySelector("#title")) {
        let i = 0; /* The text */
        //let txt = document.querySelector("#title").dataset.title;
        //typeWriter(i,txt,"title");
        }
        document.querySelectorAll(".order").forEach(

            function(e){
                e.addEventListener("click",cleanByTag,false);
                e.addEventListener("touchstart",cleanByTag,false);
            }
        );

        document.querySelectorAll(".clean-tag").forEach(function(e){

            e.addEventListener("click",resetTags,false);
            e.addEventListener("touchstart",resetTags,false);

        });

        document.querySelectorAll("pre > code").forEach((el) => {
            let button = document.createElement("button");
            button.className = "copy-button";
            button.innerHTML = "Cliquez pour copier";

            el.parentNode.insertBefore(button,el);
            button.addEventListener("click touchstart", (e) => {
                    let text = el.innerText;
                navigator.clipboard.writeText(text);
                button.innerHTML = "Copié !";
            });
        });

        let head = document.querySelector(".header");
        let title = document.querySelector("#titlewebsite");
        let collnav = document.getElementById("navigation");
 
        if ( head != null && title != null && collnav != null) {
        collnav.addEventListener("hidden.bs.collapse",function(){
            head.classList.add("justify-content-center");
            title.style.top = "";
        });
        collnav.addEventListener("show.bs.collapse",function(){
            head.classList.remove("justify-content-center");
            title.style.top = '10px';
        });
        }

  
        let savon = document.querySelector("#savon");
        if(savon != null) {
            savon.addEventListener("click",function(e){
                let falseField = document.querySelectorAll(".fieldFormClass");
                falseField.forEach(function(e){
                    e.removeAttribute("required");
                });
            });

            savon.addEventListener("focus",function(e){
                let falseField = document.querySelectorAll(".fieldFormClass");
                falseField.forEach(function(e){
                    e.removeAttribute("required");
                });
            });
        }
});


