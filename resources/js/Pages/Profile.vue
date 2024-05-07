<template>
  <div>
    <Head>
      <title>{{ user.username }} &#x2022;</title>
    </Head>

    <Main aside>PROFILE</Main>
  </div>
</template>

<script>
import Main from '../Layouts/Main.vue';
import { Head } from '@inertiajs/vue3';

export default {
  props: {
    user: Object,
  },
  components: {
    Head,
    Main,
  },
  setup(props) {
    console.log(props.user);
    return {};
  },
};
</script>
