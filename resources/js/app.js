/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

import Vue from "vue";
import App from "./ToDoList-App";
import router from "./router";

new Vue({
    router,
    render: h => h(App)
}).$mount("#app");
