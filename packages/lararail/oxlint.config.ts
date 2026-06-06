import { defineConfig } from 'oxlint'

export default defineConfig({
    plugins: ['typescript', 'node'],
    categories: {},
    env: {
        builtin: true,
    },
    globals: {
        lararail: 'readonly',
    },
    rules: {
        "@typescript-eslint/no-explicit-any": "off",
        "@typescript-eslint/no-var-requires": "off",
        "@typescript-eslint/no-empty-interface": "off",
        "@typescript-eslint/ban-types": "off",
        "@typescript-eslint/no-non-null-assertion": "off",
        "@typescript-eslint/ban-ts-comment": "off",
        "@typescript-eslint/no-wrapper-object-types": "off",
    },
})
