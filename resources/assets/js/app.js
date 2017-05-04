
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');




/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */
window.Vue = require('vue');




/**************************
 * Vue Event
 *
 **************************/
window.VueEvent = new Vue();





/**
 * Vue Router include in vue
 */
import VueRouter from 'vue-router';

import VeeValidate from 'vee-validate';

const config = {
    errorBagName: 'verrors'
}

Vue.use(VueRouter);

Vue.use(VeeValidate);



/**************************
*
*
**************************/
require('./app.register.js');

require('./app.component.js');



new Vue({
    el: "#mainApp"
});





