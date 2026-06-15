import { createInertiaApp } from '@inertiajs/vue3'
import createServer from '@inertiajs/vue3/server'
import ui from '@nuxt/ui/vue-plugin'
import { lararail } from 'lararail'
import { createSSRApp, DefineComponent, h } from 'vue'
import { renderToString } from 'vue/server-renderer'
import Layout from '@/layouts/Default.vue'
import routes from '@/routes/routes.json'

const appName = import.meta.env.VITE_APP_NAME || 'LanList'

createServer(
    (page) =>
        createInertiaApp({
            page,
            pages: {
                path: './pages',
                lazy: true,
            },
            render: renderToString,
            title: (title) => (title ? `${title} | ${appName}` : appName),
            layout: () => Layout,
            resolve: (name) => {
                const pages = import.meta.glob<DefineComponent>('./pages/**/*.vue')
                return pages[`./pages/${name}.vue`]()
            },
            setup: ({ App, props, plugin }) =>
                createSSRApp({ render: () => h(App, props) })
                    .use(lararail, { routes, absolute: true })
                    .use(plugin)
                    .use(ui),
        }),
    { cluster: true },
)
