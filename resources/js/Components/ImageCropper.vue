<template>
  <cropper
    ref="cropper"
    class="w-[15rem] aspect-square bg-gray-100"
    :src="image"
    :stencil-component="$options.components.CircleStencil"
    :stencil-props="{
      aspectRatio: 1 / 1,
    }"
  />
</template>

<script>
import { ref } from 'vue';
import { Cropper, CircleStencil } from 'vue-advanced-cropper';
import 'vue-advanced-cropper/dist/style.css';

export default {
  emits: ['cropper-ref'],
  props: { image: String },
  components: { Cropper, CircleStencil },
  mounted() {
    this.$emit('cropper-ref', this.$refs.cropper);
  },
  setup(props) {
    return {
      img: ref(props.img),
    };
  },
};
</script>
