<template>
  <div class="my-4 mr-8 px-1 pt-1 sticky top-4 overflow-y-auto no-scrollbar">
    <aside class="flex-[1_1_0%] h-fit shadow py-8 px-6 max-w-96">
      <!-- Avatar -->
      <div v-if="loading && !authUserData" class="flex h-fit w-full gap-4 items-center">
        <ProfilePicture :size="52" />
        <div>
          <Skeleton class="h-6 w-64 mb-1" />
          <Skeleton class="h-4 w-64" />
        </div>
      </div>

      <div v-else class="flex h-fit w-full gap-4 items-center">
        <ProfilePicture :src="authUserData.image" :size="52" />
        <div>
          <h6 class="font-bold truncate max-w-64 cursor-pointer w-fit hover:underline transition">
            {{ authUserData.username }}
          </h6>
          <p class="text-xs truncate max-w-64">
            {{ authUserData.bio }}
          </p>
        </div>
      </div>

      <!-- Suggestions -->
      <div class="mt-8">
        <div class="flex justify-between mb-4">
          <p class="text-sm font-semibold text-gray-600">You may know</p>
          <p class="text-sm font-bold text-dark">See all</p>
        </div>

        <div class="flex flex-col gap-4">
          <div
            v-for="(suggestion, i) in suggestions"
            :key="i"
            class="flex h-fit w-full gap-4 items-center"
          >
            <ProfilePicture :size="40" />

            <div class="flex w-full items-center justify-between">
              <div>
                <h6
                  class="font-bold truncate max-w-52 cursor-pointer w-fit hover:underline transition text-sm"
                >
                  {{ suggestion.name }}
                </h6>
                <p class="text-xs truncate max-w-52">
                  Followed by
                  {{ suggestion.followedBy.toString().split(',').join(', ') }}
                </p>
              </div>

              <p class="text-sm font-semibold text-blue-400 cursor-pointer">Follow</p>
            </div>
          </div>
        </div>
      </div>
    </aside>

    <!-- Copyright -->
    <footer class="mt-6 text-sm text-[rgba(0,0,0,.4)]">&copy; 2024 INERTIAGRAM</footer>
  </div>
</template>

<script>
import ProfilePicture from './ProfilePicture.vue';
import { ref } from 'vue';
import axios from 'axios';
import Skeleton from './Skeleton.vue';

export default {
  components: { ProfilePicture, Skeleton },
  data() {
    return {
      loading: ref(false),
      authUserData: ref(null),
      suggestions: [
        {
          name: 'igndotcom',
          followedBy: ['lorem', 'dolor'],
        },
        {
          name: 'repostrandy',
          followedBy: ['lorem', 'sit', 'amet'],
        },
        {
          name: 'xandillionaire_grindset',
          followedBy: ['onsectetur', 'dolor', 'adipisicingasdasdaskjdaksjdh'],
        },
        {
          name: 'hardimages',
          followedBy: ['elit', 'tempora'],
        },
      ],
    };
  },
  beforeMount() {
    this.fetchAuthUser();
  },
  methods: {
    async fetchAuthUser() {
      try {
        this.loading = true;
        let response = await axios.get(route('get-auth-user'));
        this.authUserData = response.data;
      } catch (error) {
        console.error('Error fetching auth user: ', error);
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>
