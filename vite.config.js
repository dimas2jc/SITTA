import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from 'tailwindcss';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css', 
        'resources/js/app.js',
        'resources/js/vue/stock.js',
        'resources/js/vue/tracking.js'
      ],
      refresh: true,
    }),
    vue(),
  ],
  css: {
    postcss: {
      plugins: [tailwindcss()],
    },
  },
});
