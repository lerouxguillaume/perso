import Vue from 'vue'
import App from './App.vue'
import BootstrapVue from 'bootstrap-vue'
import VueMoment from 'vue-moment'
import VueApexCharts from 'vue-apexcharts'
import './assets/custom.scss'
import router from './router.js'
import './filter.js'
import ApiService from "./services/api.service";
import {TokenService} from "./services/storage.service";
import store from './store'

Vue.config.productionTip = false

Vue.use(BootstrapVue);
Vue.use(VueMoment);
Vue.use(VueApexCharts);

Vue.component('apexchart', VueApexCharts)

// Set the base URL of the API
ApiService.init(process.env.VUE_APP_BASE_URL);

// If token exists set header
if (TokenService.getToken()) {
  ApiService.setHeader()
}
// If 401 try to refresh token
ApiService.mount401Interceptor();

new Vue({
  router,
  store,
  render: h => h(App),
}).$mount('#app');
