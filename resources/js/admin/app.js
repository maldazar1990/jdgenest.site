import Quill from 'quill';
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import hljs from 'highlight.js';
import {Mention, MentionBlot} from "quill-mention";
import QuillResizeImage from 'quill-resize-image';
import "../../../node_modules/quill-mention/src/quill.mention.css";
import "../../../node_modules/highlight.js/styles/vs2015.css";


class linkmentionBlot extends MentionBlot {
    static render(data) {
        var element = document.createElement('span');
        element.classList.add('mention');
        var aelem =  document.createElement('a');
        aelem.setAttribute('href', data.link);
        aelem.setAttribute('target', '_blank');
        aelem.innerHTML = data.value;
        console.log(element);
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
    if (!quillEditor && quillValue != null) {
        let divQuill = document.createElement("div");
            divQuill.setAttribute("id","quill-editor");
            divQuill.classList.add("mb-3");
            divQuill.style.height = "300px";
        quillValue.insertAdjacentElement("afterend",divQuill);
        quillEditor = document.querySelector("#quill-editor");
        console.log(quillEditor);
    }
    
    if ( quillEditor != null ) {

        Quill.register("modules/resize", QuillResizeImage);
        Quill.register({ "blots/mention": MentionBlot, "modules/mention": Mention });
        Quill.register(linkmentionBlot);
        let editor = new Quill('#quill-editor', { 
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
                    },
                    onSelect: function (item, insertItem) {
                        insertItem(item,false,"link-mention");
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
    if (imageUpload) {
        imageUpload.on('change', function (e) {
                let output = $('#previewImage');
                output.removeClass("d-none");
                let file = e.target.files[0];
                output.attr("src",URL.createObjectURL(file));
                output.parent().find("source").remove();
        });
    }

    if (imageUrl.length > 0) {
        imageUrl.on('change', function () {
            if( !$(this).is(':invalid') ){
                let srcImage = imageUrl.val();
                output.classList.remove("d-none");
                previewImage.attr('src',srcImage);
                output.parent().find("source").remove();

            }
        });
    }

    $('button[data-toggle="tab"]').on('shown.bs.tab', function (event) {
        $($(event.target).attr("data-target")).find("input").prop("required",true);
        $($(event.relatedTarget).attr("data-target")).find("input").prop("required",false);
    });
    function encodeHTML(s) {
        return s.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/"/g, '&quot;');
    }

    $.validator.addMethod( "maxsize", function( value, element, param ) {
        if ( this.optional( element ) ) {
            return true;
        }
        let size = param*1024;
        if ( $( element ).attr( "type" ) === "file" ) {
            if ( element.files && element.files.length ) {
                for ( var i = 0; i < element.files.length; i++ ) {
                    if ( element.files[ i ].size > size ) {
                        return false;
                    }
                }
            }
        }

        return true;
    }, $.validator.format( "File size must not exceed {0} kBytes each." ) );

    $.validator.addMethod( "maxWidth", function( value, element, param ) {
        if ( this.optional( element ) ) {
            return true;
        }

        if ( $( element ).attr( "type" ) === "file" ) {
            if ( element.files && element.files.length ) {
                for ( var i = 0; i < element.files.length; i++ ) {
                    if( element.files[ i ].type.match('image.*') ) {
                        let img = new Image();
                        img.src = URL.createObjectURL(element.files[ i ]);
                        img.onload = function() {
                            if (img.width > param) {
                                return false;
                            }
                        }
                    }
                }
            }
        }

        return true;
    }, $.validator.format( "Le fichier est trop large" ) );

    $.validator.addMethod( "maxHeight", function( value, element, param ) {
        if ( this.optional( element ) ) {
            return true;
        }

        if ( $( element ).attr( "type" ) === "file" ) {
            if ( element.files && element.files.length ) {
                for ( var i = 0; i < element.files.length; i++ ) {
                    if( element.files[ i ].type.match('image.*') ) {
                        let img = new Image();
                        img.src = URL.createObjectURL(element.files[ i ]);
                        img.onload = function() {
                            if (img.height > param) {
                                return false;
                            }
                        }
                    }
                }
            }
        }

        return true;
    }, $.validator.format( "Le fichier est trop large" ) );

    $.validator.addMethod( "dateLessThan", function( value, element, param ) {


        if ( this.optional( element ) ) {
            return true;
        }

        if ( $( element ).attr( "type" ) === "date" ) {
            let date = new Date(value);
            let dateEnd = new Date(param);
            if ( date < dateEnd ) {
                return false;
            }
        }

        return true;
    }, $.validator.format( "La date doit être plus petite." ) );



    $.validator.addMethod( "dateGreaterThan", function( value, element, param ) {
        if ( this.optional( element ) ) {
            return true;
        }

        if ( $( element ).attr( "type" ) === "date" ) {
            let date = new Date(value);
            let dateEnd = new Date(param);
            if ( date > dateEnd ) {
                return false;
            }
        }

        return true;
    }, $.validator.format( "La date doit être plus petite." ) );



    let form = $("#adminForm");
    if( form.length > 0 ) {
        console.log(form);
        form.validate({
            rules:{
                title:{
                    required:true,
                    minlength:5,
                    maxlength:255,
                    remote:window.appurl + "/admin/posts/title/"
                },
                image: {
                    required: true,
                    maxlength:255,
                    maxWidth:1280,
                    maxHeight:720,
                    maxsize: 4096,
                    extension: "jpg|jpeg|png|avif|webp"
                },
                imageUrl: {
                    required: function(){
                        return $("imageUrl").attr("required");
                    },
                    url: true
                },
                created_at:{
                    required:true,
                    date:true,
                    dateGreaterThan: new Date(),

                },
                email:{
                    required:true,
                    email:true,
                    minlength:15,
                    maxlength:255,
                },

                datestart:{
                    required:true,
                    date:true,
                },

                status:{
                    required:true,
                },

                dateend:{
                    required:true,
                    date:true,
                },

                tags:{
                    required:true

                }
            },
        });
    }

});
