<template>
  <img
    :src="src ? src : defaultProfile"
    class="profile-img bg-slate-200 border-[rgba(0,0,0,0.1)] border rounded-full cursor-pointer hover:shadow transition object-cover"
    :class="class"
    :style="`height: ${size}px; width: ${size}px; flex: 0 0 auto`"
  />
</template>

<script>
export default {
  props: {
    src: String,
    class: String,
    size: { type: Number, default: 32 },
  },
  data() {
    return {
      defaultProfile: 'images/default_profile.jpg',
    };
  },
};
</script>

<style>
.profile-img {
  text-indent: -10000px;
}
</style>
