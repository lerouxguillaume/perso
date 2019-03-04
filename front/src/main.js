import Vue from 'vue'
import App from './App.vue'
import BootstrapVue from 'bootstrap-vue'
import VueMoment from 'vue-moment'
import VueRouter from 'vue-router'

import './assets/custom.scss'

import ListNasaImages from "./components/ListNasaImages";
import Profil from "./components/Profil";
import Home from "./components/Home";
import NasaImageDetail from "./components/NasaImageDetail";
// import NotFound from "./pages/NotFound";

Vue.config.productionTip = false
Vue.use(BootstrapVue)
Vue.use(VueMoment);
Vue.use(VueRouter)

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
  // { path: '*', component: NotFound },
  { path: '/', name: 'homepage', component: Home },
  { path: '/profile', name: 'profile', component: Profil },
  { path: '/nasa', name: 'nasa_list_image', component: ListNasaImages },
  { path: '/nasa/day/:day', name: 'nasa_image_detail', component: NasaImageDetail },
];

const router = new VueRouter({
  routes // short for `routes: routes`
});


Vue.filter('truncate', filter);

new Vue({
  router,
  render: h => h(App),
}).$mount('#app');
