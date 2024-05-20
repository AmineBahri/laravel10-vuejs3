import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import ViteVuetifyPlugin from 'vite-plugin-vuetify';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetsUrls:{
                    base:null,
                    includeAbsolute:false,
                },
            },
        }),
        ViteVuetifyPlugin()
    ],
    resolve:{
        alias:{
            'vue':'vue/dist/vue.esm-bundler.js',
            '@':'/resources/js',
        },
    },
});
