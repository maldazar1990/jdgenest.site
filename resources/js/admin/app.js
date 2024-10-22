import hljs from 'highlight.js';

import "../../../node_modules/highlight.js/styles/vs2015.css";
Quill.register("modules/resize", window.QuillResizeImage);
// Or if you only need the core build
// import Quill from 'quill/core';
$(document).on("click","ul.nav li.parent > a ", function(){
    $(this).find('i').toggleClass("fa-minus");
});
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
    }).val($("#preselectedtags").val().split(",")).trigger("change");
}

$("#nav-image-upload").click(function (e) {
    $("#hiddenTypeImage").val("upload");
});
$("#nav-image-select").click(function (e) {
    $("#hiddenTypeImage").val("select");
});
$("#nav-image-url").click(function (e) {
    $("#hiddenTypeImage").val("url");
});

$(function () {


    var editor = new Quill('#quill-editor', { 
        theme: 'snow',
        modules: { 
            resize: {
                locale: {
                  center: "center",
                },
              },
            toolbar: [ [{ 'header': [1, 2, false] }], ['bold', 'italic', 'underline', 'strike'], ['blockquote', 'code-block'], [{ 'list': 'ordered' }, { 'list': 'bullet' }], ['link', 'image', 'video'], ['clean'] ],
            syntax: { hljs },
        }
    }); 

    let quillValue = document.getElementById('quill-value');
    editor.on('text-change', function() {
        editor.root.querySelectorAll("blockquote").forEach(function(blockquote) {
            blockquote.classList.add("blockquote");
        });

        quillValue.value = editor.root.innerHTML;
    });

    editor.setHTML = (html) => { 
        editor.root.innerHTML = html; 
    }
    editor.getHTML = () => {
        return editor.root.innerHTML;
    };
    editor.setHTML(valpost);


    let menu = document.getElementById("menu");
    let sidebar = $(".sidebar span.icon");
    let type = $("#type");
    let selectImage = $(".selectimage");
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
    if (type.length>0) {
        type.on('change',function () {
            var type = $(this).val();
            var duree = $("#duree"),
                datestart = $("#datestart"),
                dateend = $("#dateend");
            let types = ["job", "school", "exp"];
            if (!types.includes(type)) {
                datestart.removeAttr("required");
                dateend.removeAttr("required");
                datestart.hide();
                $("label[for='" + datestart.attr('id') + "']").hide();
                dateend.hide();
                $("label[for='" + dateend.attr('id') + "']").hide();

                duree.show();
                $("label[for='" + duree.attr('id') + "']").show();

                duree.attr("required", "required");
            } else {
                datestart.show();
                $("label[for='" + datestart.attr('id') + "']").show();

                datestart.attr("required", "required");
                dateend.show();
                $("label[for='" + dateend.attr('id') + "']").show();

                dateend.attr("required", "required");
                duree.removeAttr("required");
                duree.hide();
                $("label[for='" + duree.attr('id') + "']").hide();

            }
        });
    }
    
    if (selectImage.length > 0) {
        selectImage.select2({
            width: 'resolve',
            placeholder: "Choississez une image",
            templateResult: function (data) {
                var baseurl = "/images/";

                return $('<span><img src="' + baseurl  + data.text.split(".")[0]+"_small.webp" + '" class="" style="max-width:50px; object-fit: contain; height: auto;" /> ' + data.text + '</span>');
            }
        });
    }


});
