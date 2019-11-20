<template>
    <header class="header-global">
        <base-nav effect="dark" expand >
            <router-link slot="brand" class="brand-logo navbar-brand mr-lg-5" to="/">
                ToutDouxLiss't
            </router-link>

            <div class="row" slot="content-header" slot-scope="{closeMenu}">
                <div class="col-6 collapse-brand">
                    <a href="../index.html">
                        <img src="img/brand/blue.png">
                    </a>
                </div>
                <div class="col-6 collapse-close">
                    <close-button @click="closeMenu"></close-button>
                </div>
            </div>

            <ul class="navbar-nav navbar-nav-hover align-items-lg-center">
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link" data-toggle="dropdown" role="button">
                        <i class="ni ni-collection d-lg-none"></i>
                        <span class="nav-link-inner--text">Pages</span>
                    </a>
                    <div class="dropdown-menu">
                        <router-link to="/landing" class="dropdown-item">Landing</router-link>
                        <router-link to="/components" class="dropdown-item">Components</router-link>
                        <router-link to="/profile" class="dropdown-item">Profile</router-link>
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav align-items-lg-center ml-lg-auto">
                <li class="nav-item d-none d-lg-block ml-lg-4">

                    <router-link to="/login" class="btn btn-neutral btn-icon">
                        <span class="btn-inner--icon">
                            <i class="ni ni-circle-08 mr-2"></i>
                        </span>
                        <span class="nav-link-inner--text">Login</span>
                    </router-link>

                </li>
            </ul>
        </base-nav>
    </header>
</template>
<script>
import BaseNav from "../components/BaseNav";
import CloseButton from "../components/CloseButton";

export default {
  components: {
    BaseNav,
    CloseButton
  }
};
</script>
<style>
</style>
