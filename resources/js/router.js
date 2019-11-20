import Vue from "vue";
import Router from "vue-router";

import Guest from "./middleware/guest";
import Auth from "./middleware/auth";

import Header from "./layout/Header";
import Footer from "./layout/Footer";

import Home from "./views/Home";
import Landing from "./views/Landing";
import Components from "./views/Components";
import Login from "./views/Login";
import Register from "./views/Register";
import Profile from "./views/Profile";

Vue.use(Router);

export default new Router({
    linkExactActiveClass: "active",
    routes: [
        {
            path: "/",
            name: "Home",
            components: {
                header: Header,
                default: Landing,
                footer: Footer
            }
        },
        {
            path: "/components",
            name: "Components",
            components: {
                header: Header,
                default: Components,
                footer: Footer
            }
        },
        {
            path: "/login",
            name: "Login",
            components: {
                header: Header,
                default: Login,
                footer: Footer
            },
            beforeEnter: Guest
        },
        {
            path: "/register",
            name: "Register",
            components: {
                header: Header,
                default: Register,
                footer: Footer
            },
            beforeEnter: Guest
        },
        {
            path: "/profile",
            name: "Profile",
            components: {
                header: Header,
                default: Profile,
                footer: Footer
            },
            beforeEnter: Auth
        },
        {
            path: "/dashboard",
            name: "Dashboard",
            components: {
                header: Header,
                // default: Dashboard
            },
            beforeEnter: Auth
        }
    ],
    scrollBehavior: to => {
        if (to.hash) {
            return { selector: to.hash };
        } else {
            return { x: 0, y: 0 };
        }
    }
});
