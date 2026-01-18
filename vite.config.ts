// import { wayfinder } from '@laravel/vite-plugin-wayfinder';
// import tailwindcss from '@tailwindcss/vite';
// import vue from '@vitejs/plugin-vue';
// import fs from 'fs';
// import laravel from 'laravel-vite-plugin';
// import { defineConfig } from 'vite';

// export default defineConfig(({ command }) => {
//     const isDev = command === 'serve';
//     plugins: [
//         laravel({
//             input: ['resources/js/app.ts'],
//             ssr: 'resources/js/ssr.ts',
//             refresh: true,
//         }),
//         tailwindcss(),
//         vue({
//             template: {
//                 transformAssetUrls: {
//                     base: null,
//                     includeAbsolute: false,
//                 },
//             },
//         }),
//         wayfinder({
//             formVariants: true,
//         }),
//     ],
//     server: isDev
//         ? {
//               host: 'docuvault.test',
//               port: 5173,

//               https: {
//                   key: fs.readFileSync('C:/Users/ShihabPeace/.config/herd/certificates/docuvault.test.key'),
//                   cert: fs.readFileSync('C:/Users/ShihabPeace/.config/herd/certificates/docuvault.test.crt'),
//               },

//               hmr: {
//                   protocol: 'wss',
//                   host: 'docuvault.test',
//                   port: 5173,
//               },
//           }
//         : undefined,
// });
import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import fs from 'fs';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';
import { resolve } from 'path';

export default defineConfig(({ command }) => {
    const isDev = command === 'serve';

    return {
        plugins: [
            laravel({
                input: ['resources/js/app.ts'],
                ssr: 'resources/js/ssr.ts',
                refresh: true,
            }),
            tailwindcss(),
            vue({
                template: {
                    transformAssetUrls: {
                        base: null,
                        includeAbsolute: false,
                    },
                },
            }),
            wayfinder({
                formVariants: true,
            }),
        ],

        server: isDev
            ? {
                  host: 'docuvault.test',
                  port: 5173,

                  hmr: {
                      protocol: 'wss',
                      host: 'docuvault.test',
                      port: 5173,
                  },
              }
            : undefined,
    };
});
