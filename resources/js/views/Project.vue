<template>
    <div class="container mt-4 mb-4">

      <div class="row align-items-center mb-4">
        <div class="col">
          <h3 class="heading-title text-primary font-weight-bold mb-2">{{project.name}}</h3>
          <p class="mb-0">{{project.description}}</p>
        </div>
        <div class="col text-right">
          <button type="button" class="btn btn-primary btn-sm" v-on:click="handleModalNew">New</button>
        </div>
      </div>

<!--      <div class="card-deck">-->
      <div class="card-columns">
          <tasklist @modalEdit="handleModalEdit" v-for="list in project.lists" :list="list" :key="list.updated_at"></tasklist>
      </div>


      <modal :show.sync="modals.newList" @close="closeModal">
        <h6 slot="header" class="modal-title" id="modal-title-default">{{(!modals.editList) ? "Add a new list" : "Edit your list"}}</h6>

        <form role="form">
          <base-input alternative
                      class="mb-3"
                      type="text"
                      placeholder="Name"
                      v-model="form.name"
                      :error="errors.name"
                      addon-left-icon="ni ni-collection">
          </base-input>
        </form>

        <template slot="footer">
          <base-button type="primary" @click="manageList">Save</base-button>
          <base-button v-if="modals.editList" type="danger" @click="deleteList">Delete</base-button>
          <base-button type="link" class="ml-auto" @click="closeModal">Close</base-button>
        </template>
      </modal>
    </div>
</template>
<script>
  import axios from "axios";
  import Modal from "../components/Modal";

  export default {
    components: {
        Modal
    },
    data() {
      return {
        project: null,
        list: null,
        form: {
          name: ""
        },
        errors: {},
        modals: {
          newList: false,
          editList: false
        }
      }
    },
    methods: {
        closeModal() {
            this.form.name = '';
            this.form.description = '';
            this.errors = {};
            this.list = null;
            this.modals.editList = false;
            this.modals.newList = false;
        },
        handleModalNew() {
            this.modals.newList = true;
        },
        handleModalEdit(id) {

            this.list = this.project.lists.find(list => list.id === parseInt((id)));
            this.form.name = this.list.name;

            this.modals.editList = true;
            this.modals.newList = true;
        },
        manageList() {
            if(!this.modals.editList) {
                this.addList();
            } else {
                this.editList();
            }
        },
        addList() {
            const self = this;

            axios.post(window.endpoint + "project/" + self.project.id + "/list", {
                name: self.form.name
            }, self.$store.state.auth.header)
                .then(function (response) {
                    if(typeof self.project.lists === "undefined") self.project.lists = [];
                    self.project.lists = [...self.project.lists, response.data];
                    self.closeModal();
                })
                .catch(function (error) {
                    self.errors = window.axiosFormErrors(error);
                });
        },
        editList() {
            const self = this;

            axios.post(window.endpoint + "project/" + self.project.id + "/list/" + self.list.id, {
                name: self.form.name
            }, self.$store.state.auth.header)
                .then(function (response) {
                    self.project.lists = self.project.lists.filter(list => (list.id !== self.list.id));
                    self.project.lists = [...self.project.lists, response.data];
                    self.closeModal();
                })
                .catch(function (error) {
                    self.errors = window.axiosFormErrors(error);
                });
        },
        deleteList() {
            const self = this;

            axios.delete(window.endpoint + "project/" + self.project.id + "/list/" + self.list.id, self.$store.state.auth.header)
                .then(function (response) {
                    self.project.lists = self.project.lists.filter(list => list.id !== self.list.id);
                    self.closeModal();
                })
                .catch(function (error) {
                    if(error.response){
                        alert("show error");
                    }
                });
        }
    },
    created() {
      this.$store.commit('getProject', this.$route.params.id);
      this.project = this.$store.state.projects.result;
    }
  }
</script>
