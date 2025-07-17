import { defineConfig } from 'astro/config';
import svelte from '@astrojs/svelte';
import tailwind from '@astrojs/tailwind';

export default defineConfig({
  integrations: [
    svelte(),
    tailwind(),
  ],
  output: 'server',
  site: 'https://kfz-rechner.de',
  compressHTML: true,
  build: {
    inlineStylesheets: 'auto'
  },
  vite: {
    css: {
      preprocessorOptions: {
        scss: {
          // additionalData: `@import "src/styles/variables.scss";`
        }
      }
    }
  }
});
