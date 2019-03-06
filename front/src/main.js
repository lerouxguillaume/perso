import Vue from 'vue'
import App from './App.vue'
import BootstrapVue from 'bootstrap-vue'
import VueMoment from 'vue-moment'
import VueRouter from 'vue-router'
import VueApexCharts from 'vue-apexcharts'

import './assets/custom.scss'
import routes from './routes.js'

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

const router = new VueRouter({
  routes // short for `routes: routes`
});


Vue.filter('truncate', filter);

new Vue({
  router,
  render: h => h(App),
}).$mount('#app');
