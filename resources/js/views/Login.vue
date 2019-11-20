<template>
    <section class="section-full-height section section-shaped section-lg my-0">
        <div class="shape shape-style-1 bg-gradient-default">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="container pt-lg-md">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <card type="secondary" shadow
                          header-classes="bg-white pb-5"
                          body-classes="px-lg-5 py-lg-5"
                          class="border-0">
                        <template>
                            <div class="text-muted text-center mb-3">
                                <small>Sign in</small>
                            </div>
                        </template>
                        <template>
                            <form role="form">
                                <base-input alternative
                                            class="mb-3"
                                            name="email"
                                            placeholder="Email"
                                            v-model="form.email"
                                            :error="errors.email"
                                            addon-left-icon="ni ni-email-83">
                                </base-input>
                                <base-input alternative
                                            type="password"
                                            placeholder="Password"
                                            v-model="form.password"
                                            :error="errors.password"
                                            addon-left-icon="ni ni-lock-circle-open">
                                </base-input>
                                <div class="text-center">
                                    <base-button type="primary" class="my-4" v-on:click="login">Sign In</base-button>
                                </div>
                            </form>
                        </template>
                    </card>
                    <div class="row mt-3">
                        <div class="col-6"></div>
                        <div class="col-6 text-right">
                            <router-link class="text-light" to="/register">
                                <small>Create new account</small>
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>

    import axios from 'axios';

    export default {
        data() {
            return {
                form: {
                    email: '',
                    password: ''
                },
                errors: {}
            }
        },
        methods: {
            login: function () {

                const self = this;

                axios.post(window.endpoint + "auth/login", {
                    email: self.form.email,
                    password: self.form.password
                })
                    .then(function (response) {
                        localStorage.setItem('auth_token', response.data['access_token']);
                        self.$store.commit("authenticate");
                        self.$router.push({
                            name: "Dashboard"
                        });
                    })
                    .catch(function (error) {
                        if(error.response){

                            console.log(error.response);

                            const data = error.response.data;
                            const result = {};

                            for (let key in data) {
                                if (!data.hasOwnProperty(key)) continue;

                                let obj = data[key];
                                result[key] = obj.toString();
                            }

                            self.errors = result;
                        }
                    });

            }
        }
    };
</script>
<style>
</style>
