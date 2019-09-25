import "./bootstrap";
import Vue from "vue";
import BootstrapVue from 'bootstrap-vue'

import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'bootstrap/dist/css/bootstrap.css'

//Route information for Vue Router
import Routes from "./routes.js";
import App from "./views/App";


Vue.use(BootstrapVue)

new Vue({
    el: '#app',
    data: () => ({
        drawer: null
    }),
    components: { App },
    router: Routes,
    render: h => h(App)
});