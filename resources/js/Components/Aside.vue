<template>
  <div class="my-4 mr-8 px-1 pt-1 sticky top-4 overflow-y-auto no-scrollbar">
    <aside class="flex-[1_1_0%] h-fit shadow py-8 px-6 max-w-96">
      <!-- Avatar -->
      <div class="flex h-fit w-full gap-4 items-center">
        <ProfilePicture :size="52" />
        <div>
          <h6
            class="font-bold truncate max-w-64 cursor-pointer w-fit hover:underline transition"
          >
            refih15
          </h6>
          <p class="text-xs truncate max-w-64">
            Lorem ipsum dolor sit amet consectetur adipisicing elit Tempora
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
                  {{ suggestion.followedBy.toString().split(",").join(", ") }}
                </p>
              </div>

              <p class="text-sm font-semibold text-blue-400 cursor-pointer">
                Follow
              </p>
            </div>
          </div>
        </div>
      </div>
    </aside>

    <!-- Copyright -->
    <footer class="mt-6 text-sm text-[rgba(0,0,0,.4)]">
      &copy; 2024 INERTIAGRAM
    </footer>
  </div>
</template>

<script>
import ProfilePicture from "./ProfilePicture.vue";
import { Link } from "@inertiajs/inertia-vue3";

export default {
  data() {
    return {
      suggestions: [
        {
          name: "igndotcom",
          followedBy: ["lorem", "dolor"],
        },
        {
          name: "repostrandy",
          followedBy: ["lorem", "sit", "amet"],
        },
        {
          name: "xandillionaire_grindset",
          followedBy: ["onsectetur", "dolor", "adipisicingasdasdaskjdaksjdh"],
        },
        {
          name: "hardimages",
          followedBy: ["elit", "tempora"],
        },
      ],
    };
  },
  components: { ProfilePicture },
};
</script>
