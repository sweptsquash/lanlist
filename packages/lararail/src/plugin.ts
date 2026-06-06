import { App } from 'vue'

import store from './store'

export interface LaraRailPluginOptions {
    routes?: any
    url?: string
    absolute: boolean
}

export const lararail = (app: App, options?: LaraRailPluginOptions) => {
    if (options?.routes) {
        store.setRoutes(options.routes)
    }

    if (options?.url) {
        store.setLocation(options.routes!.url, options.url)
    }

    if (options?.absolute !== undefined) {
        store.setAbsolute(options.absolute)
    }
}
