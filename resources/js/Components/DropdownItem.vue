<template>
  <button
    href="#"
    class="block my-1 px-4 py-1 font-medium text-sm w-full"
    :class="isDark ? 'hover:bg-gray-500' : 'hover:bg-gray-200'"
  >
    <slot />
  </button>
</template>

<script>
import { useDark } from '@vueuse/core';

export default {
  setup() {
    return {
      isDark: useDark(),
    };
  },
};
</script>
