import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/sass/client/app.scss',
                    'resources/js/app.js',
                    'resources/js/slide.js',
                    'resources/js/admin-app.js',
                    'resources/js/dashboard.js',
                    'resources/sass/admin/app.scss',
                    'resources/sass/admin/pages/projets.scss',
                    'resources/sass/admin/pages/temoignages.scss',
            ],
            refresh: true,
        }),
    ],
});
