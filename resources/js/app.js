import Vue from "vue";
import Argon from "./plugins/argon-kit";
import axiosFormErrors from "./plugins/axiosFormErrors";

import router from "./router";
import store from "./stores/store";

import App from "./App.vue";

import './registerServiceWorker';

window.endpoint = location.protocol + '//' + location.hostname + ':' + location.port + '/api/';
window.axiosFormErrors = axiosFormErrors;

Vue.config.productionTip = false;

Vue.use(Argon);

// Change state on auth store, if we have a token
router.beforeEach((to, from, next) => {
  if(localStorage.getItem('auth_token') && !store.state.auth.authenticate){
    store.commit('authenticate');
    store.commit('getProjects', next);
  }
  else {
    next();
  }

});

const app = new Vue({
  router,
  store,
  render: h => h(App)
}).$mount("#app");

