<template>
  <img
    :src="src"
    :alt="alt"
    class="profile-img bg-slate-200 border-[rgba(0,0,0,0.1)] border rounded-full cursor-pointer hover:shadow transition"
    :class="class"
    :style="`height: ${size}px; width: ${size}px; flex: 0 0 auto`"
  />
</template>

<script>
export default {
  props: {
    src: String,
    alt: String,
    class: String,
    size: { type: Number, default: 32 },
  },
};
</script>

<style>
.profile-img {
  text-indent: -10000px;
}
</style>
