/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from "vue";

import Axios from "axios";
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import Money from "v-money";

Vue.use(VueSweetalert2);
Vue.use(Money, { decimal: ",", thousands: ".", precision: 2, prefix: 'R$ ' });

Vue.prototype.$axios = Axios;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('product-category', require('./components/product-category/index.vue').default);


Axios.interceptors.response.use(
    response => response,
    error => {
        const { response } = error;

        if (response && response.status === 500) {
            Vue.prototype.$swal.fire(
                "Erro",
                "Oops! Algo deu errado.",
                "error"
            );
        }
        if (response && response.status === 422) {
            let message = '';
            Object.keys(response.data.errors).forEach(item => {
                let field = response.data.errors[item];
                for (let i = 0; i < field.length; i++) {
                    message += field[i] + "<br />";
                }
            });

            Vue.prototype.$swal.fire(
                "Erro",
                message,
                "error"
            );
        }
        return Promise.reject(error);
    }
);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
