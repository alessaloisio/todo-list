<template>
    <div class="container mt-4 mb-4">
        <div class="row">
            <div class="col">
                <projects-table title="Projects" :data="projects"></projects-table>
            </div>
        </div>
    </div>
</template>
<script>

    import axios from 'axios';

    export default {
        data() {
            return {
                projects: []
            }
        },

        beforeCreate() {

            const self = this;

            axios.get(window.endpoint + "projects", { params:{}, headers: { 'Authorization': localStorage.getItem('auth_token') } })
                .then(function (response) {
                    self.projects = response.data;
                })
                .catch(function (error) {
                    if(error.response){
                        console.log(error.response);
                    }
                });
        }
    }
</script>
