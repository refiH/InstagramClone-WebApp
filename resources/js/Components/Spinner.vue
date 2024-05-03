<template>
  <span class="loader" :style="`height: ${size}px; width: ${size}px;`"></span>
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
  border: 4px solid rgb(96 165 250);
  border-bottom-color: transparent;
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
