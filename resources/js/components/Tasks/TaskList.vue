<template>
  <div class="card">
    <div class="card-header">
      <div class="row align-items-center">
        <div class="col">
          <h4 class="card-title mb-0">{{list.name}}</h4>
        </div>
        <div class="col text-right">
          <button type="button" class="btn btn-primary btn-sm btn-editList" v-on:click="(event) => this.$emit('modalEdit', list.id)">Edit</button>
        </div>
      </div>
    </div>
    <div class="card-content">
      <div class="table-full-width table-tasks">
        <table class="table-task table">

          <task v-for="(task, index) in list.tasks"
                :key="task.content"
                :task="task"
                :index="index"
                @on-edit="handleModalEdit"
                @on-delete="handleTaskDelete"
                @on-checked="handleChecked">
          </task>

          <tr class="add-task card-footer" @click="handleModalNew">
            <td></td>
            <td class="text-center"><i class="ni ni-fat-add"></i></td>
            <td></td>
          </tr>
        </table>
      </div>
    </div>

    <modal :show.sync="modals.newTask" @close="closeModal">
      <h6 slot="header" class="modal-title" id="modal-title-default">{{(!modals.editTask) ? "Add a new task" : "Edit your task"}}</h6>

      <form role="form">
        <base-input alternative
                    class="mb-3"
                    type="text"
                    placeholder="Content"
                    v-model="form.content"
                    :error="errors.content"
                    addon-left-icon="ni ni-collection">
        </base-input>
      </form>

      <template slot="footer">
        <base-button type="primary" @click="manageTask">Save</base-button>
        <base-button type="link" class="ml-auto" @click="closeModal">Close</base-button>
      </template>
    </modal>
  </div>
</template>
<script>

import axios from "axios";
import Task from './Task';
import Modal from "../Modal";

export default {
  name: "tasklist",
  components: {
    Task, Modal
  },
  data() {
    return {
      list: null,
      task_id: null,
      form: {
          content: ""
      },
      errors: {},
      modals: {
          newTask: false,
          editTask: false
      }
    };
  },
  methods: {
    closeModal() {
        this.form.content = '';
        this.task_id = null;
        this.errors = {};
        this.modals.editTask = false;
        this.modals.newTask = false;
    },
    handleModalNew() {
        this.modals.newTask = true;
    },
    handleModalEdit(id) {

        this.task_id = id;
        this.form.content = this.list.tasks[id].content;

        this.modals.editTask = true;
        this.modals.newTask = true;
    },
    manageTask() {
        if(!this.modals.editTask) {
            this.handleTaskAdd();
        } else {
            this.handleTaskEdit();
        }
    },
    handleTaskAdd() {

        const self = this;

        axios.post(window.endpoint + "project/" + self.list.project_id + "/list/" + self.list.id + "/task", {
            content: self.form.content
        }, self.$store.state.auth.header)
            .then(function (response) {
                if(typeof self.list.tasks === "undefined") self.list.tasks = [];
                self.list.tasks = [...self.list.tasks, response.data];
                self.closeModal();
            })
            .catch(function (error) {
                self.errors = window.axiosFormErrors(error);
            });

    },
    handleTaskEdit() {

        const self = this;

        axios.post(window.endpoint + "project/" + self.list.project_id + "/list/" + self.list.id + "/task/" + self.list.tasks[this.task_id].id, {
            content: self.form.content
        }, self.$store.state.auth.header)
            .then(function (response) {
                self.list.tasks = self.list.tasks.filter(task => (task.id !== self.list.tasks[self.task_id].id));
                self.list.tasks = [...self.list.tasks, response.data];

                self.closeModal();
            })
            .catch(function (error) {
                self.errors = window.axiosFormErrors(error);
            });
    },
    handleChecked(id) {
        const self = this;

        axios.post(window.endpoint + "project/" + self.list.project_id + "/list/" + self.list.id + "/task/" + self.list.tasks[id].id, {
            confirmed: self.list.tasks[id].confirmed
        }, self.$store.state.auth.header)
            .then(function (response) {
                self.list.tasks = self.list.tasks.filter(task => (task.id !== self.list.tasks[id].id));
                self.list.tasks = [...self.list.tasks, response.data];

                self.closeModal();
            })
            .catch(function (error) {
                self.errors = window.axiosFormErrors(error);
            });
    },
    handleTaskDelete(id) {

        const self = this;

        axios.delete(window.endpoint + "project/" + self.list.project_id + "/list/" + self.list.id + "/task/" + self.list.tasks[id].id, self.$store.state.auth.header)
            .then(function (response) {
                self.list.tasks = self.list.tasks.filter(task => (task.id !== self.list.tasks[id].id));
            })
            .catch(function (error) {
                self.errors = window.axiosFormErrors(error);
            });
    },
  },
  created() {
      this.list = this.$attrs.list;
  }
};
</script>
<style>
  .table {
    table-layout: fixed;
  }

  .table-task {
    overflow: hidden;
  }

  .table td, .table th {
    padding: 1em;
    vertical-align: middle;
    white-space: inherit;
  }

  @media (min-width: 576px) {
    .card {
      flex: 1 0 calc(50% - 30px) !important;
      margin-right: 7.5px !important;
      margin-bottom: 15px !important;
      margin-left: 7.5px !important;
    }
  }

  .add-task { cursor: pointer; transition: all 1s; }
  .add-task:hover i { color: #5e72e4; }
  .add-task i {
    font-size: 1.5em;
    vertical-align: middle;
    padding: 0.5em 0em;
  }

  .card-header .btn-editList {
    opacity: 0;
    transition: opacity 1s;
  }
  .card-header:hover .btn-editList {
    opacity: 1;
  }
</style>
