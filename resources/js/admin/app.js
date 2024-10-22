import Quill from 'quill';
// Or if you only need the core build
// import Quill from 'quill/core';

const container = document.getElementById('editor');
const quill = new Quill(container);
const options = {
    debug: 'info',
    modules: {
      toolbar: true,
    },
    placeholder: 'Compose an epic...',
    theme: 'snow'
  };
console.log(quill, options);
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
            placeholder: "Choississez une image",
            templateResult: function (data) {
                var baseurl = "/images/";

                return $('<span><img src="' + baseurl  + data.text.split(".")[0]+"_small.webp" + '" class="" style="max-width:50px; object-fit: contain; height: auto;" /> ' + data.text + '</span>');
            }
        });
    }


});
