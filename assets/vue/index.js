import Vue from 'vue';
import App from './app';
// Axios
import axios from 'axios';
// Loader
import Loading from 'vue-loading-overlay';
// Bootstrap typeahead
import VueBootstrapTypeahead from 'vue-bootstrap-typeahead'
// Lodash
window._ = require('lodash');

// Axios
Vue.prototype.$axios = axios;

// Use loader
Vue.use(Loading);

// Typeahead
Vue.component('vue-bootstrap-typeahead', VueBootstrapTypeahead);

new Vue({
    template: '<App/>',
    components: {App},
}).$mount('#app');
