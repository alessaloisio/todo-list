import Vue from "vue";
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        authenticate: false
    },
    mutations: {
        authenticate (state) {
            state.authenticate = !state.authenticate;
        }
    }
})
