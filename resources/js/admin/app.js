import $ from 'jquery';
import ckeditor from 'ckeditor5-build-full';
import './bootstrap/bootstrap.bundle.min.js';
import  'select2';
$(document).on("click","ul.nav li.parent > a ", function(){
    $(this).find('i').toggleClass("fa-minus");
});
let select = $(".select2");
if(select.length > 0) {
    select.select2({
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
        ckeditor.create(document.getElementById("editor"), {
            // https://ckeditor.com/docs/ckeditor5/latest/getting-started/setup/toolbar/toolbar.html#extended-toolbar-configuration-format
            toolbar: {
                items: [
                    'exportPDF','exportWord', '|',
                    'findAndReplace', 'selectAll', '|',
                    'heading', '|',
                    'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                    'bulletedList', 'numberedList', 'todoList', '|',
                    'outdent', 'indent', '|',
                    'undo', 'redo',
                    '-',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                    'alignment', '|',
                    'link', 'uploadImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
                    'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                    'textPartLanguage', '|',
                    'sourceEditing'
                ],
                shouldNotGroupWhenFull: true
            },
            // Changing the language of the interface requires loading the language file using the <script> tag.
            // language: 'es',
            list: {
                properties: {
                    styles: true,
                    startIndex: true,
                    reversed: true
                }
            },
            // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                    { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                    { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                    { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                ]
            },
            // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
            placeholder: 'Welcome to CKEditor 5!',
            // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
            fontFamily: {
                options: [
                    'default',
                    'Arial, Helvetica, sans-serif',
                    'Courier New, Courier, monospace',
                    'Georgia, serif',
                    'Lucida Sans Unicode, Lucida Grande, sans-serif',
                    'Tahoma, Geneva, sans-serif',
                    'Times New Roman, Times, serif',
                    'Trebuchet MS, Helvetica, sans-serif',
                    'Verdana, Geneva, sans-serif'
                ],
                supportAllValues: true
            },
            // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
            fontSize: {
                options: [ 10, 12, 14, 'default', 18, 20, 22 ],
                supportAllValues: true
            },
            // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
            // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
            htmlSupport: {
                allow: [
                    {
                        name: /.*/,
                        attributes: true,
                        classes: true,
                        styles: true
                    }
                ]
            },
            // Be careful with enabling previews
            // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
            htmlEmbed: {
                showPreviews: false
            },
            // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
            link: {
                decorators: {
                    addTargetToExternalLinks: true,
                    defaultProtocol: 'https://',
                    toggleDownloadable: {
                        mode: 'manual',
                        label: 'Downloadable',
                        attributes: {
                            download: 'file'
                        }
                    }
                }
            },
            // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
           
            // The "superbuild" contains more premium features that require additional configuration, disable them below.
            // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
            removePlugins: [
                // These two are commercial, but you can try them out without registering to a trial.
                // 'ExportPdf',
                // 'ExportWord',
                'AIAssistant',
                'CKBox',
                'CKFinder',
                'EasyImage',
                // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
                // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
                // Storing images as Base64 is usually a very bad idea.
                // Replace it on production website with other solutions:
                // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
                // 'Base64UploadAdapter',
                'MultiLevelList',
                'RealTimeCollaborativeComments',
                'RealTimeCollaborativeTrackChanges',
                'RealTimeCollaborativeRevisionHistory',
                'PresenceList',
                'Comments',
                'TrackChanges',
                'TrackChangesData',
                'RevisionHistory',
                'Pagination',
                'WProofreader',
                // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
                // from a local file system (file://) - load this site via HTTP server if you enable MathType.
                'MathType',
                // The following features are part of the Productivity Pack and require additional license.
                'SlashCommand',
                'Template',
                'DocumentOutline',
                'FormatPainter',
                'TableOfContents',
                'PasteFromOfficeEnhanced',
                'CaseChange'
            ]
        });
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
