/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
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
/******/ 	// identity function for calling harmony imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
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
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 256);
/******/ })
/************************************************************************/
/******/ ({

/***/ 10:
/***/ (function(module, exports) {

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var ErrorValidations = function () {
    function ErrorValidations() {
        _classCallCheck(this, ErrorValidations);

        var that = this;
        this.errors = {};

        this.exceptions = {
            errors: [],
            add: function add(name, description) {
                that.errorExceptions.errors.push({
                    name: name,
                    description: description });
            }
        };
    }

    _createClass(ErrorValidations, [{
        key: 'get',
        value: function get(field) {
            if (this.errors[field]) {
                if (this.errors[field] instanceof Array) {
                    return this.errors[field][0];
                } else {
                    return this.errors[field];
                }
            }
            return "";
        }
    }, {
        key: 'register',
        value: function register(errors) {
            this.errors = errors;
        }
    }, {
        key: 'clear',
        value: function clear(field) {

            if (this.errors[field]) {
                delete this.errors[field][0];
            }
        }
    }]);

    return ErrorValidations;
}();

var AxiosRequest = function () {
    function AxiosRequest() {
        _classCallCheck(this, AxiosRequest);
    }

    _createClass(AxiosRequest, [{
        key: 'post',
        value: function post(controller, action, data) {

            return axios.post('/api/' + controller + '/' + action, data);
        }
    }, {
        key: 'get',
        value: function get(controller, action) {
            var qs = "";
            if (arguments.length >= 3) {
                for (var i = 2; i < arguments.length; i++) {
                    qs += arguments[i] + '/';
                }
            }
            qs = qs.substring(0, qs.length - 1);
            var url = '/api/' + controller + '/' + action + (qs !== "" ? "/" + qs : qs);

            return axios.get(url);
        }
    }, {
        key: 'route',
        value: function route(url) {
            var img = window.imagePath;
            window.location.href = url;

            return this;
        }
    }, {
        key: 'redirect',
        value: function redirect(controller, action) {
            var data = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;


            var baseUrl = window.Laravel.baseUrl;

            var url = baseUrl + "/" + controller + "/" + (action !== null ? action : "") + (data !== null ? "/" + data : "");
            window.location.href = url;
        }
    }, {
        key: 'postMultiForm',
        value: function postMultiForm(controller, action, formData) {
            return $.ajax({
                url: '/api/' + controller + '/' + action,
                type: 'POST',
                data: formData,
                headers: { 'X-CSRF-TOKEN': window.Laravel.csrfToken },
                processData: false,
                contentType: false
            });
        }
    }]);

    return AxiosRequest;
}();

var MomentDateFormat = function () {
    function MomentDateFormat() {
        _classCallCheck(this, MomentDateFormat);
    }

    _createClass(MomentDateFormat, [{
        key: 'format',
        value: function format(carbonDate) {
            moment(carbonDate).format('dd/MM/yyyy');
        }
    }]);

    return MomentDateFormat;
}();

window.ErrorValidations = function () {

    return {
        newInstance: function newInstance() {
            return new ErrorValidations();
        }
    };
}();

window.AjaxRequest = new AxiosRequest();

window.objectClone = function (objInstance) {
    return JSON.parse(JSON.stringify(objInstance));
};

/***/ }),

/***/ 256:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(10);


/***/ })

/******/ });