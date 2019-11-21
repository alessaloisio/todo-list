<template>
    <div class="container mt-4 mb-4">
        <h3 class="heading-title text-primary font-weight-bold mb-4">{{project.name}}</h3>

        <div class="card-deck">
            <tasklist></tasklist>
            <tasklist></tasklist>
            <tasklist></tasklist>
            <tasklist></tasklist>
            <tasklist></tasklist>
        </div>

    </div>
</template>
<script>
    import axios from "axios";

    export default {
        data() {
            return {
                project: {},
                lists: {},

                items: [
                    {
                        id: 1,
                        title: "tache1",
                        description: "desc1",
                        done: true,
                        checkType: "warning"
                    },
                    {
                        id: 2,
                        title: "tache2",
                        description: "desc1",
                        done: true,
                        checkType: "warning"
                    }
                ]
            }
        },

        beforeCreate() {

            const self = this;

            axios.get(window.endpoint + "project/" + self.$route.params.id, { params: {}, headers: { 'Authorization': localStorage.getItem('auth_token') } })
                .then(function (response) {
                    self.project = response.data;
                })
                .catch(function (error) {
                    if(error.response){
                        console.log(error.response);
                    }
                });
        }
    }
</script>
