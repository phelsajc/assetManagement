require('./bootstrap');
/* import 'admin-lte/dist/css/adminlte.min.css';
import 'admin-lte/dist/js/adminlte.min.js'; */

//require('./adminlte.min.js');

import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

//import './adminlte.min.js';

//Router Imported
import {routes} from './routes'

// Import User Class
import User from './Helpers/User'
window.User = User

// Import Notification Class
import Notification from './Helpers/Notification'
window.Notification = Notification

//Sweetalert2
import Swal from 'sweetalert2';
window.Swal = Swal;


// Enable pusher logging - don't include this in production
/* Pusher.logToConsole = true;
var pusher = new Pusher('c402de2de282196d6d97', {
  cluster: 'ap1'
});
var channel = pusher.subscribe('popup-channel');
channel.bind('user-register', function(data) {
  app.messages.push(JSON.stringify(data));
}); */

/* Vue.component('Autocomplete',require('./components/Autocomplete.vue')); */
/* require('./components/Autocomplete.vue').default */

import VuePdfApp from "vue-pdf-app";
window.VuePdfApp = VuePdfApp;
Vue.component('equipmentModal', require('./components/modals/equipment.vue').default);
Vue.component('equipmentComponent', require('./components/Equipment.vue').default);
Vue.component('RegisterEquipment', require('./components/RegisterEquipment.vue').default);
Vue.component('user-info', require('./components/User.vue').default);
Vue.component('navComponent', require('./components/template/nav.vue').default);
Vue.component('sidemenuComponent', require('./components/template/sidemenu.vue').default);
Vue.component('footerComponent', require('./components/template/footer.vue').default);
Vue.component('loaderComponent', require('./components/template/loader.vue').default);
Vue.component('products', require('./components/Products.vue').default);

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

window.Toast = Toast
  

const router = new VueRouter({
    routes,
    mode:'history'
})
    

const app = new Vue({
    el: '#app',
    router,
    data() {
        return {
            bladeValue: '',
            showModal: false,
            isLogin: 'xxxx',
            messages: [],
        }
    }
});
