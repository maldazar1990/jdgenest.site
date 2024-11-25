import Quill from "quill";
import hljs from "highlight.js";
import { MentionBlot, Mention } from "quill-mention";
import QuillResizeImage from "quill-resize-image";
function _classCallCheck(instance, Constructor) {
  if (!(instance instanceof Constructor)) throw new TypeError("Cannot call a class as a function");
}
var _createClass = /* @__PURE__ */ function() {
  function defineProperties(target, props) {
    for (var i = 0; i < props.length; i++) {
      var descriptor = props[i];
      descriptor.enumerable = descriptor.enumerable || false, descriptor.configurable = true, "value" in descriptor && (descriptor.writable = true), Object.defineProperty(target, descriptor.key, descriptor);
    }
  }
  return function(Constructor, protoProps, staticProps) {
    return protoProps && defineProperties(Constructor.prototype, protoProps), staticProps && defineProperties(Constructor, staticProps), Constructor;
  };
}();
(function() {
  var ImagePicker, ImagePickerOption, both_array_are_equal, sanitized_options, indexOf = [].indexOf;
  jQuery.fn.extend({ imagepicker: function() {
    var opts = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {};
    return this.each(function() {
      var select;
      if ((select = jQuery(this)).data("picker") && select.data("picker").destroy(), select.data("picker", new ImagePicker(this, sanitized_options(opts))), null != opts.initialized) return opts.initialized.call(select.data("picker"));
    });
  } }), sanitized_options = function(opts) {
    var default_options;
    return default_options = { hide_select: true, show_label: false, initialized: void 0, changed: void 0, clicked: void 0, selected: void 0, limit: void 0, limit_reached: void 0, font_awesome: false }, jQuery.extend(default_options, opts);
  }, both_array_are_equal = function(a, b) {
    var i, j, len, x;
    if (!a || !b || a.length !== b.length) return false;
    for (a = a.slice(0), b = b.slice(0), a.sort(), b.sort(), i = j = 0, len = a.length; j < len; i = ++j) if (x = a[i], b[i] !== x) return false;
    return true;
  }, ImagePicker = function() {
    function ImagePicker2(select_element) {
      var opts1 = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {};
      _classCallCheck(this, ImagePicker2), this.sync_picker_with_select = this.sync_picker_with_select.bind(this), this.opts = opts1, this.select = jQuery(select_element), this.multiple = "multiple" === this.select.attr("multiple"), null != this.select.data("limit") && (this.opts.limit = parseInt(this.select.data("limit"))), this.build_and_append_picker();
    }
    return _createClass(ImagePicker2, [{ key: "destroy", value: function() {
      var j, len, ref;
      for (j = 0, len = (ref = this.picker_options).length; j < len; j++) ref[j].destroy();
      return this.picker.remove(), this.select.off("change", this.sync_picker_with_select), this.select.removeData("picker"), this.select.show();
    } }, { key: "build_and_append_picker", value: function() {
      return this.opts.hide_select && this.select.hide(), this.select.on("change", this.sync_picker_with_select), null != this.picker && this.picker.remove(), this.create_picker(), this.select.after(this.picker), this.sync_picker_with_select();
    } }, { key: "sync_picker_with_select", value: function() {
      var j, len, option, ref, results;
      for (results = [], j = 0, len = (ref = this.picker_options).length; j < len; j++) (option = ref[j]).is_selected() ? results.push(option.mark_as_selected()) : results.push(option.unmark_as_selected());
      return results;
    } }, { key: "create_picker", value: function() {
      return this.picker = jQuery("<ul class='thumbnails image_picker_selector'></ul>"), this.picker_options = [], this.recursively_parse_option_groups(this.select, this.picker), this.picker;
    } }, { key: "recursively_parse_option_groups", value: function(scoped_dom, target_container) {
      var container, j, k, len, len1, option, option_group, ref, ref1, results;
      for (j = 0, len = (ref = scoped_dom.children("optgroup")).length; j < len; j++) option_group = ref[j], option_group = jQuery(option_group), (container = jQuery("<ul></ul>")).append(jQuery("<li class='group_title'>" + option_group.attr("label") + "</li>")), target_container.append(jQuery("<li class='group'>").append(container)), this.recursively_parse_option_groups(option_group, container);
      for (ref1 = (function() {
        var l, len12, ref12, results1;
        for (results1 = [], l = 0, len12 = (ref12 = scoped_dom.children("option")).length; l < len12; l++) option = ref12[l], results1.push(new ImagePickerOption(option, this, this.opts));
        return results1;
      }).call(this), results = [], k = 0, len1 = ref1.length; k < len1; k++) option = ref1[k], this.picker_options.push(option), option.has_image() && results.push(target_container.append(option.node));
      return results;
    } }, { key: "has_implicit_blanks", value: function() {
      var option;
      return (function() {
        var j, len, ref, results;
        for (results = [], j = 0, len = (ref = this.picker_options).length; j < len; j++) (option = ref[j]).is_blank() && !option.has_image() && results.push(option);
        return results;
      }).call(this).length > 0;
    } }, { key: "selected_values", value: function() {
      return this.multiple ? this.select.val() || [] : [this.select.val()];
    } }, { key: "toggle", value: function(imagepicker_option, original_event) {
      var new_values, old_values, selected_value;
      if (old_values = this.selected_values(), selected_value = imagepicker_option.value().toString(), this.multiple ? indexOf.call(this.selected_values(), selected_value) >= 0 ? ((new_values = this.selected_values()).splice(jQuery.inArray(selected_value, old_values), 1), this.select.val([]), this.select.val(new_values)) : null != this.opts.limit && this.selected_values().length >= this.opts.limit ? null != this.opts.limit_reached && this.opts.limit_reached.call(this.select) : this.select.val(this.selected_values().concat(selected_value)) : this.has_implicit_blanks() && imagepicker_option.is_selected() ? this.select.val("") : this.select.val(selected_value), !both_array_are_equal(old_values, this.selected_values()) && (this.select.change(), null != this.opts.changed)) return this.opts.changed.call(this.select, old_values, this.selected_values(), original_event);
    } }]), ImagePicker2;
  }(), ImagePickerOption = function() {
    function ImagePickerOption2(option_element, picker) {
      var opts1 = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : {};
      _classCallCheck(this, ImagePickerOption2), this.clicked = this.clicked.bind(this), this.picker = picker, this.opts = opts1, this.option = jQuery(option_element), this.create_node();
    }
    return _createClass(ImagePickerOption2, [{ key: "destroy", value: function() {
      return this.node.find(".thumbnail").off("click", this.clicked);
    } }, { key: "has_image", value: function() {
      return null != this.option.data("img-src");
    } }, { key: "is_blank", value: function() {
      return !(null != this.value() && "" !== this.value());
    } }, { key: "is_selected", value: function() {
      var select_value;
      return select_value = this.picker.select.val(), this.picker.multiple ? jQuery.inArray(this.value(), select_value) >= 0 : this.value() === select_value;
    } }, { key: "mark_as_selected", value: function() {
      return this.node.find(".thumbnail").addClass("selected");
    } }, { key: "unmark_as_selected", value: function() {
      return this.node.find(".thumbnail").removeClass("selected");
    } }, { key: "value", value: function() {
      return this.option.val();
    } }, { key: "label", value: function() {
      return this.option.data("img-label") ? this.option.data("img-label") : this.option.text();
    } }, { key: "clicked", value: function(event) {
      if (this.picker.toggle(this, event), null != this.opts.clicked && this.opts.clicked.call(this.picker.select, this, event), null != this.opts.selected && this.is_selected()) return this.opts.selected.call(this.picker.select, this, event);
    } }, { key: "create_node", value: function() {
      var image, imgAlt, imgClass, thumbnail;
      return this.node = jQuery("<li/>"), this.option.data("font_awesome") ? (image = jQuery("<i>")).attr("class", "fa-fw " + this.option.data("img-src")) : (image = jQuery("<img class='image_picker_image'/>")).attr("src", this.option.data("img-src")), thumbnail = jQuery("<div class='thumbnail'>"), (imgClass = this.option.data("img-class")) && (this.node.addClass(imgClass), image.addClass(imgClass), thumbnail.addClass(imgClass)), (imgAlt = this.option.data("img-alt")) && image.attr("alt", imgAlt), thumbnail.on("click", this.clicked), thumbnail.append(image), this.opts.show_label && thumbnail.append(jQuery("<p/>").html(this.label())), this.node.append(thumbnail), this.node;
    } }]), ImagePickerOption2;
  }();
}).call(void 0);
class linkmentionBlot extends MentionBlot {
  static render(data) {
    var element = document.createElement("span");
    element.classList.add("mention");
    var aelem = document.createElement("a");
    aelem.setAttribute("href", data.link);
    aelem.setAttribute("target", "_blank");
    aelem.innerHTML = data.value;
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
function isDeltaEmptyOrWhitespace(delta) {
  if (delta.ops.length === 0) {
    return true;
  }
  for (let i = 0; i < delta.ops.length; i++) {
    if (delta.ops[i].insert.trim() !== "") {
      return false;
    }
  }
  return true;
}
function validateInputFile(element, minWidth = 0, minHeight = 0, maxwidth = 0, maxheight = 0, extension = "", hash = "") {
  if (element.files.length > 0) {
    let file = element.files[0];
    let fileName = file.name;
    let fileExtension = fileName.split(".").pop();
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
    image.onload = function() {
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
    };
  }
}
function validateTitleInput(element) {
  let valid = true;
  let model = element.dataset.model;
  if (model !== null) {
    let url = "";
    let appUrl = window.appurl;
    if (appUrl.indexOf("https:") === 0) {
      appUrl = "https:" + appUrl;
    }
    switch (model) {
      case "posts":
        url = new URL(appUrl + `/admin/posts/title`);
        break;
      case "infos":
        url = new URL(appUrl + `/admin/infos/title`);
        break;
      case "tags":
        url = new URL(happUrl + `/admin/tags/title`);
        break;
      case "files":
        url = new URL(appUrl + `/admin/files/title`);
        break;
    }
    if (url != "") {
      let params = { title: element.value };
      Object.keys(params).forEach((key) => url.searchParams.append(key, params[key]));
      let minlength = element.getAttribute("minlength");
      if (minlength > 0 && element.value.length > minlength) {
        fetch(url, {
          headers: {
            "X-Requested-With": "XMLHttpRequest"
          }
        }).then((response) => response.json()).then((data) => {
          console.log(data);
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
    });
  }
  let quillEditor = document.querySelector("#quill-editor");
  let quillValue = document.getElementById("quill-value");
  let editor = null;
  if (!quillEditor && quillValue != null) {
    let divQuill = document.createElement("div");
    divQuill.setAttribute("id", "quill-editor");
    divQuill.classList.add("mb-3");
    divQuill.style.height = "300px";
    quillValue.insertAdjacentElement("afterend", divQuill);
    quillEditor = document.querySelector("#quill-editor");
  }
  if (quillEditor != null) {
    Quill.register("modules/resize", QuillResizeImage);
    Quill.register({ "blots/mention": MentionBlot, "modules/mention": Mention });
    Quill.register(linkmentionBlot);
    let searchterm = "";
    editor = new Quill("#quill-editor", {
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
            searchterm = searchTerm;
          },
          onSelect: function(item, insertItem) {
            editor.deleteText(editor.getSelection().index - searchterm.length - 1, searchterm.length + 1);
            var delta = {
              ops: [
                { retain: editor.getSelection().index },
                { insert: item.value, attributes: { link: item.link } }
              ]
            };
            editor.updateContents(delta);
          }
        }
      }
    });
    editor.on("text-change", function(delta, oldDelta, source) {
      editor.root.querySelectorAll("blockquote").forEach(function(blockquote) {
        blockquote.classList.add("blockquote");
      });
      quillValue.value = editor.root.innerHTML;
    });
    window.addEventListener("mention-hovered", (event) => {
      console.log("hovered: ", event);
    }, false);
    window.addEventListener("mention-clicked", (event) => {
      console.log("hovered: ", event);
    }, false);
    if (quillValue.value != "") {
      editor.root.querySelectorAll("blockquote").forEach(function(blockquote) {
        blockquote.classList.add("blockquote");
      });
      quillValue.value = editor.root.innerHTML;
    }
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
  let previewImage = $("#previewImage");
  let imageUrl = $("#imageUrl");
  let imageUpload = $("#imageUpload");
  if (imageUpload) {
    imageUpload.on("change", function(e) {
      let output2 = $("#previewImage");
      output2.removeClass("d-none");
      if (e.target.files.length > 0) {
        let file = e.target.files[0];
        output2.attr("src", URL.createObjectURL(file));
        output2.parent().find("source").remove();
      } else {
        previewImage.attr("src", window.appurl + "/images/default.webp");
      }
    });
  }
  if (imageUrl.length > 0) {
    imageUrl.on("change", function() {
      if (!$(this).is(":invalid")) {
        let srcImage = imageUrl.val();
        output.classList.remove("d-none");
        previewImage.attr("src", srcImage);
        output.parent().find("source").remove();
      }
    });
  }
  $('button[data-toggle="tab"]').on("shown.bs.tab", function(event) {
    $($(event.target).attr("data-target")).find("input").prop("required", true);
    $($(event.relatedTarget).attr("data-target")).find("input").prop("required", false);
  });
  let form = document.querySelector("#adminForm");
  if (form) {
    form.querySelectorAll("input").forEach(function(input) {
      if (input.getAttribute("type") == "file") {
        input.addEventListener("input", function(e) {
          if (input.hasAttribute("data-minwidth") && input.hasAttribute("data-minheight") || input.hasAttribute("data-maxwidth") && input.hasAttribute("data-maxheight")) {
            let minwidth = decodeURI(input.dataset.minwidth);
            let minheight = decodeURI(input.dataset.minheight);
            let maxwidth = decodeURI(input.dataset.maxwidth);
            let maxheight = decodeURI(input.dataset.maxheight);
            let extension = "";
            let hash = input.dataset.havehash;
            if (input.hasAttribute("data-extension")) {
              extension = input.dataset.extension;
            }
            validateInputFile(input, minwidth, minheight, maxwidth, maxheight, extension, hash);
          }
        });
      }
      if (input.id === "title") {
        if (input.hasAttribute("data-model")) {
          input.addEventListener("input", function(e) {
            validateTitleInput(input);
          });
        }
      }
      if (input.id === "name") {
        if (input.hasAttribute("data-model")) {
          input.addEventListener("input", function(e) {
            validateTitleInput(input);
          });
        }
      }
      if (input.id === "datestart") {
        if (input.hasAttribute("data-dateend")) {
          input.addEventListener("input", function(e) {
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
        if (input.hasAttribute("data-datestart")) {
          input.addEventListener("input", function(e) {
            let date = new Date(input.value);
            let elemDateStart = document.getElementById(input.dataset.datestart);
            if (datestart) {
              let datestart2 = new Date(elemDateStart.value);
              if (date < datestart2) {
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
    form.addEventListener("submit", function(e) {
      e.preventDefault();
      if (editor) {
        let content = isDeltaEmptyOrWhitespace(editor.getContents());
        if (content) {
          editor.focus();
          editor.insertText(0, "MANQUE UN TEXTE!!!!!!!!", "bold", true);
          return false;
        }
        if (editor.getLength() < 100) {
          editor.focus();
          editor.insertText(0, "MANQUE UN TEXTE!!!!!!!!", "bold", true);
          return false;
        }
      }
      {
        form.submit();
      }
    });
  }
  let imagePicker = $(".image-picker");
  console.log(1);
  if (imagePicker.length > 0) {
    console.log(imagePicker);
    imagePicker.imagepicker();
    imagePicker.on("change", function(e) {
      let src = $(this).find("option:selected").data("img-src");
      if (src) {
        $("#previewImage").attr("src", src);
        $("#collapseimagepicker").collapse("hide");
      }
    });
  }
});
