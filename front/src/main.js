import Vue from 'vue'
import App from './App.vue'
import BootstrapVue from 'bootstrap-vue'
import VueMoment from 'vue-moment'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.config.productionTip = false
Vue.use(BootstrapVue)
Vue.use(VueMoment);

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

Vue.filter('truncate', filter);

new Vue({
  render: h => h(App),
}).$mount('#app')
