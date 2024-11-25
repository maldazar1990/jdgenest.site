import Quill from 'quill';
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import hljs from 'highlight.js';
import {Mention, MentionBlot} from "quill-mention";
import QuillResizeImage from 'quill-resize-image';
import "../../../node_modules/quill-mention/src/quill.mention.css";
import "../../../node_modules/highlight.js/styles/vs2015.css";
import "./image-picker.min.js";
import "./image-picker.css";
class linkmentionBlot extends MentionBlot {
    static render(data) {
        var element = document.createElement('span');
        element.classList.add('mention');
        var aelem =  document.createElement('a');
        aelem.setAttribute('href', data.link);
        aelem.setAttribute('target', '_blank');
        aelem.innerHTML = data.value;
        return element;
    }
}

linkmentionBlot.blotName = "link-mention";
$(document).on("click","ul.nav li.parent > a ", function(){
    $(this).find('i').toggleClass("fa-minus");
});


$("#nav-image-upload").click(function (e) {
    $("#hiddenTypeImage").val("upload");
});
$("#nav-image-url").click(function (e) {
    $("#hiddenTypeImage").val("url");
});

async function suggestArticle(searchTerm) {
    if (searchTerm.length > 1) {
        const response = await fetch(window.appurl + "/admin/posts/ajax/" + searchTerm,
            {
                headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }})
        .then(response => response.json())
        .then(data => {
            return data;
        });
        return response.slice(0,10);
    } else{
        return [];
    }
}
function isDeltaEmptyOrWhitespace(delta) {
    if (delta.ops.length === 0) {
        return true;
    }
    for (let i = 0; i < delta.ops.length; i++) {
        if (delta.ops[i].insert.trim() !== '') {
            return false;
        }
    }
    return true;
}

function validateInputFile(element,minWidth=0,minHeight=0,maxwidth=0,maxheight=0,extension="",hash="") {

    if(element.files.length > 0) {
        let file = element.files[0];

        let fileName = file.name;
        let fileExtension = fileName.split('.').pop();
        if (element.hasAttribute("size")) {
            let size = element.getAttribute("size");
            if (size < file.size) {
                element.classList.add("is-invalid");
                element.setCustomValidity("La taille du fichier est trop grande");
                element.reportValidity();
            } else {
                element.classList.remove("is-invalid");
                element.setCustomValidity("");
                element.reportValidity();
            }
        }
        if (extension != "" && extension.indexOf(fileExtension) == -1) {
            element.classList.add("is-invalid");
            element.setcustomValidity("L'extension du fichier n'est pas valide");
        }

        let image = new Image();
        image.src = URL.createObjectURL(file);
        image.onload = function () {

            if (image.width < minWidth || image.height < minHeight) {
                console.log("ko");
                element.classList.add("is-invalid");
                element.setCustomValidity("La taille de l'image est trop petite");
                element.reportValidity();
            } else if (image.width > maxwidth || image.height > maxheight) {
                element.classList.add("is-invalid");
                element.setCustomValidity("La taille de l'image est trop grande");
                element.reportValidity();
            } else {
                element.classList.remove("is-invalid");
                element.setCustomValidity("");
                element.reportValidity();
            }

        }

    }
}

function validateTitleInput(element) {
    let valid = true;
    let model = element.dataset.model;
    if (model !== null) {
        let url = "";
        let appUrl = window.appurl;
        if(appUrl.indexOf("https:") === -1) {
            appUrl = "https:"+appUrl;
        }
        switch(model) {
            case "posts":
                url = new URL(appUrl+`/admin/posts/title`);
                break;
            case "infos":
                url = new URL(appUrl+`/admin/infos/title`);
                break;
            case "tags":
                url = new URL(appUrl+`/admin/tags/title`);
                break;
            case "files":
                url = new URL(appUrl+`/admin/files/title`);
                break;
            default:
                break;
        }
        if(url != "") {
            let params = {title: element.value};
            Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));
            let minlength = element.getAttribute("minlength");
            if(minlength > 0 && element.value.length > minlength) {
                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.response === "false") {
                            valid = false;
                            element.classList.add("is-invalid");
                            element.setCustomValidity("Le titre de l'article existe déjà");
                            element.reportValidity();
                        } else {
                            element.classList.remove("is-invalid");
                            element.setCustomValidity("");
                            element.reportValidity();
                        }

                    });
            } else {
                if (element.classList.contains("is-invalid")) {
                    element.classList.remove("is-invalid");
                    element.setCustomValidity("");
                    element.reportValidity();
                }
            }
            return valid;
        }
    }
    return valid;
}

