<template>
  <div class="flex items-center">
    <button type="submit" :disabled="form.processing" @click="activate" class="h-6 w-6">
      <HeartIcon v-if="form.status" :size="24" fill-color="#ff0000" />
      <HeartOutlineIcon v-else :size="24" />
    </button>
    <p class="text-sm font-medium ml-2 mr-4">{{ likesCount }}</p>
  </div>
</template>

<script>
import HeartOutlineIcon from 'vue-material-design-icons/HeartOutline.vue';
import HeartIcon from 'vue-material-design-icons/Heart.vue';
import { ref } from 'vue';
import axios from 'axios';

export default {
  props: {
    postId: String,
    count: Number,
    status: Boolean,
  },
  components: {
    HeartOutlineIcon,
    HeartIcon,
  },
  setup(props) {
    return {
      likesCount: ref(props.count),
      form: ref({
        postId: props.postId,
        status: props.status,
      }),
    };
  },
  methods: {
    activate() {
      this.form.status = !this.form.status;
      this.submitLike();
    },
    submitLike() {
      axios
        .post(route('like'), this.form)
        .then((res) => {
          if (res.data.message == 'added') {
            this.likesCount = res.data.count;
            this.form.status = true;
          } else {
            this.likesCount = res.data.count;
            this.form.status = false;
          }
        })
        .catch((error) => {
          console.error('Error liking post: ', error);
        });
    },
  },
};
</script>
