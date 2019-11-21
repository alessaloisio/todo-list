/*!

=========================================================
* Vue Argon Design System - v1.1.0
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-design-system
* Copyright 2019 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://github.com/creativetimofficial/argon-design-system/blob/master/LICENSE.md)

* Coded by www.creative-tim.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

*/

import Vue from "vue";
import Argon from "./plugins/argon-kit";
import router from "./router";
import store from "./store";
import App from "./App.vue";

import './registerServiceWorker';

window.endpoint = "http://172.17.0.2:8000/api/";

Vue.config.productionTip = false;

Vue.use(Argon);

router.beforeEach((to, from, next) => {

    if(localStorage.getItem('auth_token') && !store.state.authenticate)
        store.commit('authenticate');

    next();
});

new Vue({
  router,
    store,
  render: h => h(App)
}).$mount("#app");


