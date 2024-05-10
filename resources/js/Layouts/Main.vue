<template>
  <div
    class="flex h-screen font-body overflow-x-hidden"
    :class="isDark ? 'bg-dark text-light' : 'bg-light text-dark'"
  >
    <Nav />

    <!-- <transition name="fade" mode="out-in" appear> -->
    <main class="flex-[2_2_0%]">
      <slot />
    </main>
    <!-- </transition> -->

    <Aside v-if="aside" />
  </div>
</template>

<script>
import Nav from '../Components/Nav.vue';
import Aside from '../Components/Aside.vue';
import { useDark } from '@vueuse/core';

export default {
  props: {
    aside: Boolean,
  },
  components: { Nav, Aside },
  setup() {
    return {
      isDark: useDark(),
    };
  },
};
</script>

<!-- <style>
.fade-enter-active,
.fade-leave-active {
  @apply transition;
}

.fade-enter-from,
.fade-leave-to {
  @apply -translate-x-10;
}
</style> -->
