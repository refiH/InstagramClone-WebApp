<template>
  <Link v-if="href" :href="href" style="flex: 0 0 auto">
    <img
      :src="src ? src : defaultProfile"
      class="profile-img bg-slate-200 border-[rgba(0,0,0,0.1)] border rounded-full cursor-pointer hover:shadow transition object-cover"
      :style="`height: ${size}px; width: ${size}px; flex: 0 0 auto;`"
    />
  </Link>

  <img
    v-else
    :src="src ? src : defaultProfile"
    class="profile-img bg-slate-200 border-[rgba(0,0,0,0.1)] border rounded-full cursor-pointer hover:shadow transition object-cover"
    :style="`height: ${size}px; width: ${size}px; flex: 0 0 auto;`"
  />
</template>

<script>
import { Link } from '@inertiajs/vue3';

export default {
  props: {
    src: String,
    size: { type: Number, default: 32 },
    href: String,
  },
  components: {
    Link,
  },
  data() {
    return {
      defaultProfile: '/images/default_profile.jpg',
    };
  },
};
</script>

<style>
.profile-img {
  text-indent: -10000px;
}
</style>
