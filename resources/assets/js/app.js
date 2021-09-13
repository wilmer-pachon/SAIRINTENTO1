
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.$ = window.jQuery = require('jquery');

window.Vue = require('vue');

import Vue from 'vue'
import VueAxios from 'vue-axios'
import VueSocialauth from 'vue-social-auth'
import swal from 'sweetalert2'
window.swal = swal;


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('rol', require('./components/Rol.vue'));
Vue.component('user', require('./components/User.vue'));
Vue.component('facebook', require('./components/Facebook.vue'));
Vue.component('notification', require('./components/Notification.vue'));


const app = new Vue({
    el: '#app',
    data :{
        menu : 0,
        notifications: []
    },
    created() {
        let me = this;
        Axios.post('notification/get').then(function(response) {
            // console.log(response.data);
            me.notifications=response.data;
        }).catch(function(error) {
            console.log(error);
        });

        var userId = $('meta[name="userId"]').attr('content');

        Echo.private('App.User.' + userId).notification((notification) => {
            me.notifications.unshift(notification);
        })
    }
});



Vue.use(VueAxios, axios);
Vue.use(VueSocialauth, {
    providers: {
        facebook: {
            clientId: '841915706688884',
            client_secret: '21a891720ef0b0e54079fb4e0a0a0d74',
            redirectUri: 'http://127.0.0.1:8000/login/facebook/callback'
        }
    }
});




// http://127.0.0.1:8000/auth/facebook/callback
// http://flagtick.com/auth/facebook/callback
