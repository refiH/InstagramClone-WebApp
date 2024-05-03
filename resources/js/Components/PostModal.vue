<template>
  <Modal :modal-active="modalActive" @close-modal="toggleModal">
    <div class="bg-white rounded-sm">
      <div v-if="!loading && postData" class="flex min-w-[75vw] max-w-[75vw] h-[90vh]">
        <div class="bg-black flex items-center justify-center flex-[4_4_0%]">
          <img
            class="object-contain h-full"
            :src="postData.image"
            :alt="`Post by ${postData.user.username}`"
          />
        </div>

        <div class="flex-[5_5_0%] flex flex-col">
          <!-- Account -->
          <div class="px-4 py-3 flex items-center border-b">
            <ProfilePicture :src="postData.user.image" :alt="postData.user.username" class="mr-4" />

            <span class="text-sm font-semibold cursor-pointer w-fit hover:underline transition">
              {{ postData.user.username }}
            </span>

            <div class="mx-2 text-xs">&#x2022;</div>
            <p class="text-sm font-semibold text-gray-400">
              {{ formatTime(postData.created_at) }}
            </p>
          </div>

          <!-- Caption & Comments -->
          <div class="no-scrollbar overflow-y-auto flex-[4_4_0%] border-b">
            <!-- Caption -->
            <div class="border-b p-4 flex gap-4">
              <div class="w-8 h-8 flex-[0_0_auto]"></div>

              <div>
                <p class="text-sm mb-1">
                  {{ postData.content }}
                </p>

                <span class="text-xs text-gray-400">
                  {{ formatTime(postData.created_at) }}
                </span>
              </div>
            </div>

            <!-- Comments -->
            <div class="flex flex-col">
              <div v-if="commentsLoading" class="flex justify-center mt-4">
                <Spinner :size="36" />
              </div>

              <div
                v-else
                v-for="(comment, i) in commentsData"
                :key="i"
                class="text-xs px-4 py-3 flex items-center gap-4"
              >
                <ProfilePicture :src="comment.user.image" :alt="comment.user.username" />
                <p>
                  <span class="font-semibold cursor-pointer w-fit hover:underline transition">
                    {{ comment.user.username }}
                  </span>
                  {{ comment.content }}
                  <br />
                  <span class="text-xs text-gray-400">
                    {{ formatTime(comment.created_at) }}
                  </span>
                </p>
              </div>

              <button
                v-if="
                  !commentsLoading &&
                  !commentsMoreLoading &&
                  postData.comments_count != commentsData.length
                "
                @click="fetchMoreComments(postId)"
                class="font-semibold text-sm text-blue-400 mb-4"
              >
                Load more
              </button>

              <div v-if="commentsMoreLoading" class="flex justify-center mb-4">
                <Spinner :size="36" />
              </div>
            </div>
          </div>

          <div class="flex-1">
            <!-- Actions -->
            <div class="flex items-center p-4 border-b">
              <HeartOutlineIcon :size="24" />
              <p class="text-sm font-medium ml-2 mr-4">
                {{ postData.likes_count }}
              </p>
              <CommentIcon :size="24" class="scale-x-[-1]" />
              <p class="text-sm font-medium ml-2">
                {{ postData.comments_count }}
              </p>
            </div>

            <div class="w-100 flex items-center gap-2 pl-2 pr-4 text-sm">
              <textarea
                placeholder="Add a comment..."
                rows="3"
                cols="0"
                wrap="soft"
                class="flex-1 px-2 py-4 outline-none resize-none"
              ></textarea>
              <button class="font-semibold text-blue-400">Post</button>
            </div>
          </div>
        </div>
      </div>

      <div v-else class="flex min-w-[75vw] max-w-[75vw] h-[90vh]">
        <div class="bg-black flex-[4_4_0%]"></div>
        <div class="flex-[5_5_0%] flex items-center justify-center">
          <Spinner />
        </div>
      </div>
    </div>
  </Modal>
</template>

<script>
import Modal from './Modal.vue';
import ProfilePicture from './ProfilePicture.vue';
import Spinner from './Spinner.vue';
import HeartOutlineIcon from 'vue-material-design-icons/HeartOutline.vue';
import CommentIcon from 'vue-material-design-icons/CommentOutline.vue';
import axios from 'axios';
import { ref } from 'vue';

export default {
  emits: ['toggle-modal'],
  props: {
    modalActive: Boolean,
    postId: String,
  },
  components: {
    Modal,
    ProfilePicture,
    HeartOutlineIcon,
    CommentIcon,
    Spinner,
  },
  setup() {
    return {
      postData: ref(null),
      commentsData: ref([]),
      loading: ref(false),
      commentsLoading: ref(false),
      commentsMoreLoading: ref(false),
    };
  },
  watch: {
    modalActive(newVal) {
      if (newVal) {
        this.fetchPost(this.postId);
      } else {
        setTimeout(() => {
          this.postData = null;
          this.commentsData = [];
        }, 1000);
      }
    },
  },
  methods: {
    async fetchPost(post) {
      try {
        this.loading = true;
        let response = await axios.get(route('get-post', { post: post }));
        this.postData = response.data;
      } catch (error) {
        console.error('Error fetching post: ', error);
      } finally {
        this.loading = false;
        this.fetchComments(post);
      }
    },
    async fetchComments(post) {
      try {
        this.commentsLoading = true;
        let response = await axios.get(route('get-comments', { post: post }));
        this.commentsData = response.data.data;
      } catch (error) {
        console.error('Error fetching comments: ', error);
      } finally {
        this.commentsLoading = false;
      }
    },
    async fetchMoreComments(post) {
      try {
        this.commentsMoreLoading = true;
        const nextPage = Math.ceil(this.commentsData.length / 5) + 1;
        let response = await axios.get(route('get-comments', { post: post, page: nextPage }));
        this.commentsData = [...this.commentsData, ...response.data.data];
      } catch (error) {
        console.error('Error fetching comments: ', error);
      } finally {
        this.commentsMoreLoading = false;
      }
    },
    toggleModal() {
      this.$emit('toggle-modal');
    },
    formatTime(date) {
      const now = new Date();
      const createdDate = new Date(date);

      const timeDiff = Math.abs(now - createdDate);

      const days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
      const hours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((timeDiff % (1000 * 60)) / 1000);

      let result = '';
      if (days > 0) {
        result = days + 'd';
      } else if (hours > 0) {
        result = hours + 'hr';
      } else if (minutes > 0) {
        result = minutes + 'm';
      } else {
        result = seconds + 's';
      }

      result = result.replace(/,\s*$/, '');

      return result;
    },
  },
};
</script>
