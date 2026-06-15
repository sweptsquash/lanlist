<script setup lang="ts">
import { computed } from 'vue'
import type { DropdownMenuItem, NavigationMenuItem } from '@nuxt/ui'

const items = computed<NavigationMenuItem[]>(() => [
    {
        label: 'Events',
        to: '#',
    },
    {
        label: 'Map',
        to: '#',
    },
    {
        label: 'Organisers',
        to: '#',
    },
    {
        label: 'Submit Event',
        to: '#',
    }
])

const userItems = computed<DropdownMenuItem[][]>(() => [
    [
        {
            label: 'Account',
            icon: 'i-lucide-settings',
            to: '/settings'
        },
        {
            label: 'Log out',
            icon: 'i-lucide-log-out'
        }
    ]
])

const footerItems: NavigationMenuItem[] = [
    {
        label: 'Link to us!',
        to: 'https://go.nuxt.com/figma-ui',
        target: '_blank'
    },
    {
        label: 'Contact',
        to: 'https://stackblitz.com/edit/nuxt-ui',
        target: '_blank'
    },
    {
        label: 'Releases',
        to: 'https://github.com/nuxt/ui/releases',
        target: '_blank'
    }
]

const navigation = {
    solutions: [
        {name: 'Events', href: '#'},
        {name: 'Map', href: '#'},
        {name: 'Organisers', href: '#'},
        {name: 'Submit Event', href: '#'},
        {name: 'Contact', href: '#'},
    ],
    account: [
        {name: 'Profile', href: '#'},
        {name: 'Settings', href: '#'},
    ],
    legal: [
        {name: 'Terms of service', href: '#'},
        {name: 'Privacy policy', href: '#'},
        {name: 'Cookies', href: '#'},
        {name: 'License', href: '#'},
    ]
}
</script>

<template>
    <UApp>
        <AppImpersonating />

        <UHeader mode="slideover">
            <template #title>
                LanList
            </template>

            <UNavigationMenu :items="items" />

            <template #right>
                <UColorModeButton />

                <UDropdownMenu
                    :items="userItems"
                    :content="{ align: 'center', collisionPadding: 12 }"
                    :ui="{ content: 'w-(--reka-dropdown-menu-trigger-width) min-w-48' }"
                >
                    <UButton
                        icon="i-lucide-user-round"
                        color="neutral"
                        variant="ghost"
                        square
                        class="data-[state=open]:bg-elevated overflow-hidden"
                        :ui="{
                          trailingIcon: 'text-dimmed ms-auto'
                        }"
                    />
                </UDropdownMenu>
            </template>

            <template #body>
                <UNavigationMenu :items="items" orientation="vertical" class="-mx-2.5" />
            </template>
        </UHeader>

        <UContainer>
            <slot />
        </UContainer>

        <footer>
            <div class="mx-auto max-w-7xl px-6 pt-16 pb-8 sm:pt-24 lg:px-8 lg:pt-32">
                <div class="xl:grid xl:grid-cols-3 xl:gap-8">
                    <div class="space-y-8">
                        <img class="h-9 dark:hidden" src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="Company name" />
                        <img class="h-9 not-dark:hidden" src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="Company name" />
                        <p class="text-sm/6 text-balance text-gray-600 dark:text-gray-400">Find LAN tournaments anywhere in the world.</p>
                    </div>
                    <div class="mt-16 grid gap-8 xl:col-span-2 xl:mt-0">
                        <div class="md:grid md:grid-cols-4 md:gap-8">
                            <div></div>
                            <div>
                                <h3 class="text-sm/6 font-semibold text-gray-900 dark:text-white">Solutions</h3>
                                <ul role="list" class="mt-6 space-y-4">
                                    <li v-for="item in navigation.solutions" :key="item.name">
                                        <a :href="item.href" class="text-sm/6 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300">{{ item.name }}</a>
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <h3 class="text-sm/6 font-semibold text-gray-900 dark:text-white">Account</h3>
                                <ul role="list" class="mt-6 space-y-4">
                                    <li v-for="item in navigation.account" :key="item.name">
                                        <a :href="item.href" class="text-sm/6 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300">{{ item.name }}</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="mt-10 md:mt-0">
                                <h3 class="text-sm/6 font-semibold text-gray-900 dark:text-white">Legal</h3>
                                <ul role="list" class="mt-6 space-y-4">
                                    <li v-for="item in navigation.legal" :key="item.name">
                                        <a :href="item.href" class="text-sm/6 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300">{{ item.name }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-16 border-t border-gray-900/10 pt-8 sm:mt-20 lg:mt-24 dark:border-white/10">
                    <p class="text-sm/6 text-gray-600 dark:text-gray-400">&copy; {{ new Date().getFullYear() }} lanlist, The Lan Party Community. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </UApp>
</template>
