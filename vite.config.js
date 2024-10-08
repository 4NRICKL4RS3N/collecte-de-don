import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/sass/client/app.scss',
                    'resources/js/app.js',
                    'resources/js/slide.js',
                    'resources/js/admin-app.js',
                    'resources/sass/admin/app.scss',
            ],
            refresh: true,
        }),
    ],
});
