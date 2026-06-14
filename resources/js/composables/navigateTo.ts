import type { RequestPayload, UrlMethodPair, VisitOptions } from '@inertiajs/core'
import { router } from '@inertiajs/vue3'

export function navigateTo(
    url: string | URL | UrlMethodPair,
    options: VisitOptions<RequestPayload> = {},
) {
    router.visit(url, options)
}
