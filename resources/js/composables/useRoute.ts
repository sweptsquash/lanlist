import type { RouterGlobal } from 'lararail'

declare type RouteName = keyof RouterGlobal['routes']
declare type Routes = RouterGlobal['routes']

export declare type RouteParameters<T extends RouteName> =
    | (Routes[T] extends {
        bindings: any
    }
    ? Partial<Record<keyof Routes[T]['bindings'], any>> & Record<string, any>
    : {})
    | string
    | number

export function useRoute(
    name: keyof RouterGlobal['routes'],
    params: RouteParameters<typeof name> = {},
): string {
    return route(name, params)
}

export function useCurrentRoute(
    name: keyof RouterGlobal['routes'] | keyof RouterGlobal['wildcards'],
    params?: typeof name extends RouteName ? RouteParameters<typeof name> : {},
): boolean {
    return route().current(name, params)
}
