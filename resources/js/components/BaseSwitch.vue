<template>
    <label class="custom-toggle">
        <input type="checkbox"
               v-model="model"
               v-bind="$attrs"
               v-on="$listeners">
        <span class="custom-toggle-slider rounded-circle"></span>
    </label>
</template>
<script>
export default {
  name: "base-switch",
  inheritAttrs: false,
  props: {
    value: {
      type: Boolean,
      default: false,
      description: "Switch value"
    }
  },
  computed: {
    model: {
      get() {
        return this.value;
      },
      set() {
          // this.value = !this.value;
          this.$emit("input", this.value);
        // this.$emit("input", value);
      }
    }
  }
};
</script>
<style>
</style>
