import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'

createInertiaApp({
    progress: {
        delay: 0,
        color: '#3b82f6',
        includeCSS: true,
    },
    resolve: name => {
        const pages = import.meta.glob('../views/pages/**/*.vue', { eager: true })
        return pages[`../views/pages/${name}.vue`]
        // const pages = import.meta.glob('../views/pages/**/*.vue')
        // return pages[`../views/pages/${name}.vue`]()
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
        .use(plugin)
        .mount(el)
    },
})