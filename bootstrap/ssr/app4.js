import Quill from "quill";
import hljs from "highlight.js";
import { MentionBlot, Mention } from "quill-mention";
import QuillResizeImage from "quill-resize-image";
class linkmentionBlot extends MentionBlot {
  static render(data) {
    console.log(data);
    var element = document.createElement("span");
    element.classList.add("mention");
    var aelem = document.createElement("a");
    aelem.setAttribute("href", data.link);
    aelem.setAttribute("target", "_blank");
    aelem.innerHTML = data.value;
    element.appendChild(aelem);
    console.log(element);
    return element;
  }
}
linkmentionBlot.blotName = "link-mention";
$(document).on("click", "ul.nav li.parent > a ", function() {
  $(this).find("i").toggleClass("fa-minus");
});
$("#nav-image-upload").click(function(e) {
  $("#hiddenTypeImage").val("upload");
});
$("#nav-image-select").click(function(e) {
  $("#hiddenTypeImage").val("select");
});
$("#nav-image-url").click(function(e) {
  $("#hiddenTypeImage").val("url");
});
async function suggestArticle(searchTerm) {
  if (searchTerm.length > 1) {
    const response = await fetch(
      window.appurl + "/admin/posts/ajax/" + searchTerm,
      {
        headers: {
          "X-Requested-With": "XMLHttpRequest"
        }
      }
    ).then((response2) => response2.json()).then((data) => {
      return data;
    });
    return response.slice(0, 10);
  } else {
    return [];
  }
}
$(function() {
  if ($(".select2").length > 0) {
    $(".select2").select2({
      placeholder: "Choississez un tags",
      multiple: true,
      tags: true,
      ajax: {
        delay: 250,
        url: window.appurl + "/admin/tags/ajax",
        data: function(params) {
          var query = {
            term: params.term
          };
          return query;
        },
        dataType: "json"
      }
    }).val($("#preselectedtags").val().split(",")).trigger("change");
  }
  let quillEditor = document.querySelector("#quill-editor");
  if (quillEditor != null) {
    Quill.register("modules/resize", QuillResizeImage);
    Quill.register({ "blots/mention": MentionBlot, "modules/mention": Mention });
    Quill.register(linkmentionBlot);
    let editor = new Quill("#quill-editor", {
      theme: "snow",
      modules: {
        resize: {
          locale: {
            center: "center"
          }
        },
        toolbar: [[{ "header": [1, 2, false] }], ["bold", "italic", "underline", "strike"], ["blockquote", "code-block"], [{ "list": "ordered" }, { "list": "bullet" }], ["link", "image", "video"], ["clean"]],
        syntax: { hljs },
        mention: {
          minChars: 1,
          maxChars: 8,
          blotName: "link-mention",
          showDenotationChar: false,
          allowedChars: /^[A-Za-z]*$/,
          dataAttributes: ["id", "value", "denotationChar", "link"],
          mentionDenotationChars: ["@"],
          source: async function(searchTerm, renderList) {
            let values = await suggestArticle(searchTerm);
            renderList(values, searchTerm);
          },
          onSelect: function(item, insertItem) {
            insertItem(item, false, "link-mention");
          }
        }
      }
    });
    window.addEventListener("mention-hovered", (event) => {
      console.log("hovered: ", event);
    }, false);
    window.addEventListener("mention-clicked", (event) => {
      console.log("hovered: ", event);
    }, false);
    let quillValue = document.getElementById("quill-value");
    editor.on("text-change", function() {
      editor.root.querySelectorAll("blockquote").forEach(function(blockquote) {
        blockquote.classList.add("blockquote");
      });
      quillValue.value = editor.root.innerHTML;
    });
    editor.setHTML = (html) => {
      editor.root.innerHTML = html;
    };
    editor.getHTML = () => {
      return editor.root.innerHTML;
    };
    editor.setHTML(valpost);
  }
  let menu = document.getElementById("menu");
  let sidebar = $(".sidebar span.icon");
  let type = $("#type");
  let selectImage = $(".selectimage");
  if (menu != null) {
    document.getElementById("addMenu").addEventListener("click", function(e) {
      e.preventDefault();
      let name = document.getElementById("linkNameMenu").value;
      let link = document.getElementById("linkMenu").value;
      let row = document.querySelector("template").content;
      row.setAttributes("data-url", link);
      row.innerHtml = name + row.innerHtml;
      menu.appendChild(document.importNode(row, true));
      return true;
    });
    document.getElementById("submitMenu").addEventListener("click", function(e) {
      e.preventDefault();
      return true;
    });
  }
  if (sidebar.length > 0) {
    sidebar.find("em:first").addClass("fa-plus");
  }
  if ($("#menu-toggle").length > 0) {
    $("#menu-toggle").on("click", function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  }
  if (document.querySelector("#editor")) ;
  if (type.length > 0) {
    type.on("change", function() {
      var type2 = $(this).val();
      var duree = $("#duree"), datestart = $("#datestart"), dateend = $("#dateend");
      let types = ["job", "school", "exp"];
      if (!types.includes(type2)) {
        datestart.removeAttr("required");
        dateend.removeAttr("required");
        datestart.hide();
        $("label[for='" + datestart.attr("id") + "']").hide();
        dateend.hide();
        $("label[for='" + dateend.attr("id") + "']").hide();
        duree.show();
        $("label[for='" + duree.attr("id") + "']").show();
        duree.attr("required", "required");
      } else {
        datestart.show();
        $("label[for='" + datestart.attr("id") + "']").show();
        datestart.attr("required", "required");
        dateend.show();
        $("label[for='" + dateend.attr("id") + "']").show();
        dateend.attr("required", "required");
        duree.removeAttr("required");
        duree.hide();
        $("label[for='" + duree.attr("id") + "']").hide();
      }
    });
  }
  if (selectImage.length > 0) {
    selectImage.select2({
      width: "resolve",
      placeholder: "Choississez une image",
      ajax: {
        url: window.appurl + "/admin/files/ajax",
        data: function(params) {
          var query = {
            term: params.term
          };
          return query;
        }
      },
      templateResult: function(data) {
        let rowImage = data.text;
        if (rowImage != void 0) {
          console.log(rowImage);
          if (rowImage.includes("images/") == false) {
            rowImage = window.location.origin + "/images/" + rowImage;
          } else {
            rowImage = window.location.origin + rowImage;
          }
          console.log(rowImage);
          return $('<span><img src="' + rowImage + '" class="" style="max-width:50px; object-fit: contain; height: auto;" /> ' + data.name + "</span>");
        }
      }
    });
    let previewImage = $("#previewImage");
    let selectedImageId = $("#selectedImageId");
    let imageUrl = $("#imageUrl");
    let imageUpload = document.getElementById("imageUpload");
    if (imageUpload) {
      imageUpload.addEventListener("change", function(e) {
        let output = document.getElementById("previewImage");
        console.log(e.target.files[0]);
        output.src = URL.createObjectURL(e.target.files[0]);
        output.onload = function() {
          URL.revokeObjectURL(output.src);
        };
      });
    }
    if (imageUrl.length > 0) {
      imageUrl.on("change", function() {
        if (!$(this).is(":invalid")) {
          let srcImage = imageUrl.val();
          previewImage.attr("src", srcImage);
        }
      });
    }
    selectImage.on("select2:select", function(e) {
      var data = e.params.data;
      console.log(selectedImageId);
      console.log(data);
      selectedImageId.val(data.id);
      if (data.text.includes("images/") == false) {
        data.text = window.location.origin + "/images/" + data.text;
      }
      let srcImage = previewImage.attr("src");
      previewImage.attr("alt", srcImage);
      previewImage.attr("src", data.text);
    });
  }
});
