<template>
  <span
    class="loader"
    :class="`border-[3px] !border-primary`"
    :style="`height: ${size}px; width: ${size}px;`"
  ></span>
</template>

<script>
export default {
  props: {
    size: {
      type: Number,
      default: 48,
    },
  },
};
</script>

<style>
.loader {
  border-bottom-color: transparent !important;
  border-radius: 50%;
  display: inline-block;
  box-sizing: border-box;
  animation: rotation 1s linear infinite;
}

@keyframes rotation {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>
