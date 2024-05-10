<template>
  <nav class="flex-[1_1_0%] border-r px-2 pt-8 max-w-64 sticky top-0 flex flex-col">
    <img :src="icon" alt="Logo" class="w-[4.5rem] object-contain mx-auto mb-8" />

    <div class="flex flex-col px-1">
      <Link
        class="flex items-center gap-4 font-medium rounded py-3 px-4 hover:brightness-75 transition"
        :href="route('home')"
        :class="{
          'bg-primary text-light hover:!bg-primary-dark': $page.component === 'Home',
        }"
      >
        <HomeIcon :size="32" />
        Home
      </Link>
      <Link
        class="flex items-center gap-4 font-medium rounded py-3 px-4 hover:brightness-75 transition"
        :href="route('explore')"
        :class="{
          'bg-primary text-light hover:!bg-primary-dark': $page.component === 'Explore',
        }"
      >
        <CompassIcon :size="32" />
        Explore
      </Link>
      <Link
        class="flex items-center gap-4 font-medium rounded py-3 px-4 hover:brightness-75 transition"
        :href="route('add')"
        :class="{
          'bg-primary text-light hover:!bg-primary-dark': $page.component === 'Add',
        }"
      >
        <PlusIcon :size="32" />
        Add
      </Link>
    </div>

    <div class="mx-auto mt-auto flex gap-4">
      <button @click="toggleDark()" class="rounded p-2 hover:-rotate-[30deg] transition">
        <MoonIcon v-if="isDark" :size="30" />
        <SunIcon v-else :size="30" />
      </button>

      <Link :href="route('profile', { username: $page.props.auth.user.username })">
        <button class="rounded p-2 hover:scale-110 transition">
          <AccountIcon :size="30" />
        </button>
      </Link>
    </div>

    <form @submit.prevent="router.get(route('auth.logout'))" class="mb-4 mt-6 mx-auto">
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
import SunIcon from 'vue-material-design-icons/WhiteBalanceSunny.vue';
import MoonIcon from 'vue-material-design-icons/MoonWaningCrescent.vue';
import AccountIcon from 'vue-material-design-icons/Account.vue';
import LogoutIcon from 'vue-material-design-icons/Logout.vue';
import { useDark, useToggle } from '@vueuse/core';

export default {
  components: { Link, HomeIcon, CompassIcon, PlusIcon, SunIcon, MoonIcon, AccountIcon, LogoutIcon },
  setup() {
    const isDark = useDark();
    const toggleDark = useToggle(isDark);

    return {
      router,
      icon: '/icon-192.png',
      isDark,
      toggleDark,
    };
  },
};
</script>
