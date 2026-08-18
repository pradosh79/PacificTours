import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/sass/admin.scss',
                'resources/js/admin.js',
            ],
            refresh: true,
        }),
    ],

    css: {
        preprocessorOptions: {
            scss: {
                /*
                 * Bootstrap 5.x still uses the legacy Sass color and import APIs
                 * that Dart Sass 1.79+ has deprecated. The warnings are noisy
                 * (~300+ lines per build) but harmless. Silence them here until
                 * Bootstrap migrates; drop these keys once you move to a
                 * version of Bootstrap that ships modern Sass syntax.
                 */
                api: 'modern-compiler',
                silenceDeprecations: [
                    'color-functions',
                    'import',
                    'global-builtin',
                    'mixed-decls',
                    'legacy-js-api',
                ],
                quietDeps: true,
            },
        },
    },

    build: {
        // Public theme and admin theme ship as separate bundles so a Figma
        // rebuild of the storefront never invalidates the admin cache.
        rollupOptions: {
            output: { manualChunks: { vendor: ['alpinejs', 'bootstrap'] } },
        },
    },
});
