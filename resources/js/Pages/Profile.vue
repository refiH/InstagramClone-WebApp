<template>
  <div>
    <Head>
      <title>{{ user.username }} &#x2022;</title>
    </Head>

    <Main>
      <section class="w-[60rem] mx-auto">
        <!-- Avatar -->
        <div class="flex items-center gap-32 py-8 border-b px-16 relative">
          <ProfilePicture
            :size="160"
            :src="$page.props.storagePath + 'images/profile/' + user.image"
          />

          <div class="flex-1">
            <h5 class="font-semibold text-xl">{{ user.username }}</h5>

            <!-- Stats -->
            <div class="flex gap-10 mt-2 mb-4">
              <div class="flex gap-1">
                <h6 class="font-bold">{{ user.posts_count }}</h6>
                <h6>posts</h6>
              </div>

              <div class="flex gap-1">
                <h6 class="font-bold">{{ user.followers_count }}</h6>
                <h6>followers</h6>
              </div>

              <div class="flex gap-1">
                <h6 class="font-bold">{{ user.follows_count }}</h6>
                <h6>following</h6>
              </div>
            </div>

            <!-- Bio -->
            <p class="max-w-[480px] text-sm">
              {{ user.bio }}
            </p>
          </div>

          <Link
            v-if="$page.props.auth.user.username == user.username"
            :href="route('edit-profile')"
            class="absolute right-8 bottom-4"
          >
            <button
              class="text-sm px-3 py-1 border rounded text-primary border-primary hover:bg-primary hover:text-white transition"
            >
              Edit Profile
            </button>
          </Link>
        </div>

        <!-- Posts -->
        <div class="pt-6 pb-1 px-8">
          <!-- Loading & Handle -->
          <div v-if="loading" class="flex justify-center items-center mt-8">
            <Spinner />
          </div>

          <div
            v-if="postsData.length == 0 && !loading"
            class="flex justify-center items-center mt-8"
          >
            No post found.
          </div>
          <!-- End-Loading & Handle -->

          <!-- Grid -->
          <div v-else class="grid grid-cols-3 gap-1">
            <div
              v-for="(post, i) in postsData"
              :key="i"
              class="group relative cursor-pointer border aspect-[4/3]"
              @click="toggleModal(post.id)"
            >
              <img
                class="object-cover aspect-[inherit] w-full"
                :src="$page.props.storagePath + 'images/posts/' + post.image"
                :alt="`Post by ${user.username}`"
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
          <!-- End-Grid -->

          <!-- More Posts -->
          <div v-if="moreLoading" class="flex justify-center my-6 w-full">
            <Spinner />
          </div>

          <button
            v-if="!moreLoading && !loading && user.posts_count > postsData.length"
            @click="fetchMoreUserPosts"
            class="font-semibold text-primary my-4 block mx-auto"
          >
            Load more
          </button>
          <!-- End-More Posts -->
        </div>
      </section>

      <PostModal
        :modal-active="modalActive"
        @toggle-modal="toggleModal"
        :post-id="selectedPost"
        @fetch-data="fetchUserPosts"
      />
    </Main>
  </div>
</template>

<script>
import Main from '../Layouts/Main.vue';
import ProfilePicture from '../Components/ProfilePicture.vue';
import Spinner from '../Components/Spinner.vue';
import PostModal from '../Components/PostModal.vue';
import CommentIcon from 'vue-material-design-icons/CommentOutline.vue';
import HeartIcon from 'vue-material-design-icons/HeartOutline.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';

export default {
  props: {
    user: Object,
  },
  components: {
    Head,
    Main,
    ProfilePicture,
    Spinner,
    PostModal,
    HeartIcon,
    CommentIcon,
    Link,
  },
  setup(props) {
    return {
      loading: ref(false),
      moreLoading: ref(false),
      modalActive: ref(false),
      postsData: ref([]),
      selectedPost: ref(null),
      dataCount: 9,
    };
  },
  mounted() {
    this.fetchUserPosts();
  },
  methods: {
    async fetchUserPosts() {
      try {
        this.loading = true;
        let response = await axios.get(
          route('get-user-posts', { username: this.user.username, count: this.dataCount }),
        );
        this.postsData = response.data.data;
      } catch (error) {
        console.error('Error fetching posts: ', error);
      } finally {
        this.loading = false;
      }
    },
    async fetchMoreUserPosts() {
      try {
        this.moreLoading = true;
        const nextPage = Math.ceil(this.postsData.length / this.dataCount) + 1;
        let response = await axios.get(
          route('get-posts', {
            username: this.user.username,
            count: this.dataCount,
            page: nextPage,
          }),
        );
        this.postsData = [...this.postsData, ...response.data.data];
      } catch (error) {
        console.error('Error fetching posts: ', error);
      } finally {
        this.moreLoading = false;
      }
    },
    toggleModal(postId) {
      this.modalActive = !this.modalActive;
      this.selectedPost = postId;
    },
  },
};
</script>
