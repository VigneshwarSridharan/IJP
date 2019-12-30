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
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/site/add-post.js":
/*!***************************************!*\
  !*** ./resources/js/site/add-post.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _slicedToArray(arr, i) {
  return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _nonIterableRest();
}

function _nonIterableRest() {
  throw new TypeError("Invalid attempt to destructure non-iterable instance");
}

function _iterableToArrayLimit(arr, i) {
  if (!(Symbol.iterator in Object(arr) || Object.prototype.toString.call(arr) === "[object Arguments]")) {
    return;
  }

  var _arr = [];
  var _n = true;
  var _d = false;
  var _e = undefined;

  try {
    for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) {
      _arr.push(_s.value);

      if (i && _arr.length === i) break;
    }
  } catch (err) {
    _d = true;
    _e = err;
  } finally {
    try {
      if (!_n && _i["return"] != null) _i["return"]();
    } finally {
      if (_d) throw _e;
    }
  }

  return _arr;
}

function _arrayWithHoles(arr) {
  if (Array.isArray(arr)) return arr;
}

$('input.featured-image').on('change', function (event) {
  var src = URL.createObjectURL(event.target.files[0]);
  $(this).parents('.modal').find('.featured-image-upload').css({
    backgroundImage: "url(".concat(src, ")")
  });
  $upload.addClass('have-file');
});
$('.featured-image-upload').click(function () {
  $(this).parents('.modal').find('.featured-image').click();
});
var $upload = $('.featured-image-upload');
var droppedFiles = false;
$upload.on('drag dragstart dragend dragover dragenter dragleave drop', function (e) {
  e.preventDefault();
  e.stopPropagation();
}).on('dragover dragenter', function () {
  $upload.addClass('is-dragover');
}).on('dragleave dragend drop', function () {
  $upload.removeClass('is-dragover');
}).on('drop', function (e) {
  droppedFiles = e.originalEvent.dataTransfer.files;
  console.log(droppedFiles);
  var $fileInput = $('input.featured-image');

  var _$fileInput = _slicedToArray($fileInput, 1),
      fileContext = _$fileInput[0];

  console.log(fileContext);
  fileContext.files = droppedFiles;
  $fileInput.trigger('change');

  if (droppedFiles.length) {
    $upload.addClass('have-file');
  } // $('.featured-image').val(droppedFiles)

}); // $('#new-post .body-content').on('input', function () {
//     this.value = this.value.substr(0, 500);
//     $('#new-post .body-content-count').text(this.value.length + '/500')
// })

$('#new-post .submit').on('click', function () {
  $('#new-post form').find('[name="is_draft"]').val(0);
  $('#new-post form').submit();
});
$('#new-post .draft').on('click', function () {
  $('#new-post form').find('[name="is_draft"]').val(1);
  $('#new-post form').submit();
}); // jQuery.validator.setDefaults({
// });
// $('#new-post').on('show.bs.modal',function() {
// $('#new-post form').find('[name="image"]').prop('required',true)

$('#new-post form').validate({
  submitHandler: function submitHandler(form) {
    var $form = $(form);
    form.submit();
  },
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
  ignore: []
}); // })

/***/ }),

/***/ 2:
/*!*********************************************!*\
  !*** multi ./resources/js/site/add-post.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! D:\laravel\ijp\resources\js\site\add-post.js */"./resources/js/site/add-post.js");


/***/ })

/******/ });