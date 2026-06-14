import ui from "@nuxt/ui/vite";
import tailwindcss from "@tailwindcss/vite";
import vue from "@vitejs/plugin-vue";
import fs from "fs";
import laravel from "laravel-vite-plugin";
import { defineConfig, loadEnv, type UserConfig } from "vite";
import manifestSRI from "vite-plugin-manifest-sri";
import { watch } from "vite-plugin-watch";
import inertia from "@inertiajs/vite";

export default defineConfig(({ command, mode }) => {
    const devServer: UserConfig = {};
    const isDevBuild = command === "serve";
    const env = loadEnv(mode, process.cwd(), "");

    if (isDevBuild && env.VITE_CI !== "true") {
        devServer["server"] = {
            host: "lanlist.dev",
            https: {
                key: fs.readFileSync(
                    "./caddy/data/caddy/certificates/local/lanlist.dev/lanlist.dev.key",
                ),
                cert: fs.readFileSync(
                    "./caddy/data/caddy/certificates/local/lanlist.dev/lanlist.dev.crt",
                ),
            },
        };
    }

    return {
        ...devServer,
        optimizeDeps: {
            include: [
                "@nuxt/ui > prosemirror-state",
                "@nuxt/ui > prosemirror-transform",
                "@nuxt/ui > prosemirror-model",
                "@nuxt/ui > prosemirror-view",
                "@nuxt/ui > prosemirror-gapcursor",
            ],
        },
        build: {
            sourcemap: "hidden",
        },
        plugins: [
            laravel({
                input: ["resources/js/app.ts"],
                ssr: "resources/js/ssr.ts",
                refresh: ["resources/css/**", "resources/js/**", "routes/**"],
            }),
            inertia(),
            tailwindcss(),
            vue({
                template: {
                    transformAssetUrls: {
                        base: null,
                        includeAbsolute: false,
                    },
                },
            }),
            ui({
                inertia: true,
                autoImport: {
                    eslintrc: {
                        enabled: true,
                    },
                    vueTemplate: true,
                    dirs: [
                        "resources/js/composables",
                        "resources/js/constants",
                    ],
                    dts: "resources/js/types/auto-imports.d.ts",
                    imports: [
                        "vue",
                        "@vueuse/core",
                        { lararail: ["route", "current"] },
                        {
                            "@inertiajs/vue3": [
                                "router",
                                "useForm",
                                "usePage",
                                "useRemember",
                            ],
                        },
                    ],
                },
                components: {
                    dirs: ["resources/js/components"],
                    dts: "resources/js/types/auto-components.d.ts",
                    deep: true,
                    directoryAsNamespace: true,
                    resolvers: [
                        (name: string) => {
                            const components: {
                                [k: string]: { component: string; lib: string };
                            } = {
                                InertiaLink: {
                                    component: "Link",
                                    lib: "@inertiajs/vue3",
                                },
                                InertiaHead: {
                                    component: "Head",
                                    lib: "@inertiajs/vue3",
                                },
                            };

                            if (name in components) {
                                return {
                                    name: components[name]?.component,
                                    from: components[name]?.lib,
                                };
                            }
                        },
                    ],
                },
                ui: {
                    colors: {
                        primary: "blurple",
                        secondary: "emerald",
                        neutral: "discordGray",
                        success: "green",
                        info: "sky",
                        warning: "amber",
                        error: "red",
                    },
                    button: {
                        slots: {
                            base: "justify-center",
                        },
                        defaultVariants: {
                            variant: "solid",
                            size: "md",
                        },
                    },
                    card: {
                        defaultVariants: {
                            variant: "subtle",
                        },
                    },
                    modal: {
                        slots: {
                            overlay: "z-40",
                            content: "z-40 sm:m-4 rounded-lg",
                            close: "w-auto",
                        },
                    },
                    input: {
                        slots: {
                            root: "w-full",
                        },
                    },
                    inputMenu: {
                        slots: {
                            base: "w-full",
                            content: "min-w-fit",
                        },
                    },
                    pinInput: {
                        slots: {
                            root: "relative inline-flex items-center gap-1.5 w-full justify-center",
                        },
                    },
                    select: {
                        slots: {
                            base: "w-full",
                        },
                    },
                    selectMenu: {
                        slots: {
                            base: "w-full",
                        },
                    },
                    slideover: {
                        slots: {
                            overlay: "z-40",
                            content: "z-40 sm:m-4 rounded-lg",
                            close: "w-auto",
                        },
                    },
                    textarea: {
                        slots: {
                            root: "w-full",
                        },
                    },
                },
            }),
            manifestSRI(),
            watch({
                pattern: "routes/**/*.php",
                command:
                    "./vendor/bin/sail artisan app:generate-lararail-routes",
                onInit: isDevBuild,
            }),
        ],
        ssr: {
            noExternal: ["@inertiajs/vue3/server", "lodash"],
        },
    };
});
