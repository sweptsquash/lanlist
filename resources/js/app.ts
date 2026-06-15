import 'vue-sonner/style.css'
import '../css/app.css'
import type { DefineComponent } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { configureEcho } from '@laravel/echo-vue'
import ui from '@nuxt/ui/vue-plugin'
import { lararail } from 'lararail'
import { createSSRApp, h } from 'vue'
import { initializeTheme } from '@/composables/useAppearance'
import Layout from '@/layouts/Default.vue'
import routes from '@/routes/routes.json'

configureEcho({
    broadcaster: 'reverb',
})

const appName = import.meta.env.VITE_APP_NAME || 'LanList'

await createInertiaApp({
    progress: {
        color: '#4B5563',
    },
    pages: {
        path: './pages',
        lazy: true,
    },
    title: (title) => (title ? `${title} | ${appName}` : appName),
    layout: () => Layout,
    resolve: (name) => {
        const pages = import.meta.glob<DefineComponent>('./pages/**/*.vue')
        return pages[`./pages/${name}.vue`]()
    },
    setup({ el, App, props, plugin }) {
        createSSRApp({ render: () => h(App, props) })
            .use(plugin)
            .use(lararail, { routes, absolute: true })
            .use(ui)
            .mount(el)
    },
})

// This will set light / dark mode on page load...
initializeTheme()