$(function () {


    if($(".select2").length > 0) {
        $(".select2").select2({
            placeholder: "Choississez un tags",
            multiple: true,
            tags:true,
    
            ajax: {
                delay: 250,
                url: window.appurl + "/admin/tags/ajax",
                data: function (params) {
                    var query = {
                        term: params.term,
                    }
                    return query;
                },
                dataType: 'json',
            },
        });
        
    }

    let quillEditor = document.querySelector("#quill-editor");
    let quillValue = document.getElementById('quill-value');
    let editor = null;
    if (!quillEditor && quillValue != null) {
        let divQuill = document.createElement("div");
            divQuill.setAttribute("id","quill-editor");
            divQuill.classList.add("mb-3");
            divQuill.style.height = "300px";
        quillValue.insertAdjacentElement("afterend",divQuill);
        quillEditor = document.querySelector("#quill-editor");
    }
    
    if ( quillEditor != null ) {

        Quill.register("modules/resize", QuillResizeImage);
        Quill.register({ "blots/mention": MentionBlot, "modules/mention": Mention });
        Quill.register(linkmentionBlot);
        let searchterm = "";
        editor = new Quill('#quill-editor', {
            theme: 'snow',
            modules: { 
                resize: {
                    locale: {
                    center: "center",
                    },
                },
                toolbar: [ [{ 'header': [1, 2, false] }], ['bold', 'italic', 'underline', 'strike'], ['blockquote', 'code-block'], [{ 'list': 'ordered' }, { 'list': 'bullet' }], ['link', 'image', 'video'], ['clean'] ],
                syntax: { hljs },
                mention: {
                    minChars:1,
                    maxChars:8,
                    blotName: 'link-mention',
                    showDenotationChar: false,
                    allowedChars: /^[A-Za-z]*$/,
                    dataAttributes: ['id', 'value', 'denotationChar', 'link'],
                    mentionDenotationChars: ["@"],
                    source: async function (searchTerm, renderList) {
                        let values = await suggestArticle(searchTerm);
                        renderList(values, searchTerm);
                        searchterm = searchTerm;
                    },
                    onSelect: function (item, insertItem) {
                        editor.deleteText(editor.getSelection().index - searchterm.length-1, searchterm.length+1);
                        var delta = {
                            ops: [

                                {retain: editor.getSelection().index},
                                {insert: item.value, attributes: {link: item.link}},

                            ]
                        };
                        editor.updateContents(delta);
                    }
                    ,
                },
            }
        }); 

        editor.on('text-change', function(delta, oldDelta, source) {
            editor.root.querySelectorAll("blockquote").forEach(function(blockquote) {
                blockquote.classList.add("blockquote");
            });
            
            quillValue.value = editor.root.innerHTML;
        });

        window.addEventListener('mention-hovered', (event) => {console.log('hovered: ', event)}, false);
        window.addEventListener('mention-clicked', (event) => {console.log('hovered: ', event)}, false);

        if ( quillValue.value != "" ) {
            editor.root.querySelectorAll("blockquote").forEach(function(blockquote) {
                blockquote.classList.add("blockquote");
            });

            quillValue.value = editor.root.innerHTML;
        }

        editor.setHTML = (html) => { 
            editor.root.innerHTML = html; 
        }
        editor.getHTML = () => {
            return editor.root.innerHTML;
        };
        editor.setHTML(valpost);
    }

    let menu = document.getElementById("menu");
    let sidebar = $(".sidebar span.icon");

    if ( menu != null ) {

       //

        document.getElementById("addMenu").addEventListener("click",function(e){
            e.preventDefault();
            let name = document.getElementById("linkNameMenu").value;
            let link = document.getElementById("linkMenu").value;
            let row = document.querySelector("template").content;
            row.setAttributes("data-url",link);
            row.innerHtml = name+row.innerHtml;
            menu.appendChild(document.importNode(row, true));
            return true;
        });

        document.getElementById("submitMenu").addEventListener("click",function(e){
            e.preventDefault();

            return true;
        });
    }

    if(sidebar.length > 0) {
        sidebar.find('em:first').addClass("fa-plus");
    }
    if ($("#menu-toggle").length>0) {
        $("#menu-toggle").on('click',function (e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    }
    if (document.querySelector( '#editor' )) {
       

    }
    
    let previewImage = $("#previewImage");

    let imageUrl = $("#imageUrl");
    let imageUpload = $('#imageUpload');
    let isUpdate = $("#isupdate").val();
    if (imageUpload) {
        imageUpload.on('change', function (e) {
            let output = $('#previewImage');
            output.removeClass("d-none");
            if(e.target.files.length > 0) {
                let file = e.target.files[0];
                output.attr("src", URL.createObjectURL(file));
                if( isUpdate != 0 )
                    output.attr("data-preview",true);

                output.parent().find("source").remove();
            } else {
                previewImage.attr('src',window.appurl+'/images/default.webp');
                if( isUpdate != 0 )
                    output.attr("data-preview",false);
            }
        });
    }

    if (imageUrl.length > 0) {
        imageUrl.on('change', function () {
            if( !$(this).is(':invalid') ){
                let srcImage = imageUrl.val();
                output.classList.remove("d-none");
                previewImage.attr('src',srcImage);

                if( isUpdate != 0 )
                    output.setAttribute("data-preview",true);

                output.parent().find("source").remove();

            }
        });
    }

    $('button[data-toggle="tab"]').on('shown.bs.tab', function (event) {

        let input = $($(event.target).attr("data-target")).find("input");
        let isUpdate = $("#isupdate").val();
        let previewImage = document.querySelector("#previewImage");
        switch ($(event.target).attr("data-target")) {
            case "#nav-upload":
                if(isUpdate == "0") {
                    input.prop("required", true);
                }
                break;
            case "#nav-url":
                    if(isUpdate == '0') {
                        input.prop("required", true);
                    }
                break;
            case "#nav-picker":
                $("#collapseimagepicker").collapse("show");
                if(isUpdate == '0') {
                    input.prop("required", true);
                }
            default:
                break
        }
        switch ($(event.relatedTarget).attr("data-target")) {
            case "#nav-upload": {
                let lastInput = $($(event.relatedTarget).attr("data-target")).find("input");
                lastInput.prop("required", false);
                lastInput.removeClass("is-invalid");
                lastInput.val("");
                lastInput[0].setCustomValidity("");
                lastInput[0].reportValidity();
                let isUpdate = $("#isupdate").val();
                if(isUpdate!=0) {
                    previewImage.setAttribute('src',isUpdate);
                } else {
                    previewImage.setAttribute('src', window.appurl + '/images/default.webp');
                }
            }
            break;
            case "#nav-url": {
                let lastInput = $($(event.relatedTarget).attr("data-target")).find("input");
                lastInput.prop("required", false);
                lastInput.removeClass("is-invalid");
                lastInput.val("");
                lastInput[0].setCustomValidity("");

                lastInput[0].reportValidity();
                let isUpdate = $("#isupdate").val();
                if(isUpdate!=0) {
                    previewImage.setAttribute('src',isUpdate);
                } else {
                    previewImage.setAttribute('src', window.appurl + '/images/default.webp');
                }



            }

            break;
            case "#nav-picker": {
                let lastInput = $($(event.relatedTarget).attr("data-target")).find("select");
                lastInput.prop("required", false);
                lastInput.removeClass("is-invalid");
                lastInput.val("");
                lastInput[0].reportValidity();
                let isUpdate = $("#isupdate").val();
                if(isUpdate!=0) {
                    previewImage.setAttribute('src',isUpdate);
                } else {
                    previewImage.setAttribute('src', window.appurl + '/images/default.webp');

                }
            }
            break;
            default:
                break
        }
    });



    let form = document.querySelector("#adminForm");
    if (form){

        form.querySelectorAll("input").forEach(function(input){

            if(input.getAttribute("type") == "file") {
                input.addEventListener("input",function(e) {
                    if ((input.hasAttribute("data-minwidth") && input.hasAttribute("data-minheight")) ||
                        (input.hasAttribute("data-maxwidth") && input.hasAttribute("data-maxheight"))) {

                        let minwidth = decodeURI(input.dataset.minwidth);
                        let minheight = decodeURI(input.dataset.minheight);
                        let maxwidth = decodeURI(input.dataset.maxwidth);
                        let maxheight = decodeURI(input.dataset.maxheight);
                        let extension = ""
                        let hash = input.dataset.havehash;

                        if (input.hasAttribute("data-extension")) {
                            extension = input.dataset.extension;
                        }
                        validateInputFile(input, minwidth, minheight, maxwidth, maxheight, extension,hash);

                    }
                });
            }

            if(input.id === "title") {
                if(input.hasAttribute("data-model")) {
                    input.addEventListener("input",function(e) {
                        validateTitleInput(input);
                    });
                }
            }

            if (input.id === "name") {
                if(input.hasAttribute("data-model")) {
                    input.addEventListener("input",function(e) {
                        validateTitleInput(input);
                    });
                }
            }

            if (input.id === "datestart") {
                if(input.hasAttribute("data-dateend")) {
                    input.addEventListener("input", function (e) {
                        let date = new Date(input.value);
                        let elemDateEnd = document.getElementById(input.dataset.dateend);
                        if (elemDateEnd) {
                            let dateend = new Date(elemDateEnd.value);
                            if (date > dateend) {
                                input.classList.add("is-invalid");
                                input.setCustomValidity("La date de début doit être inférieure à la date de fin");
                                input.reportValidity();
                            } else {
                                input.classList.remove("is-invalid");
                                input.setCustomValidity("");
                                input.reportValidity();
                            }
                        }
                    });
                }
            }

            if (input.id === "dateend") {
                if(input.hasAttribute("data-datestart")) {
                    input.addEventListener("input", function (e) {
                        let date = new Date(input.value);
                        let elemDateStart = document.getElementById(input.dataset.datestart);
                        if (datestart) {
                            let datestart = new Date(elemDateStart.value);
                            if (date < datestart) {
                                input.classList.add("is-invalid");
                                input.setCustomValidity("La date de fin doit être supérieure à la date de début");
                                input.reportValidity();
                            } else {
                                input.classList.remove("is-invalid");
                                input.setCustomValidity("");
                                input.reportValidity();

                            }
                        }
                    });
                }
            }
        });

        form.addEventListener("submit",function(e){

            e.preventDefault();

            let valid = true;
            if (editor) {
                let content = isDeltaEmptyOrWhitespace(editor.getContents());
                if(content) {
                    editor.focus();
                    editor.insertText(0, 'MANQUE UN TEXTE!!!!!!!!', 'bold', true);
                    return false;
                }

                if(editor.getLength() < 100) {
                    editor.focus();
                    editor.insertText(0, 'MANQUE UN TEXTE!!!!!!!!', 'bold', true);
                    return false;
                }


            }

            let jsElem = document.querySelector("#imagePicker");
            let imagepicker = $("#imagePicker");
            if(imagepicker.length > 0) {
                if($("#imageUpload").prop("files").length == 0 && $("#imageUrl").val() == "") {

                    let isUpdate = $("#isupdate").val();
                    if(isUpdate == '0') {
                        if (imagepicker.val().length == 0) {
                            $("#nav-image-picker").tab("show");
                            $("#collapseimagepicker").collapse("show");
                            imagepicker.addClass("is-invalid");
                            jsElem.setCustomValidity("Vous devez choisir une image");
                            jsElem.reportValidity();
                            valid = false;
                        } else {
                            imagepicker.removeClass("is-invalid");
                            jsElem.setCustomValidity("");
                            jsElem.reportValidity();
                        }
                    }
                }
            }

            if(valid===true){
               form.submit();
            }

        });
    }

    let imagePicker = $(".image-picker");
    if(imagePicker.length > 0) {
        imagePicker.imagepicker({
            hide_select: false,
        });
        imagePicker.on("change",function(e){
            let src = $(this).find("option:selected").data("img-src");
            if(src) {
                let previewImage = $("#previewImage");
                previewImage.attr("src",src);
                let isUpdate = $("#isupdate").val();
                if( isUpdate != 0 )
                    previewImage.attr("data-preview",true);
                previewImage.parent().find("source").remove();
                $("#collapseimagepicker").collapse("hide");

            }
        });

        imagePicker.on("focus",function(e) {
            $("#nav-image-picker").tab("show");
            $("#collapseimagepicker").collapse("show");
        });
    }

});
