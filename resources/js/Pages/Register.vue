<template>
  <div>
    <Head>
      <title>Register &#x2022;</title>
    </Head>

    <Blank>
      <main
        class="h-screen flex items-center justify-center bg-gradient-to-br from-blue-200 to-blue-400"
      >
        <form
          @submit.prevent="form.post('register')"
          class="bg-white border border-gray-300 min-h-[30rem] w-[25rem] px-8 pt-12 flex flex-col rounded"
        >
          <div class="w-[4.5rem] h-[4.5rem] mx-auto mb-10">
            <img
              loading="lazy"
              src="../../../public/icon-192.png"
              alt="Logo"
              class="object-contain"
            />
          </div>

          <div class="mb-4">
            <input
              id="username"
              v-model="form.username"
              type="text"
              placeholder="Username"
              class="outline-none border border-gray-300 rounded-sm px-4 py-2 w-full"
              :class="form.errors.username ? 'border-red-400' : ''"
            />
            <InputError :error="form.errors.username" />
          </div>

          <div class="mb-4">
            <input
              id="email"
              v-model="form.email"
              type="text"
              placeholder="Email"
              class="outline-none border border-gray-300 rounded-sm px-4 py-2 w-full"
              :class="form.errors.email ? 'border-red-400' : ''"
            />
            <InputError :error="form.errors.email" />
          </div>

          <div class="mb-4">
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

          <div class="mb-6">
            <input
              id="password_confirmation"
              v-model="form.password_confirmation"
              type="password"
              placeholder="Confirm Password"
              class="outline-none border border-gray-300 rounded-sm px-4 py-2 w-full"
              :class="form.errors.password_confirmation ? 'border-red-400' : ''"
            />
            <InputError :error="form.errors.password_confirmation" />
          </div>

          <button
            type="submit"
            :disabled="form.processing"
            class="bg-blue-400 text-white font-semibold py-2 rounded transition hover:bg-blue-500"
          >
            Register
          </button>

          <div class="text-sm text-gray-500 block m-auto my-8">
            Already have an account?
            <Link :href="route('auth.login-page')" class="text-blue-400 font-semibold">
              Log in
            </Link>
          </div>

          <p v-if="error" class="text-red-400 text-sm text-center mb-8">{{ error }}</p>
        </form>
      </main>
    </Blank>
  </div>
</template>

<script>
import Blank from '../Layouts/Blank.vue';
import InputError from '../Components/InputError.vue';
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
      form: useForm({
        username: null,
        email: null,
        password: null,
        password_confirmation: null,
      }),
    };
  },
};
</script>
