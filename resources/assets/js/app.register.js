
require('./helpers.js');


import SearchBox from './components/SearchBox.vue';
Vue.component('searchbox',SearchBox);

import GridView from './components/GridView.vue';
Vue.component('gridview', GridView);


import App from './components/App.vue';
Vue.component('app-main',App);



/********************
 * 
********************/
import VillaList from './components/villa/VillaList.vue';
Vue.component('villa-list',VillaList);

import VillaForm from './components/villa/VillaForm.vue';
Vue.component('villa-form',VillaForm);


/********************
 * 
********************/
import BillForm from './components/bill/BillForm.vue';
Vue.component('contractBill',BillForm);


