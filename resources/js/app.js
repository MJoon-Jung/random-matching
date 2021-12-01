require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import InfiniteLoading from "v3-infinite-loading";
import "v3-infinite-loading/lib/style.css"

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'YJU_Community';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .mixin({ methods: { route } })
            .component("infinite-loading", InfiniteLoading)
            .mount(el);
    },
});


InertiaProgress.init({
    color: '#4B5563',
    showSpinner: true,
});
