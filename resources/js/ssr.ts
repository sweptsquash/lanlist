import Layout from '@/Layouts/index.vue'
import routes from '@/routes/routes.json'
import { createInertiaApp } from '@inertiajs/vue3'
import createServer from '@inertiajs/vue3/server'
import { renderToString } from '@vue/server-renderer'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { trail } from 'momentum-trail'
import { createSSRApp, DefineComponent, h } from 'vue'

createServer((page) =>
    createInertiaApp({
        page,
        render: renderToString,
        resolve: (name: string) =>
            resolvePageComponent(
                `./Pages/${name}.vue`,
                import.meta.glob<DefineComponent>('./Pages/**/*.vue'),
            ).then((module) => {
                const page = module.default

                page.layout = page.layout || Layout

                return page
            }) as Promise<DefineComponent>,
        setup({ App, props, plugin }) {
            const app = createSSRApp({
                render: () => h(App, props),
            })
                .use(plugin)
                .use(trail, { routes, absolute: true })

            return app
        },
    }),
)
