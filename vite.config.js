import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
  resolve: {
    alias: {
      ziggy: "/vendor/tightenco/ziggy/src/js",
      "ziggy-vue": "/vendor/tightenco/ziggy/src/js/vue",
    },
  },
  plugins: [
    vue(),
    laravel({
      input: ["resources/css/app.css", "resources/js/app.js"],
      refresh: true,
    }),
  ],
});
