<template>
  <div>
    <Head>
      <title>Login &#x2022;</title>
    </Head>

    <Blank>
      <main
        class="h-screen flex items-center justify-center bg-gradient-to-br from-blue-200 to-primary"
      >
        <form
          @submit.prevent="form.post(route('auth.login'))"
          class="bg-white border border-gray-300 min-h-[30rem] w-[25rem] px-8 pt-12 flex flex-col rounded"
        >
          <div class="w-[4.5rem] h-[4.5rem] mx-auto mb-10">
            <img loading="lazy" :src="icon" alt="Logo" class="object-contain" />
          </div>

          <div class="mb-4">
            <input
              id="email"
              v-model="form.email"
              type="text"
              placeholder="Email or username"
              @keydown="restrictCharacters"
              :maxlength="320"
              class="outline-none border border-gray-300 rounded-sm px-4 py-2 w-full"
              :class="form.errors.email ? 'border-red-400' : ''"
            />
            <InputError :error="form.errors.email" />
          </div>

          <div class="mb-6">
            <input
              id="password"
              v-model="form.password"
              type="password"
              placeholder="Password"
              class="outline-none border border-gray-300 rounded-sm px-4 py-2 w-full"
              :class="form.errors.password ? 'border-red-400' : ''"
            />
            <InputError :error="form.errors.password" />
          </div>

          <button
            type="submit"
            :disabled="form.processing"
            class="bg-primary text-white font-semibold py-2 rounded transition hover:bg-primary-dark"
          >
            Login
          </button>

          <button class="text-sm text-gray-500 mt-3 w-fit">Forgot password?</button>

          <div class="text-sm text-gray-500 block m-auto">
            Don't have an account?
            <Link :href="route('auth.register-page')" class="text-primary font-semibold">
              Sign up
            </Link>
          </div>

          <p v-if="error" class="text-red-400 text-sm text-center mb-8">{{ error }}</p>
        </form>
      </main>
    </Blank>
  </div>
</template>

<script>
import Blank from '../../Layouts/Blank.vue';
import InputError from '../../Components/InputError.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

export default {
  props: {
    error: String,
  },
  components: {
    Blank,
    Head,
    Link,
    InputError,
  },
  data() {
    return {
      icon: '/icon-192.png',
      form: useForm({
        email: null,
        password: null,
      }),
    };
  },
  methods: {
    restrictCharacters(event) {
      const allowedCharacters = /[a-zA-Z0-9._@-]/;

      if (!allowedCharacters.test(event.key)) {
        event.preventDefault();
      }
    },
  },
};
</script>
