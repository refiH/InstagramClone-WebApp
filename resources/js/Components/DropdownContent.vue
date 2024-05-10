<template>
  <Transition name="dropdown-content">
    <div
      v-if="active"
      class="origin-top-right absolute right-0 mt-2 w-48 rounded-lg border py-1"
      :class="isDark ? 'bg-dark' : 'bg-white'"
    >
      <slot />
    </div>
  </Transition>
</template>

<script>
import { useDark } from '@vueuse/core';

export default {
  inject: ['sharedState'],
  computed: {
    active() {
      return this.sharedState.active;
    },
  },
  setup() {
    return {
      isDark: useDark(),
    };
  },
};
</script>

<style>
.dropdown-content-enter-active,
.dropdown-content-leave-active {
  transition: all 0.2s;
}
.dropdown-content-enter,
.dropdown-content-leave-to {
  opacity: 0;
  transform: translateY(-5px);
}
</style>
