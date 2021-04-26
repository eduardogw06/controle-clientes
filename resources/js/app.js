require('./bootstrap');

window.Vue = require('vue');

Vue.component('client-control-component', require('./components/ClientControlComponent.vue').default);
Vue.component('register-component', require('./components/RegisterComponent.vue').default);
Vue.component('clients-component', require('./components/ClientsComponent.vue').default);
Vue.component('address-component', require('./components/AddressComponent.vue').default);

const app = new Vue({
    el: '#app',
});
