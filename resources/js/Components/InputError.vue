<template>
  <p class="text-xs text-red-400 mt-1" v-if="error">
    {{ error }}
  </p>
</template>

<script>
export default {
  props: {
    error: String,
  },
  setup() {
    return {};
  },
};
</script>
