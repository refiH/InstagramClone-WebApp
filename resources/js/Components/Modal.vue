<template>
  <Teleport to="#app">
    <Transition name="modal-outer">
      <div
        v-show="modalActive"
        class="fixed w-full bg-black bg-opacity-50 h-screen top-0 left-0 flex justify-center items-center px-8 z-50"
      >
        <Transition name="modal-inner">
          <slot />
        </Transition>

        <button
          @click="$emit('close-modal')"
          class="text-white absolute top-4 right-4"
        >
          <CloseIcon :size="32" class="duration-150 cursor-pointer" />
        </button>
      </div>
    </Transition>
  </Teleport>
</template>

<script>
import CloseIcon from "vue-material-design-icons/Close.vue";

export default {
  components: {
    CloseIcon,
  },
  emits: ["close-modal"],
  props: {
    modalActive: Boolean,
    class: String,
  },
};
</script>

<style scoped>
.modal-outer-enter-active,
.modal-outer-leave-active {
  transition: opacity 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02);
}

.modal-outer-enter-from,
.modal-outer-leave-to {
  opacity: 0;
}

.modal-inner-enter-active {
  transition: all 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02) 0.15s;
}
.modal-inner-leave-active {
  transition: all 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02);
}

.modal-inner-enter-from {
  opacity: 0;
  transform: translateY(5%);
}
.modal-inner-leave-to {
  transform: translateY(5%);
}
</style>
