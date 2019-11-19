<template>
    <header class="header-global" style="position: relative">
        <base-nav :type="type" effect="dark" expand class="mt-4" v-for="type in types" :key="type">
            <router-link slot="brand" class="navbar-brand" to="/">
                ToutDouxLiss't
            </router-link>

            <div class="row" slot="content-header" slot-scope="{closeMenu}">
                <div class="col-6 collapse-brand">
                    <a href="https://demos.creative-tim.com/vue-argon-design-system/documentation/">
                        <img src="https://demos.creative-tim.com/vue-argon-design-system/img/brand/blue.png">
                    </a>
                </div>
                <div class="col-6 collapse-close">
                    <close-button @click="closeMenu"></close-button>
                </div>
            </div>

            <ul class="navbar-nav ml-lg-auto">
                <li class="nav-item">
                    <a class="nav-link nav-link-icon" href="#">
                        Discover
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-icon" href="#">
                        Profile
                    </a>
                </li>
            </ul>
        </base-nav>
    </header>
</template>

<script>
    export default {
        name: "AppHeader"
    }
</script>

<style scoped>

</style>
