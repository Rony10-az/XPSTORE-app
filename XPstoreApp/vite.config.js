import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // ===== CSS =====
                'resources/css/admin/Game/show.css',
                'resources/css/cart/cart.css',
                'resources/css/store/Profile.css',
                'resources/css/store/show.css',

                'resources/css/User/dashboard.css',
                'resources/css/admin.css',
                'resources/css/create.css',
                'resources/css/edit.css',
                'resources/css/home.css',
                'resources/css/login.css',
                'resources/css/register.css',

                // ===== JS =====
                'resources/js/cart/cart.js',
                'resources/js/store/profile.js',
                'resources/js/admin.js',
                'resources/js/bootstrap.js',
                'resources/js/dashboard.js',
                'resources/js/home.js',
                'resources/js/login.js',
                'resources/js/register.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
