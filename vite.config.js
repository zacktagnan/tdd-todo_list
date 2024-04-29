import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    // -> Esto no hace que varíe la carga ... Y sigue habiendo clases Tailwind sin cargar
    // server: {
    //     hmr: {
    //         host: "localhost",
    //     },
    //     watch: {
    //         usePolling: true
    //     },
    // },
});
