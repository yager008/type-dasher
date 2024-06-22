import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path'; // Add this line to import the path module

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/sass/app.scss',
            ],
            refresh: true,
        }),
    ],

    // server: {
    //     host: '0.0.0.0',
    //     port: 5173,
    //     cors: true,
    //     hmr: {
    //         host: 'localhost',
    //         port: 5173,
    //     },
    // },

    server: {
        host: '0.0.0.0',
        hmr: {
            clientPort: 5173,
            host: 'localhost',
        },
        watch: {
            usePolling: true
        }
    },

    build: {
        outDir: 'public/build',
        // rollupOptions: {
        //     input: {
        //         app: 'resources/js/app.js',
        //         app_css: 'resources/css/app.css',
        //         app_scss: 'resources/sass/app.scss',
        //     },
        // },
        manifest: true,
    },
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
        },
    }

});
