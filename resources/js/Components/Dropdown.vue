<template>
  <div @click="toggle" class="relative" v-click-away="away">
    <slot name="toggler">
      <button>Toggle</button>
    </slot>
    <slot />
  </div>
</template>

<script>
import { mixin as VueClickAway } from 'vue3-click-away';

export default {
  mixins: [VueClickAway],
  provide() {
    return {
      sharedState: this.sharedState,
    };
  },
  data() {
    return {
      sharedState: {
        active: false,
      },
    };
  },
  methods: {
    toggle() {
      this.sharedState.active = !this.sharedState.active;
    },
    away() {
      this.sharedState.active = false;
    },
  },
};
</script>
