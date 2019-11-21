<template>
  <tr>
    <td width="10%">
        <base-checkbox v-model="checkboxes.checked"></base-checkbox>
    </td>

    <td width="70%" class="task-title align-middle"><p class="mb-0">{{task.title}}</p></td>

    <td class="td-actions text-right">
      <div class="table-icons">
        <button type="button"
                rel="tooltip"
                title="Edit Task"
                class="btn btn-info btn-simple btn-xs"
                @click="handleEditClick">
          <i class="fa fa-pencil"></i>
        </button>
        <button type="button"
                rel="tooltip"
                title="Remove"
                class="btn btn-danger btn-simple btn-xs"
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
          title: ''
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
</style>
