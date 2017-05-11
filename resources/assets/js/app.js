
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

Vue.use(VueRouter);

Vue.use(VeeValidate);

/**************************
*
*
**************************/
require('./app.register.js');

require('./app.component.js');

import VillaList from './components/villa/VillaList.vue';
import VillaForm from './components/villa/VillaForm.vue';
import App from './components/App.vue';
import BillReadable from './components/bill/BillReadable.vue';
import BillForm from './components/bill/BillForm.vue';
import BillUpdateForm from './components/bill/BillUpdateForm.vue';

Vue.filter('toDateFormat', (value) => {return moment(value).format('L');});


new Vue({
    el: "#mainApp",
    components: {
        'appMain': App,
        'contractBill': BillForm,
        'billReadable': BillReadable,
        'villaList': VillaList,
        'villaForm': VillaForm,
        'billUpdateForm': BillUpdateForm
    }
});





