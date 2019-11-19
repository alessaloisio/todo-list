import Vue from "vue";
import Router from "vue-router";

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
            name: "home",
            components: {
                header: Header,
                default: Home,
                footer: Footer
            }
        },
        {
            path: "/landing",
            name: "landing",
            components: {
                header: Header,
                default: Landing,
                footer: Footer
            }
        },
        {
            path: "/components",
            name: "components",
            components: {
                header: Header,
                default: Components,
                footer: Footer
            }
        },
        {
            path: "/login",
            name: "login",
            components: {
                header: Header,
                default: Login,
                footer: Footer
            }
        },
        {
            path: "/register",
            name: "register",
            components: {
                header: Header,
                default: Register,
                footer: Footer
            }
        },
        {
            path: "/profile",
            name: "profile",
            components: {
                header: Header,
                default: Profile,
                footer: Footer
            }
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
