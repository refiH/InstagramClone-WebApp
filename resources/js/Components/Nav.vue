<template>
  <nav class="flex-[1_1_0%] shadow px-2 py-8 max-w-64 sticky top-0">
    <h1 class="font-display text-4xl mb-8 mx-2">INERTIAGRAM</h1>

    <div class="flex flex-col">
      <Link
        class="flex items-center gap-4 font-medium rounded py-3 px-4 hover:bg-gray-200 transition"
        href="/"
        :class="{
          'bg-blue-400 text-light hover:!bg-blue-500':
            $page.component === 'Home',
        }"
      >
        <HomeIcon :size="32" />
        Home
      </Link>
      <Link
        class="flex items-center gap-4 font-medium rounded py-3 px-4 hover:bg-gray-200 transition"
        href="/explore"
        :class="{
          'bg-blue-400 text-light hover:!bg-blue-500':
            $page.component === 'Explore',
        }"
      >
        <CompassIcon :size="32" />
        Explore
      </Link>
      <Link
        class="flex items-center gap-4 font-medium rounded py-3 px-4 hover:bg-gray-200 transition"
        href="/add"
        :class="{
          'bg-blue-400 text-light hover:!bg-blue-500':
            $page.component === 'Add',
        }"
      >
        <PlusIcon :size="32" />
        Add
      </Link>
    </div>
  </nav>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import HomeIcon from "vue-material-design-icons/Home.vue";
import CompassIcon from "vue-material-design-icons/Compass.vue";
import PlusIcon from "vue-material-design-icons/PlusCircle.vue";

export default {
  components: { Link, HomeIcon, CompassIcon, PlusIcon },
};
</script>
