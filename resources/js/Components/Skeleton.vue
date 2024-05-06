<template>
  <div class="animate-pulse bg-gray-200 rounded" :class="class"></div>
</template>

<script>
export default {
  props: {
    class: String,
  },
  setup() {
    return {};
  },
};
</script>
