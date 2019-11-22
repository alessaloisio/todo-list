<template>
  <tr>
    <td width="10%">
        <base-checkbox @input="handleCheckbox" v-model="task.confirmed"></base-checkbox>
    </td>

    <td width="70%" class="task-title align-middle"><p class="mb-0">{{task.content}}</p></td>

    <td class="td-actions text-right">
      <div class="table-icons">
        <button type="button"
                rel="tooltip"
                title="Edit Task"
                class="btn btn-success btn-simple btn-sm"
                @click="handleEditClick">
          <i class="fa fa-pencil"></i>
        </button>
        <button type="button"
                rel="tooltip"
                title="Remove"
                class="btn btn-danger btn-simple btn-sm"
                @click="handleDeleteClick">
          <i class="fa fa-close"></i>
        </button>
      </div>
    </td>

  </tr>
</template>
<script>
export default {
  name: "task",
  props: {
    task: {
      type: Object,
      default: () => {
        return {
          content: 'no content',
          confirmed : false
        };
      }
    },
    index: Number
  },
    data() {
        return {
            checkboxes: {
                checked: true
            }
        }
    },
  methods: {
    handleEditClick() {
      this.$emit('on-edit', this.index);
    },
    handleDeleteClick() {
      this.$emit('on-delete', this.index);
    },
    handleCheckbox() {
      this.$emit('on-checked', this.index);
    }
  }
};
</script>
<style>
    .task-title {
        word-wrap: break-word;
    }

    .custom-control {
        padding-bottom: 1.75rem;
    }

    .td-actions button {
        margin-bottom: 0.25rem;
        margin-top: 0.25rem;
    }

    .table .btn:not(:last-child) {
        margin-right: 0;
    }

    .table .td-actions {
        transform: translateX(100%);
        transition: transform 1s;
    }

    .table tr:hover .td-actions {
        transform: translateX(0);
    }

    .table tr .task-title {
        width: 70%;
    }
</style>
