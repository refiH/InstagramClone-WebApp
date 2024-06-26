<template>
  <div>
    <Head>
      <title></title>
    </Head>

    <Main aside>
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
              <ProfilePicture
                :src="$page.props.storagePath + 'images/profile/' + post.user.image"
                :href="route('profile', { username: post.user.username })"
              />

              <UserLink :username="post.user.username" class="text-sm ml-3" />
              <div class="mx-2 text-xs">&#x2022;</div>
              <DateTime class="font-semibold" :date="post.created_at" />

              <Dropdown v-if="$page.props.auth.user.username == post.user.username" class="ml-auto">
                <template #toggler>
                  <button>
                    <DotsIcon class="cursor-pointer" />
                  </button>
                </template>
                <DropdownContent>
                  <form @submit.prevent="deletePost(post.id)">
                    <DropdownItem class="flex gap-3 items-center">
                      <DeleteIcon />
                      Delete
                    </DropdownItem>
                  </form>
                </DropdownContent>
              </Dropdown>
            </div>

            <!-- Post-Image -->
            <div class="bg-black flex items-center justify-center">
              <img
                class="object-contain min-h-[15rem] max-h-[35rem] text-white"
                :src="$page.props.storagePath + 'images/posts/' + post.image"
                :alt="`Post by by ${post.user.username}`"
              />
            </div>

            <!-- Post-Actions -->
            <div class="flex items-center mt-3">
              <Like
                :post-id="post.id"
                :count="post.likes_count"
                :status="post.likes.length == 0 ? false : true"
              />
              <CommentIcon :size="24" class="scale-x-[-1]" />
              <p class="text-sm font-medium ml-2">
                {{ post.comments_count }}
              </p>
            </div>

            <!-- Post-Caption -->
            <p class="text-sm line-clamp-3 mt-3">
              <UserLink :username="post.user.username" />
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
            class="font-semibold text-primary mb-4 block mx-auto"
          >
            Load more
          </button>
        </div>
      </section>

      <PostModal
        :modal-active="modalActive"
        @toggle-modal="toggleModal"
        :post-id="selectedPost"
        @fetch-data="fetchPosts"
      />
    </Main>
  </div>
</template>

<script>
import Main from '../Layouts/Main.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import ProfilePicture from '../Components/ProfilePicture.vue';
import Spinner from '../Components/Spinner.vue';
import UserLink from '../Components/UserLink.vue';
import HeartOutlineIcon from 'vue-material-design-icons/HeartOutline.vue';
import CommentIcon from 'vue-material-design-icons/CommentOutline.vue';
import DotsIcon from 'vue-material-design-icons/DotsHorizontal.vue';
import DeleteIcon from 'vue-material-design-icons/Delete.vue';
import PostModal from '../Components/PostModal.vue';
import Like from '../Components/Like.vue';
import { ref } from 'vue';
import axios from 'axios';
import DateTime from '../Components/DateTime.vue';
import Dropdown from '../Components/Dropdown.vue';
import DropdownContent from '../Components/DropdownContent.vue';
import DropdownItem from '../Components/DropdownItem.vue';

export default {
  props: {
    postsCount: Number,
  },
  components: {
    Main,
    DotsIcon,
    HeartOutlineIcon,
    CommentIcon,
    DeleteIcon,
    ProfilePicture,
    PostModal,
    Spinner,
    Head,
    Like,
    Link,
    UserLink,
    DateTime,
    Dropdown,
    DropdownContent,
    DropdownItem,
  },
  setup() {
    return {
      postsData: ref([]),
      modalActive: ref(false),
      selectedPost: ref(null),
      loading: ref(false),
      moreLoading: ref(false),
      dataCount: 5,
      deleteForm: useForm({
        id: ref(null),
      }),
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
    deletePost(id) {
      this.deleteForm.id = id;
      this.deleteForm.delete(route('delete'), {
        onSuccess: () => {
          this.fetchPosts();
        },
      });
    },
    toggleModal(post) {
      this.modalActive = !this.modalActive;
      this.selectedPost = post;
    },
  },
};
</script>
