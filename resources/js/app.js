import Vue from 'vue';
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

require('./bootstrap');

window.Vue = require('vue').default;

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.use(Vuetify)

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify()
});
