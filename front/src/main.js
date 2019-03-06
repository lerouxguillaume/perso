import Vue from 'vue'
import App from './App.vue'
import BootstrapVue from 'bootstrap-vue'
import VueMoment from 'vue-moment'
import VueRouter from 'vue-router'
import VueApexCharts from 'vue-apexcharts'

import './assets/custom.scss'

import ListNasaImages from "./components/Nasa/ListNasaImages";
import Profil from "./components/Profil";
import Home from "./components/Home";
import NasaImageDetail from "./components/Nasa/NasaImageDetail";
import Trade from "./components/Trading/Trade";
import NotFound from "./pages/NotFound";
import TradeList from "./components/Trading/TradeList";

Vue.config.productionTip = false
Vue.use(BootstrapVue)
Vue.use(VueMoment);
Vue.use(VueRouter)
Vue.use(VueApexCharts)

Vue.component('apexchart', VueApexCharts)

var filter = function(text, length, clamp, soft){
  clamp = clamp || '...';
  soft = soft || false;

  var node = document.createElement('div');
  node.innerHTML = text;
  var content = node.textContent;

  if (soft) {
    while (content[length] !== ' ' && length  > 0) {
      length--;
    }
  }

  return content.length > length ? content.slice(0, length) + clamp : content;
};

const routes = [
  { path: '/', name: 'homepage', component: Home },
  { path: '/profile', name: 'profile', component: Profil },
  { path: '/trading', name: 'trading_list', component: TradeList },
  { path: '/trading/:company', name: 'trading_detail', component: Trade },
  { path: '/nasa', name: 'nasa_list_image', component: ListNasaImages },
  { path: '/nasa/day/:day', name: 'nasa_image_detail', component: NasaImageDetail },
  { path: '*', name: 'not_found',component: NotFound },
];

const router = new VueRouter({
  routes // short for `routes: routes`
});


Vue.filter('truncate', filter);

new Vue({
  router,
  render: h => h(App),
}).$mount('#app');
