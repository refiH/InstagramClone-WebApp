<template>
  <Head>
    <title>Add &#x2022;</title>
  </Head>

  <Main :aside="true">
    <h6 class="text-red-500 text-2xl font-semibold">Add</h6>
  </Main>
</template>

<script>
import Main from '../Layouts/Main.vue';
import { Head } from '@inertiajs/inertia-vue3';

export default {
  components: { Main, Head },
};
</script>
