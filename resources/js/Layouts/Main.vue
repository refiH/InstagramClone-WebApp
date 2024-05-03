<template>
  <div class="flex h-screen bg-light text-dark font-body overflow-x-hidden">
    <Nav />

    <!-- <transition name="fade" mode="out-in" appear> -->
    <main :key="$page.url" class="flex-[2_2_0%]">
      <slot />
    </main>
    <!-- </transition> -->

    <Aside v-if="aside" />
  </div>
</template>

<script>
import Nav from '../Components/Nav.vue';
import Aside from '../Components/Aside.vue';

export default {
  props: {
    aside: Boolean,
  },
  components: { Nav, Aside },
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
