<template>
  <div>
    <Head>
      <title>Explore &#x2022;</title>
    </Head>

    <Main>
      <section class="pt-3 pb-1">
        <div v-if="loading" class="flex justify-center items-center h-[92.5vh]">
          <Spinner />
        </div>

        <div
          v-if="postsData.length == 0 && !loading"
          class="flex justify-center items-center h-[92.5vh]"
        >
          No post found.
        </div>

        <div v-else class="w-[60rem] mx-auto grid grid-cols-3 gap-1 pt-10">
          <div
            v-for="(post, i) in postsData"
            @click="toggleModal(post.id)"
            :key="i"
            class="group relative cursor-pointer border"
            :class="{ 'row-span-2': isPatternMatch(i + 1) }"
          >
            <img
              class="object-cover"
              :class="isPatternMatch(i + 1) ? 'h-full' : 'aspect-[4/3]'"
              :src="$page.props.storagePath + 'posts/images/' + post.image"
              :alt="`Post by ${post.user.username}`"
            />

            <!-- Backdrop -->
            <div
              class="bg-[rgba(0,0,0,0.5)] text-white opacity-0 group-hover:opacity-100 absolute inset-0 transition flex items-center justify-center"
            >
              <HeartIcon :size="24" class="scale-x-[-1]" />
              <p class="text-sm font-semibold ml-2 mr-4">
                {{ post.likes_count }}
              </p>
              <CommentIcon :size="24" class="scale-x-[-1]" />
              <p class="text-sm font-semibold ml-2">
                {{ post.comments_count }}
              </p>
            </div>
          </div>
        </div>

        <!-- More-Posts -->
        <div v-if="moreLoading" class="flex justify-center my-6 w-full">
          <Spinner />
        </div>

        <button
          v-if="!moreLoading && !loading && postsCount > postsData.length"
          @click="fetchMoreRandomPosts"
          class="font-semibold text-blue-400 my-4 block mx-auto"
        >
          Load more
        </button>
      </section>

      <PostModal :modal-active="modalActive" @toggle-modal="toggleModal" :post-id="selectedPost" />
    </Main>
  </div>
</template>

<script>
import PostModal from '../Components/PostModal.vue';
import Main from '../Layouts/Main.vue';
import { Head } from '@inertiajs/vue3';
import CommentIcon from 'vue-material-design-icons/CommentOutline.vue';
import HeartIcon from 'vue-material-design-icons/HeartOutline.vue';
import { ref } from 'vue';
import axios from 'axios';
import Spinner from '../Components/Spinner.vue';

export default {
  setup() {
    return {
      postsData: ref([]),
      modalActive: ref(false),
      selectedPost: ref(null),
      loading: ref(false),
      moreLoading: ref(false),
      dataCount: 10,
    };
  },
  props: {
    postsCount: Number,
  },
  components: { Main, Head, CommentIcon, HeartIcon, PostModal, Spinner },
  mounted() {
    this.fetchRandomPosts();
  },
  methods: {
    async fetchRandomPosts() {
      try {
        this.loading = true;
        let response = await axios.get(route('get-random-posts', { count: this.dataCount }));
        this.postsData = response.data.data;
      } catch (error) {
        console.error('Error fetching posts: ', error);
      } finally {
        this.loading = false;
      }
    },
    async fetchMoreRandomPosts() {
      try {
        this.moreLoading = true;
        const nextPage = Math.ceil(this.postsData.length / this.dataCount) + 1;
        let response = await axios.get(
          route('get-posts', { count: this.dataCount, page: nextPage }),
        );
        this.postsData = [...this.postsData, ...response.data.data];
      } catch (error) {
        console.error('Error fetching posts: ', error);
      } finally {
        this.moreLoading = false;
      }
    },
    isPatternMatch(index) {
      return index % 10 === 3 || index % 10 === 6;
    },
    toggleModal(postId) {
      this.modalActive = !this.modalActive;
      this.selectedPost = postId;
    },
  },
};
</script>
