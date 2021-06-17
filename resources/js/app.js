require('./bootstrap');

require('alpinejs');

import swal from 'sweetalert';

import Vue from 'vue/dist/vue.js';

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('posters-component', require('./components/PostersComponent.vue').default);

var app = new Vue({
    el: '#app',
    methods: {
        open () {}
    },
});