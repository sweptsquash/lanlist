// @ts-check

import eslint from '@eslint/js'
import eslintPluginPrettierRecommended from 'eslint-plugin-prettier/recommended'
import pluginVue from 'eslint-plugin-vue'
import tseslint from 'typescript-eslint'
import autoImports from './.eslintrc-auto-import.json' with { type: 'json' }

export default tseslint.config(
    // JS
    eslint.configs.recommended,
    {
        rules: {
            'no-unused-vars': 'off',
            'no-undef': 'off',
        },
    },

    // TS
    ...tseslint.configs.recommended,
    {
        rules: {
            '@typescript-eslint/no-unused-vars': 'warn',
            '@typescript-eslint/no-explicit-any': 'warn',
        },
    },

    // Vue
    ...pluginVue.configs['flat/recommended'],
    {
        files: ['*.vue', '**/*.vue'],
        languageOptions: {
            parserOptions: {
                parser: tseslint.parser,
            },
        },
    },
    {
        ignores: [
            'app/**/*',
            'bootstrap/**/*',
            'config/**/*',
            'database/**/*',
            'node_modules/**/*',
            'public/**/*',
            'routes/**/*',
            'storage/**/*',
            'tests/**/*',
            'vendor/**/*',
            'package-lock.json',
            '*.md',
            'eslint.config.mjs',
            'tailwind.config.mjs',
            'resources/js/types/routes.d.ts',
            'resources/js/types/vite-env.d.ts',
        ],
    },
    {
        languageOptions: autoImports,
        rules: {
            'vue/multi-word-component-names': 'off',
        },
    },
    {
        rules: {
            'comma-dangle': ['error', 'always-multiline'],
            'prettier/prettier': 'warn',
            'vue/component-name-in-template-casing': ['error', 'PascalCase'],
            'vue/component-tags-order': ['error', { order: ['script', 'template', 'style'] }],
            'vue/block-order': ['error', { order: ['script[setup]', 'template', 'style[scoped]'] }],
            'vue/define-macros-order': ['warn', { order: ['defineProps', 'defineEmits'] }],
            'vue/multi-word-component-names': 'off',
            'vue/no-template-target-blank': [
                'error',
                { allowReferrer: false, enforceDynamicLinks: 'always' },
            ],
            'vue/no-ref-object-reactivity-loss': 'error',
            'vue/no-unused-refs': 'warn',
            'vue/no-useless-v-bind': 'error',
            'vue/no-v-html': 'off',
            'no-undef': 'off',
            'no-unused-vars': 'off',
            'no-console': ['warn'],
        },
    },

    // Prettier
    eslintPluginPrettierRecommended,
    {
        rules: {
            'prettier/prettier': 'warn',
        },
    },
)
