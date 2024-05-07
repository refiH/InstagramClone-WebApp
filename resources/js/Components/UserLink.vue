<template>
  <Link
    :href="route('profile', { username: username })"
    class="font-bold cursor-pointer hover:underline transition mr-1"
  >
    {{ username }}
  </Link>
</template>

<script>
import { Link } from '@inertiajs/vue3';

export default {
  props: {
    username: String,
  },
  components: { Link },
  setup() {
    return {};
  },
};
</script>
