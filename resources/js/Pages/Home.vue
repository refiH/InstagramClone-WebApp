<template>
  <div>
    <Head>
      <title></title>
    </Head>

    <Main :aside="true">
      <section class="w-[28rem] mx-auto pt-16 pb-2">
        <!-- Post -->
        <div v-if="loading" class="flex justify-center">
          <Spinner />
        </div>

        <div v-if="postsData.length == 0 && !loading" class="flex justify-center">
          No post found.
        </div>

        <div v-else>
          <div v-for="(post, i) in postsData" :key="i">
            <!-- Post-Account -->
            <div class="flex items-center mb-3">
              <ProfilePicture :src="post.user.image" />

              <p class="text-sm font-bold cursor-pointer ml-3 truncate max-w-80 hover:underline">
                {{ post.user.username }}
              </p>
              <div class="mx-2 text-xs">&#x2022;</div>
              <p class="text-sm font-semibold text-gray-400">
                {{ formatTime(post.created_at) }}
              </p>

              <DotsIcon class="ml-auto cursor-pointer" />
            </div>

            <!-- Post-Image -->
            <div class="bg-black flex items-center justify-center">
              <img
                class="object-contain min-h-[15rem] max-h-[35rem] text-white"
                :src="$page.props.storagePath + 'posts/images/' + post.image"
                :alt="`Post by by ${post.user.username}`"
              />
            </div>

            <!-- Post-Actions -->
            <div class="flex items-center mt-3">
              <HeartOutlineIcon :size="24" />
              <p class="text-sm font-medium ml-2 mr-4">{{ post.likes_count }}</p>
              <CommentIcon :size="24" class="scale-x-[-1]" />
              <p class="text-sm font-medium ml-2">
                {{ post.comments_count }}
              </p>
            </div>

            <!-- Post-Caption -->
            <p class="text-sm line-clamp-3 mt-3">
              <span class="font-bold cursor-pointer hover:underline transition mr-1">
                {{ post.user.username }}
              </span>
              <span v-html="post.content"></span>
            </p>

            <button
              class="font-semibold text-sm text-gray-400 underline"
              @click="toggleModal(post.id)"
            >
              see more
            </button>

            <!-- Post-Divider -->
            <div class="w-full border border-gray-200 my-6"></div>
          </div>

          <div v-if="moreLoading" class="flex justify-center pb-2">
            <Spinner />
          </div>

          <button
            v-if="!moreLoading && !loading && postsCount > postsData.length"
            @click="fetchMorePosts"
            class="font-semibold text-blue-400 mb-4 block mx-auto"
          >
            Load more
          </button>
        </div>
      </section>

      <PostModal :modal-active="modalActive" @toggle-modal="toggleModal" :post-id="selectedPost" />
    </Main>
  </div>
</template>

<script>
import Main from '../Layouts/Main.vue';
import { Head } from '@inertiajs/vue3';
import ProfilePicture from '../Components/ProfilePicture.vue';
import Spinner from '../Components/Spinner.vue';
import HeartOutlineIcon from 'vue-material-design-icons/HeartOutline.vue';
import CommentIcon from 'vue-material-design-icons/CommentOutline.vue';
import DotsIcon from 'vue-material-design-icons/DotsHorizontal.vue';
import PostModal from '../Components/PostModal.vue';
import { ref } from 'vue';
import axios from 'axios';

export default {
  props: {
    postsCount: Number,
  },
  components: {
    Main,
    DotsIcon,
    HeartOutlineIcon,
    CommentIcon,
    ProfilePicture,
    PostModal,
    Spinner,
    Head,
  },
  setup() {
    return {
      postsData: ref([]),
      modalActive: ref(false),
      selectedPost: ref(null),
      loading: ref(false),
      moreLoading: ref(false),
      dataCount: 5,
    };
  },
  mounted() {
    this.fetchPosts();
    //   this.handleScroll();
  },
  methods: {
    async fetchPosts() {
      try {
        this.loading = true;
        let response = await axios.get(route('get-posts', { count: this.dataCount }));
        this.postsData = response.data.data;
      } catch (error) {
        console.error('Error fetching posts: ', error);
      } finally {
        this.loading = false;
      }
    },
    async fetchMorePosts() {
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
    // handleScroll() {
    //   window.addEventListener('scroll', () => {
    //     let bottomOfWindow =
    //       document.documentElement.scrollTop + window.innerHeight ===
    //       document.documentElement.offsetHeight;
    //     console.log(bottomOfWindow);

    //     if (bottomOfWindow) {
    //       this.fetchMorePosts();
    //     }
    //   });
    // },
    toggleModal(post) {
      this.modalActive = !this.modalActive;
      this.selectedPost = post;
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
