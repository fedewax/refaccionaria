/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use(BootstrapVue)

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('principal-component', require('./components/principalComponent.vue').default);
Vue.component('crud-usuarios-component', require('./components/crudUsuariosComponent.vue').default);
Vue.component('crud-productos-component', require('./components/crudProductosComponent.vue').default);


const app = new Vue({
    el: '#app',
    data() {
        return {
            menu : 0 
        }
    },
    methods: {
        logout() {
    		document.getElementById('logout-form').submit();
    	}
    },
});
