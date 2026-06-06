import { defineConfig } from 'oxlint'

export default defineConfig({
    plugins: ['typescript', 'node'],
    categories: {},
    env: {
        builtin: true,
    },
    rules: {
        "@typescript-eslint/no-explicit-any": "off",
        "@typescript-eslint/no-var-requires": "off",
    },
})
