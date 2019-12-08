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
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/site/welcome.js":
/*!**************************************!*\
  !*** ./resources/js/site/welcome.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var _location = location,
    hash = _location.hash;
hash = hash.replace('#/', '');

if (hash == 'login') {
  $('#loginModal').modal('show');
}

if (hash == 'register') {
  $('#registerModal').modal('show');
}

console.log(hash);

var loginSubmitHandler = function loginSubmitHandler(form) {
  var $form = $(form);
  $form.find('[type="submit"]').html("<i class=\"fas fa-spinner fa-pulse\"></i>").attr('disabled', 'disabled');
  var data = $form.serializeArray();
  $.ajax({
    url: '/checkLogin',
    method: 'POST',
    dataType: 'json',
    data: data,
    success: function success(res) {
      var data = res.data,
          status = res.status;

      if (status == 'success') {
        form.submit();
      } else {
        $form.find('[type="submit"]').html("Login").removeAttr('disabled');
        var $message = $form.find('.message');
        $message.html("\n                <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">\n                    ".concat(data, "\n                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\n                        <span aria-hidden=\"true\">&times;</span>\n                    </button>\n                </div>\n                ")).hide().animate({
          height: 'toggle'
        });
        setTimeout(function () {
          $message.animate({
            height: 'toggle'
          });
        }, 5000);
      }
    }
  });
};

$.validator.addMethod("pwcheck", function (value) {
  return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
  && /[a-z]/.test(value) // has a lowercase letter
  && /\d/.test(value); // has a digit
});
$('.login-form').validate({
  rules: {
    password: {
      // pwcheck: true,
      minlength: 8
    }
  },
  messages: {
    username: "Please enter your username",
    password: {
      required: "Please enter your password",
      // pwcheck: 'Your password contain at least one number and have a mixture of uppercase and lowercase letters',
      minlength: 'Your password must be at least 8 characters.'
    }
  },
  submitHandler: loginSubmitHandler
});

var registerSubmitHandler = function registerSubmitHandler(form) {
  var $form = $(form);
  var data = $form.serializeArray();
  $form.find('[type="submit"]').html("<i class=\"fas fa-spinner fa-pulse\"></i>").attr('disabled', 'disabled');
  $.ajax({
    url: '/checkRegister',
    dataType: 'json',
    method: 'POST',
    data: data,
    success: function success(_ref) {
      var status = _ref.status,
          data = _ref.data;

      if (status === 'success') {
        form.submit();
      } else {
        $form.find('[type="submit"]').html('Register').removeAttr('disabled');
        var $message = $form.find('.message');
        $message.html("\n                    <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">\n                        ".concat(data, "\n                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\n                            <span aria-hidden=\"true\">&times;</span>\n                        </button>\n                    </div>\n                ")).hide().animate({
          height: 'toggle'
        });
        setTimeout(function () {
          $message.animate({
            height: 'toggle'
          });
        }, 5000);
      }
    }
  });
};

$('.register-form').validate({
  rules: {
    password: {
      required: true,
      pwcheck: true,
      minlength: 8
    }
  },
  messages: {
    name: 'Please enter your full name',
    email: 'Please enter your email',
    password: {
      required: 'Please Enter your password',
      pwcheck: 'Required number and lower and upper case letters',
      minlength: 'Your password must be at least 8 characters.'
    }
  },
  submitHandler: registerSubmitHandler
});

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!**********************************************************************!*\
  !*** multi ./resources/js/site/welcome.js ./resources/sass/app.scss ***!
  \**********************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! D:\laravel\ijp\resources\js\site\welcome.js */"./resources/js/site/welcome.js");
module.exports = __webpack_require__(/*! D:\laravel\ijp\resources\sass\app.scss */"./resources/sass/app.scss");


/***/ })

/******/ });