<template>
    <header class="header-global">
        <base-nav effect="dark" expand >

            <router-link slot="brand" class="brand-logo navbar-brand mr-lg-5" to="/">
                ToutDouxLiss't
            </router-link>

            <div class="row mobile-navbar" slot="content-header" slot-scope="{closeMenu}">
                <div class="col-6 collapse-brand">
                    <router-link slot="brand" class="brand-logo navbar-brand mr-lg-5" to="/">
                        ToutDouxLiss't
                    </router-link>
                </div>
                <div class="col-6 collapse-close">
                    <close-button @click="closeMenu"></close-button>
                </div>
            </div>

            <ul class="navbar-nav navbar-nav-hover align-items-lg-center">
                <li class="nav-item">
                    <router-link to="/dashboard" class="nav-link" v-if="$store.state.auth.authenticate">Dashboard</router-link>
                </li>
            </ul>


            <ul class="navbar-nav align-items-lg-center ml-lg-auto" v-if="!$store.state.auth.authenticate">
                <li class="nav-item d-none d-lg-block ml-lg-4">

                    <router-link to="/login" class="btn btn-neutral btn-icon">
                        <span class="btn-inner--icon">
                            <i class="ni ni-circle-08 mr-2"></i>
                        </span>
                        <span class="nav-link-inner--text">Login</span>
                    </router-link>

                </li>
            </ul>
            <ul class="navbar-nav align-items-lg-center ml-lg-auto" v-else >
                <li class="nav-item d-none d-lg-block ml-lg-4">

                    <a class="btn btn-neutral btn-icon" v-on:click="logout">
                        <span class="btn-inner--icon">
                            <i class="ni ni-circle-08 mr-2"></i>
                        </span>
                        <span class="nav-link-inner--text">Logout</span>
                    </a>

                </li>
            </ul>
        </base-nav>
    </header>
</template>
<script>
import BaseNav from "../components/BaseNav";
import CloseButton from "../components/CloseButton";

import axios from "axios";

export default {
    components: {
        BaseNav,
        CloseButton
    },
    methods: {
        logout: function (event) {
            const self = this;

            axios.get(window.endpoint + "auth/logout", self.$store.state.auth.header)
                .then(function (response) {
                    localStorage.removeItem('auth_token');
                    self.$store.commit("authenticate");
                    self.$notify({type: 'success', message: 'Success Logout'});
                    self.$router.push({
                        name: "Login"
                    });
                })
                .catch(function (error) {
                    if(error.response){
                        console.log(error.response);
                        self.$notify({type: 'warning', message: error.response});
                    }
                });
        }
    }
};
</script>
<style>
</style>
