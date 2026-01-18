import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
// import * as ZiggyJS from 'ziggy-js'; // route() function
import { ZiggyVue } from 'ziggy-js'; // route() function
import '../css/app.css';
import MainLayout from './layout/MainLayout.vue';
import Ziggy from './ziggy'; // your generated JS module
import axios from 'axios';
import { configureEcho } from '@laravel/echo-vue';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

configureEcho({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) => {
        const page = resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue'));
        page.then((module) => {
            module.default.layout = module.default.layout || MainLayout;
        });
        return page;
    },
    setup({ el, App, props, plugin }) {
        // CSRF token setup
        // Configure Axios to send CSRF token and cookies
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (token) {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
        }
        axios.defaults.withCredentials = true;

        const vueApp = createApp({ render: () => h(App, props) });

        // Make route() globally available in Vue templates

        vueApp.use(plugin).use(ZiggyVue, Ziggy).mount(el);
    },
    progress: { color: '#4B5563' },
});
