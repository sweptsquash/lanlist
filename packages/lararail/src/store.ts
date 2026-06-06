import { RouterGlobal } from './router'

let routes: RouterGlobal
let location: URL | undefined
let absolute = true

export default {
    setRoutes: (payload: RouterGlobal) => (routes = payload),

    getRoutes: () =>
        // @ts-expect-error Property 'lararail' does not exist on type 'Window & typeof globalThis'
        typeof window !== 'undefined' && window.lararail // @ts-expect-error Property 'lararail' does not exist on type 'Window & typeof globalThis'
            ? window.lararail
            : routes,

    setLocation: (url: string, path?: string) => {
        location = path ? new URL(path, url) : undefined
    },

    getLocation: () => location,

    getAbsolute: () => absolute,

    setAbsolute: (value: boolean) => (absolute = value),
}
