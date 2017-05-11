
window._ = require('lodash');

window.bbox = require('bootbox');

window.toastr = require('toastr');

/**
 * Moment Js
 ****************/
window.moment = require('moment');



try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap-sass');
} catch (e) {}

window.accounting = require('accounting-js');

