/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/script.js":
/*!********************************!*\
  !*** ./resources/js/script.js ***!
  \********************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  if ($('.select2').length) {
    $('.select2').select2();
  }

  $('.modal').on('hidden.bs.modal', function () {
    $(this).find('form').each(function (k, form) {
      $(form).find('select.select2').html('');
      $(form).find('.preview').html('');
      form.reset();
      $(form).find('select.select2').trigger('change');
      $(form).find('.custom-file .custom-file-label').html('Choose file');
      $(form).validate().resetForm(); // $(form).validate().destroy();

      tinyMCE.activeEditor.setContent('');
    });
  });
  tinymce.init({
    selector: '#mytextarea',
    plugins: "wordcount link",
    max_chars: "10",
    setup: function setup(editor) {
      editor.on('keydown', function (e) {
        if ([8, 9].includes(e.keyCode)) return;

        if (editor.plugins.wordcount.body.getWordCount() >= 10) {
          e.preventDefault();
          e.stopPropagation();
        }

        $('#mytextarea').val(editor.getContent().trim());
      });
    }
  });
  $(document).on('focusin', function (e) {
    if ($(event.target).closest(".tox").length) {
      e.stopImmediatePropagation();
    }
  });
  $('.custom-file input').change(function (e) {
    $(this).next('.custom-file-label').html(e.target.files[0].name);
  });
  $(document).on('show.bs.modal', '.modal', function (event) {
    var zIndex = 1040 + 10 * $('.modal:visible').length;
    $(this).css('z-index', zIndex);
    setTimeout(function () {
      $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
    }, 0);
  });
  $('[data-post]').on('click', function () {
    var id = $(this).data('post');
    console.log(id);
    $('#post-' + id).modal('show');
    $.ajax({
      url: "posts/".concat(id, "/comments"),
      dataType: 'json',
      success: function success(_ref) {
        var status = _ref.status,
            response = _ref.response;

        if (status == 'success') {
          $('#comments-' + id).html("\n                        <div class=\"list-group mb-3\">\n                        ".concat(response.map(function (item) {
            return "\n                                    <div class=\"list-group-item d-flex align-items-center justify-content-between\">\n                                        <div>".concat(item.comment, "</div>\n                                        <img src=\"").concat(storage(item.avatar), "\" class=\"rounded-circle\" height=\"40\" />\n                                    </div>\n                                    ");
          }).join(''), "\n                        </div>"));
        }

        console.log(response);
      }
    });
  });
  $('.add-comment').each(function (k, el) {
    $(el).validate({
      errorElement: 'span',
      errorPlacement: function errorPlacement(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function highlight(element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function unhighlight(element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      },
      submitHandler: function submitHandler(form) {
        var $form = $(form);
        var text = $form.find('[type="submit"]').html();
        $form.find('[type="submit"]').html("<i class=\"fas fa-spinner fa-pulse\"></i>").attr('disabled', 'disabled');
        var data = $form.serializeArray();
        var id = $form.find('[name="post_id"]').val();
        $.ajax({
          url: "posts/".concat(id, "/comments"),
          method: 'POST',
          dataType: 'json',
          data: data,
          success: function success(_ref2) {
            var status = _ref2.status,
                response = _ref2.response;
            form.reset();

            if (status == 'success') {
              $('#comments-' + id + ' .list-group').prepend("\n                            <div class=\"list-group-item d-flex align-items-center justify-content-between\">\n                                <div>".concat(response.comment, "</div>\n                                <img src=\"").concat(storage(response.avatar), "\" class=\"rounded-circle\" height=\"40\" />\n                            </div>\n                            "));
              $form.find('[type="submit"]').html(text).removeAttr('disabled');
              var count = Number($('.post-info .comment-' + id).eq(0).find('span').text());
              $('.post-info .comment-' + id).addClass('text-primary').find('span').text(count + 1);
            }
          }
        });
      }
    });
  });
});

/***/ }),

/***/ 1:
/*!**************************************!*\
  !*** multi ./resources/js/script.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! D:\laravel\ijp\resources\js\script.js */"./resources/js/script.js");


/***/ })

/******/ });