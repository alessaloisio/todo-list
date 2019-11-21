<template>
  <div class="card">
    <div class="card-header">
      <h4 class="card-title">Tasks</h4>
      <p class="category">Backend development</p>
    </div>
    <div class="card-content">
      <div class="table-full-width table-tasks">
        <table class="table">

          <task v-for="(task, index) in tasks"
                :key="task.title"
                :task="task"
                :index="index"
                @on-edit="handleTaskEdit"
                @on-delete="handleTaskDelete">
          </task>

        </table>
      </div>
    </div>
    <div class="card-footer">
      <hr>
      <div class="stats">
        <i class="fa fa-history"></i> Updated 3 minutes ago
      </div>
    </div>
  </div>
</template>
<script>
import Task from './Task.vue';

export default {
    name: "tasklist",
  components: {
    Task
  },
  data() {
    return {
      tasks: [
        {
          title: 'Sign contract for "What are conference organizers afraid of?"'
        },
        {
          title: 'Lines From Great Russian Literature? Or E-mails From My Boss?'
        },
        {
          title:
            'Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit'
        },
        {
          title: 'Create 4 Invisible User Experiences you Never Knew About'
        },
        {
          title: 'Read "Following makes Medium better"'
        },
        {
          title: 'Unfollow 5 enemies from twitter'
        }
      ]
    };
  },
  methods: {
    handleTaskEdit(index) {
      alert(`You want to edit task: ${JSON.stringify(this.tasks[index])}`);
    },
    handleTaskDelete(index) {
      alert(`You want to delete task: ${JSON.stringify(this.tasks[index])}`);
    }
  }
};
</script>
<style>
    .table {
        table-layout: fixed;
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
</style>
