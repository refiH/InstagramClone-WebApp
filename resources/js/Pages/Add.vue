<template>
  <div>
    <Head>
      <title>Add &#x2022;</title>
    </Head>

    <Main :aside="true">
      <h6 class="text-red-500 text-2xl font-semibold">Add</h6>
    </Main>
  </div>
</template>

<script>
import Main from '../Layouts/Main.vue';
import { Head } from '@inertiajs/vue3';

export default {
  components: { Main, Head },
};
</script>
