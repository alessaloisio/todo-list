<template>
    <div class="container mt-4 mb-4">
        <div class="row">
            <div class="col">
                <projects-table
                    title="Projects"
                    :data="$store.state.projects.data"
                    @modalNew="handleModalNew"
                    @modalEdit="handleModalEdit"
                    @deleteProject="handleDelete">
                </projects-table>
            </div>
        </div>
        <modal :show.sync="modals.newProject" @close="closeModal">
            <h6 slot="header" class="modal-title" id="modal-title-default">{{(!modals.editProject) ? "Add a new project" : "Edit your project"}}</h6>

            <form role="form">
                <base-input alternative
                            class="mb-3"
                            type="text"
                            placeholder="Name"
                            v-model="form.name"
                            :error="errors.name"
                            addon-left-icon="ni ni-collection">
                </base-input>
                <base-input alternative
                            type="text"
                            placeholder="Description"
                            v-model="form.description"
                            :error="errors.description"
                            addon-left-icon="ni ni-align-left-2">
                </base-input>
            </form>

            <template slot="footer">
                <base-button type="primary" @click="manageProject">Save</base-button>
                <base-button type="link" class="ml-auto" @click="closeModal">Close</base-button>
            </template>
        </modal>
    </div>
</template>
<script>
  import axios from 'axios';
  import Modal from "../components/Modal";

  export default {
    components: {
        Modal
    },
    data() {
        return {
            projects: this.$store.state.projects,
            modals: {
                newProject: false,
                editProject: false
            },
            form: {
                name: '',
                description: ''
            },
            errors: {}
        }
    },
    methods: {
      closeModal() {
          this.form.name = '';
          this.form.description = '';
          this.errors = {};
          this.modals.editProject = false;
          this.modals.newProject = false;
      },
      handleModalNew() {
          this.modals.newProject = true;
      },
      handleModalEdit(id) {
          // Get the project on the result state
          this.$store.commit('getProject', id);

          const project = this.projects.result;
          this.form.name = project.name;
          this.form.description = project.description;

          this.modals.editProject = true;
          this.modals.newProject = true;
      },
      handleDelete(index) {
          const self = this;

          axios.delete(window.endpoint + "project/" + index, self.$store.state.auth.header)
              .then(function (response) {
                  self.projects.data = self.projects.data.filter(project => project.id !== index);
              })
              .catch(function (error) {
                  if(error.response){
                      alert("show error");
                  }
              });

      },
      manageProject() {
          if(!this.modals.editProject) {
              this.addProject();
          } else {
              this.editProject();
          }
      },
      addProject() {

          const self = this;

          axios.post(window.endpoint + "project", {
              name: self.form.name,
              description: self.form.description
          }, self.$store.state.auth.header)
              .then(function (response) {
                  self.projects.data.push(response.data);
                  self.closeModal();
              })
              .catch(function (error) {
                  self.errors = window.axiosFormErrors(error);
              });
      },
      editProject() {

          const self = this;

          axios.post(window.endpoint + "project/" + this.projects.result.id, {
              name: self.form.name,
              description: self.form.description
          }, self.$store.state.auth.header)
              .then(function (response) {
                  self.projects.data = self.projects.data.filter(project => (project.id !== self.projects.result.id));
                  self.projects.data.push(response.data);
                  self.closeModal();
              })
              .catch(function (error) {
                  self.errors = window.axiosFormErrors(error);
              });
      }
    }
  }
</script>
