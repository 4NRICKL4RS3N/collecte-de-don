import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import postcss from "postcss";
import autoprefixer from 'autoprefixer';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/scss/app.scss',
                    'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
});
