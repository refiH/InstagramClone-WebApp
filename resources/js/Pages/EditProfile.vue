<template>
  <div>
    <Head>
      <title>Edit Profile &#x2022;</title>
    </Head>

    <Main>
      <form @submit.prevent="saveImage" class="p-4">
        <!-- Profile Picture -->
        <div class="flex justify-center gap-8 border-b px-4 pb-6">
          <ImageCropper v-if="image" :image="image" @cropper-ref="handleCropperRef" />
          <img v-else :src="'/images/default_profile.jpg'" class="w-[15rem] aspect-square" />

          <div class="flex gap-2 h-fit my-auto relative">
            <h5 class="absolute -top-10 font-bold text-2xl">Profile Picture</h5>
            <button
              type="button"
              :disabled="imageForm.processing"
              class="h-fit bg-primary text-white rounded px-4 py-2 hover:bg-primary-dark transition"
              @click="$refs.file.click()"
            >
              <input
                type="file"
                ref="file"
                @input="loadImage($event)"
                accept="image/*"
                class="hidden"
              />
              Upload Image
            </button>
            <button
              type="submit"
              :disabled="imageForm.processing || !image"
              class="h-fit border border-primary text-primary rounded px-4 py-2 hover:bg-primary hover:text-white transition"
            >
              Save Image
            </button>
          </div>
        </div>
      </form>
    </Main>
  </div>
</template>

<script>
import Main from '../Layouts/Main.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import ImageCropper from '../Components/ImageCropper.vue';
import InputError from '../Components/InputError.vue';

export default {
  props: { user: Object },
  components: {
    Main,
    Head,
    ImageCropper,
    InputError,
  },
  setup() {
    return {
      cropperRef: ref(null),
      image: ref(null),
      imageForm: useForm({
        file: ref(null),
      }),
      form: useForm({
        username: ref(null),
        bio: ref(null),
      }),
    };
  },
  mounted() {
    if (this.user.image) {
      this.image = this.$page.props.storagePath + 'images/profile/' + this.user.image;
    }
  },
  methods: {
    loadImage(event) {
      const { files } = event.target;
      if (files && files[0]) {
        if (this.image) {
          URL.revokeObjectURL(this.image);
        }
        const blob = URL.createObjectURL(files[0]);

        const reader = new FileReader();
        reader.onload = () => {
          this.image = blob;
        };
        reader.readAsArrayBuffer(files[0]);
      }
    },
    saveImage() {
      const { canvas } = this.cropperRef.getResult();
      if (canvas) {
        canvas.toBlob((blob) => {
          this.imageForm.file = blob;
          this.imageForm.post(route('save-profile-image'), {
            onSuccess: () => {
              this.image = this.$page.props.storagePath + 'images/profile/' + this.user.image;
            },
          });
        }, 'image/jpeg');
      }
    },
    handleCropperRef(ref) {
      this.cropperRef = ref;
    },
  },
};
</script>
