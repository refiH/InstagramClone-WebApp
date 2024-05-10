<template>
  <div>
    <Head>
      <title>Add &#x2022;</title>
    </Head>

    <Main>
      <form @submit.prevent="submitForm" class="mx-auto flex gap-4 p-8 max-w-[1280px]">
        <div
          class="border flex items-center justify-center w-[28rem] h-[calc(100vh_-_4rem)] sticky top-8 left-0 rounded"
          :class="isDark ? '' : 'bg-gray-100'"
        >
          <img class="object-contain h-full relative z-[1]" :src="imagePreview" alt="" />
          <div
            v-if="!imagePreview"
            class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"
          >
            <ImageIcon class="text-gray-400" :size="80" />
          </div>
        </div>

        <div class="flex-1 flex flex-col">
          <div class="mb-6">
            <label for="image" class="font-bold text-2xl">Image</label>
            <input
              id="image"
              type="file"
              accept="image/*"
              class="w-full border p-4 mt-2 rounded"
              @change="previewImage"
              @input="form.image = $event.target.files[0]"
            />
            <InputError :error="form.errors.image" />
          </div>

          <div class="flex flex-col">
            <label for="content" class="font-bold text-2xl">Caption</label>
            <textarea
              id="content"
              cols="30"
              rows="10"
              class="border p-3 mt-2 resize-none rounded"
              :class="isDark ? 'bg-dark' : 'bg-white'"
              v-model="form.content"
            ></textarea>
            <InputError :error="form.errors.content" />
          </div>

          <div class="flex gap-6 justify-end mt-auto">
            <button
              @click="resetForm"
              type="button"
              :disabled="form.processing"
              class="text-lg font-semibold bg-red-400 text-light px-4 py-2 rounded"
            >
              Reset
            </button>
            <button
              type="submit"
              :disabled="form.processing"
              class="text-lg font-semibold text-primary"
            >
              Submit
            </button>
          </div>
        </div>
      </form>
    </Main>
  </div>
</template>

<script>
import InputError from '../Components/InputError.vue';
import Main from '../Layouts/Main.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import ImageIcon from 'vue-material-design-icons/ImageOutline.vue';
import { useDark } from '@vueuse/core';

export default {
  components: { Main, Head, ImageIcon, InputError },
  data() {
    return {
      isDark: useDark(),
      imagePreview: ref(null),
      form: useForm({
        image: null,
        content: '',
      }),
    };
  },
  methods: {
    previewImage(e) {
      const image = e.target.files[0];
      const reader = new FileReader();
      reader.readAsDataURL(image);
      reader.onload = (e) => {
        this.imagePreview = e.target.result;
      };
    },
    convertNewLine() {
      this.form.content = this.form.content.replace(/\n/g, '<br>');
    },
    submitForm() {
      this.convertNewLine();
      this.form.post(route('post'));
      this.form.content = '';
    },
    resetForm() {
      this.form.image = '';
      this.form.content = '';
      this.imagePreview = null;
      document.getElementById('image').value = null;
    },
  },
};
</script>
