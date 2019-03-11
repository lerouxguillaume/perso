import Vue from 'vue'
import App from './App.vue'
import BootstrapVue from 'bootstrap-vue'
import VueMoment from 'vue-moment'
import VueApexCharts from 'vue-apexcharts'
import store from './store/store'
import './assets/custom.scss'
import router from './routes.js'
import './filter.js'

Vue.config.productionTip = false

Vue.use(BootstrapVue);
Vue.use(VueMoment);
Vue.use(VueApexCharts);

Vue.component('apexchart', VueApexCharts)

new Vue({
  router,
  store,
  render: h => h(App),
}).$mount('#app');
