// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
css: {
  preprocessorOptions: {
    scss: {
      includePaths: [path.resolve(__dirname, 'node_modules')]
      
    }
  }
},
  plugins: [
    laravel({
      input: [
        'resources/scss/app.scss',
        'resources/scss/bootstrap.scss',
        'resources/scss/icons.scss',
        'resources/scss/custom.scss',
        'resources/js/app.js',
      ],
      refresh: true,
    }),
  ],
   resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            // Add this alias to resolve the missing file
            'variables-dark': path.resolve(__dirname, 'resources/scss/_variables-dark.scss')
        }
    },
});
