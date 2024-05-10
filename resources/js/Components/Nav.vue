<template>
  <nav class="flex-[1_1_0%] shadow px-2 pt-8 max-w-60 sticky top-0 flex flex-col">
    <img :src="icon" alt="Logo" class="w-[4.5rem] object-contain mx-auto mb-8" />

    <div class="flex flex-col">
      <Link
        class="flex items-center gap-4 font-medium rounded py-3 px-4 hover:bg-gray-200 transition"
        href="/"
        :class="{
          'bg-primary text-light hover:!bg-primary-dark': $page.component === 'Home',
        }"
      >
        <HomeIcon :size="32" />
        Home
      </Link>
      <Link
        class="flex items-center gap-4 font-medium rounded py-3 px-4 hover:bg-gray-200 transition"
        href="/explore"
        :class="{
          'bg-primary text-light hover:!bg-primary-dark': $page.component === 'Explore',
        }"
      >
        <CompassIcon :size="32" />
        Explore
      </Link>
      <Link
        class="flex items-center gap-4 font-medium rounded py-3 px-4 hover:bg-gray-200 transition"
        href="/add"
        :class="{
          'bg-primary text-light hover:!bg-primary-dark': $page.component === 'Add',
        }"
      >
        <PlusIcon :size="32" />
        Add
      </Link>
    </div>

    <form @submit.prevent="router.get(route('auth.logout'))" class="mb-4 mt-auto mx-auto">
      <button type="submit" class="flex gap-2 text-red-400">
        <LogoutIcon />
        Logout
      </button>
    </form>
  </nav>
</template>

<script>
import { Link, router } from '@inertiajs/vue3';
import HomeIcon from 'vue-material-design-icons/Home.vue';
import CompassIcon from 'vue-material-design-icons/Compass.vue';
import PlusIcon from 'vue-material-design-icons/PlusCircle.vue';
import LogoutIcon from 'vue-material-design-icons/Logout.vue';

export default {
  components: { Link, HomeIcon, CompassIcon, PlusIcon, LogoutIcon },
  setup() {
    return {
      router,
      icon: '/icon-192.png',
    };
  },
};
</script>
