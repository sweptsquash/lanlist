import { defineConfig } from 'oxfmt'

export default defineConfig({
    semi: false,
    singleQuote: true,
    singleAttributePerLine: false,
    htmlWhitespaceSensitivity: 'ignore',
    printWidth: 100,
    tabWidth: 4,
    trailingComma: 'all',
    sortImports: {
        newlinesBetween: false,
        groups: [
            'type-import',
            ['value-builtin', 'value-external'],
            'type-internal',
            'value-internal',
            ['type-parent', 'type-sibling', 'type-index'],
            ['value-parent', 'value-sibling', 'value-index'],
            'unknown',
        ],
    },
    sortPackageJson: {
        sortScripts: true,
    },
    sortTailwindcss: {
        stylesheet: 'resources/css/app.css',
    },
    ignorePatterns: [
        '.github/**/*',
        'resources/js/components/ui/*',
        'resources/views/mail/*',
        'resources/js/routes/routes.json',
        'resources/js/types/auto-components.d.ts',
        'resources/js/types/auto-imports.d.ts',
        'resources/js/types/routes.d.ts',
    ],
})
