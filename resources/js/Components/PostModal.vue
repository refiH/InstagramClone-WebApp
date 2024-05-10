<template>
  <Modal :modal-active="modalActive" @close-modal="toggleModal">
    <div class="bg-white rounded-sm">
      <div v-if="!loading && postData" class="flex min-w-[75vw] max-w-[75vw] h-[90vh]">
        <div class="bg-black flex items-center justify-center flex-[4_4_0%]">
          <img
            class="object-contain h-full text-white"
            :src="$page.props.storagePath + 'images/posts/' + postData.image"
            :alt="`Post by ${postData.user.username}`"
          />
        </div>

        <div class="flex-[5_5_0%] flex flex-col">
          <!-- Account -->
          <div class="px-4 py-3 flex items-center border-b">
            <ProfilePicture
              :src="$page.props.storagePath + 'images/profile/' + postData.user.image"
              class="mr-4"
              :href="route('profile', { username: postData.user.username })"
            />

            <UserLink :username="postData.user.username" class="text-sm font-semibold" />

            <!-- <div class="mx-2 text-xs">&#x2022;</div>
            <p class="text-sm font-semibold text-gray-400">
              {{ formatTime(postData.created_at) }}
            </p> -->
          </div>

          <!-- Caption & Comments -->
          <div class="no-scrollbar overflow-y-auto flex-[4_4_0%] border-b">
            <!-- Caption -->
            <div class="border-b p-4 flex gap-4">
              <div class="w-8 h-8 flex-[0_0_auto]"></div>

              <div>
                <p v-html="postData.content" class="text-sm mb-1"></p>

                <DateTime :date="postData.created_at" class="text-xs" />
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
                <ProfilePicture
                  :src="$page.props.storagePath + 'images/profile/' + comment.user.image"
                  :href="route('profile', { username: comment.user.username })"
                />
                <div>
                  <UserLink :username="comment.user.username" class="font-semibold mr-1" />
                  <span v-html="comment.content"></span>
                  <br />
                  <DateTime :date="comment.created_at" class="text-xs mt-1" />
                </div>
              </div>

              <div
                v-if="commentsData.length == 0 && !commentsLoading"
                class="flex justify-center text-sm pt-4"
              >
                No comment found.
              </div>

              <button
                v-if="
                  !commentsLoading &&
                  !commentsMoreLoading &&
                  postData.comments_count > commentsData.length
                "
                @click="fetchMoreComments(postId)"
                class="font-semibold text-sm text-primary mb-4"
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
              <Like
                :post-id="postData.id"
                :count="postData.likes_count"
                :status="postData.likes.length == 0 ? false : true"
              />
              <CommentIcon :size="24" class="scale-x-[-1]" />
              <p class="text-sm font-medium ml-2">
                {{ postData.comments_count }}
              </p>
            </div>

            <form
              @submit.prevent="submitCommentForm"
              class="w-full flex items-center gap-2 pl-2 pr-4 text-sm"
            >
              <textarea
                placeholder="Add a comment..."
                rows="3"
                cols="0"
                wrap="soft"
                class="flex-1 px-2 py-4 outline-none resize-none"
                v-model="form.content"
              ></textarea>
              <button type="submit" :disabled="form.processing" class="font-semibold text-primary">
                Post
              </button>
            </form>
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
import UserLink from './UserLink.vue';
import DateTime from './DateTime.vue';
import Spinner from './Spinner.vue';
import Like from './Like.vue';
import HeartOutlineIcon from 'vue-material-design-icons/HeartOutline.vue';
import CommentIcon from 'vue-material-design-icons/CommentOutline.vue';
import axios from 'axios';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

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
    Like,
    UserLink,
    DateTime,
  },
  setup() {
    return {
      postData: ref(null),
      commentsData: ref([]),
      loading: ref(false),
      commentsLoading: ref(false),
      commentsMoreLoading: ref(false),
      form: useForm({
        postId: null,
        content: '',
      }),
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
        this.form.postId = post;
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
    convertNewLine() {
      this.form.content = this.form.content.replace(/\n/g, '<br>');
    },
    submitCommentForm() {
      this.convertNewLine();
      this.form.post(route('comment'), {
        onSuccess: () => {
          this.fetchComments(this.postId);
          this.postData.comments_count += 1;
        },
      });
      this.form.content = '';
    },
  },
};
</script>
