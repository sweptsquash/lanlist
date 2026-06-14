import type { RouterGlobal } from 'lararail'
import '@inertiajs/core'
import type Echo from 'laravel-echo'
import type Pusher from 'pusher-js'
import 'vite/client'
import 'vue'

declare global {
    interface Window {
        Pusher: Pusher
        Echo: Echo
    }
}

// Extend ImportMeta interface for Vite...
declare module 'vite/client' {
    interface ImportMetaEnv {
        readonly VITE_APP_NAME: string
        [key: string]: string | boolean | undefined
    }

    interface ImportMeta {
        readonly env: ImportMetaEnv
        readonly glob: <T>(pattern: string) => Record<string, () => Promise<T>>
    }
}

declare module '@inertiajs/core' {
    export interface InertiaConfig {
        sharedPageProps: {
            name: string
            location: {
                url: string
                name: string | null
            }
            isWebpSupported: boolean
            isImpersonating: boolean
        }
        flashDataType: {
            success?: string
            error?: string
            info?: string
            warning?: string
            event?: { uuid: string; type: string }
            toast?: {
                type: 'success' | 'error' | 'info' | 'warning'
                message: string
                actions?: {
                    text: string
                    route: keyof RouterGlobal['routes']
                    parameters?: Record<string, string | number>
                }[]
            }
        }
        errorValueType: string
    }
}

declare module 'vue' {
    interface ComponentCustomProperties {
        $inertia: typeof Router
        $page: Page
        $headManager: ReturnType<typeof createHeadManager>
    }
}
