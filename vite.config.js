import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import { sveltekit } from '@sveltejs/kit/vite'
import { sveltePhosphorOptimize } from "phosphor-svelte/vite"

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        sveltekit(),
        sveltePhosphorOptimize(),
    ],
    server: {
        fs: {
            allow: [".."],
        },
        proxy: {
            "/api": {
                target: "http://localhost/",
                changeOrigin: true,
            },
            "/sanctum": {
                target: "http://localhost/",
                changeOrigin: true,
            }
        }
    },
    ssr: {
        noExternal: ['@googlemaps/js-api-loader']
    }
})
