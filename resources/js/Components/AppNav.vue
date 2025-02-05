<script lang="ts" setup>
import lanListLogoWhite from '@/../images/lanlist-white.png'
import lanListLogo from '@/../images/lanlist.png'
import { Dialog, DialogPanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import {
  Bars3Icon,
  BuildingOfficeIcon,
  ListBulletIcon,
  MapPinIcon,
  XMarkIcon,
} from '@heroicons/vue/24/outline'
import type { Method } from '@inertiajs/core'
import type { RouterGlobal } from 'momentum-trail/dist/types/router'
import type { FunctionalComponent } from 'vue'

const data = reactive<{
  isMenuOpen: boolean
  navigation: {
    name: string
    route: keyof RouterGlobal['routes'] | keyof RouterGlobal['wildcards'] | null
    href: string
    icon?: FunctionalComponent
    active: boolean
  }[]
  userNavigation: {
    name: string
    display: boolean
    method: Method
    route: keyof RouterGlobal['routes'] | keyof RouterGlobal['wildcards'] | null
    href: string
    current: boolean
  }[]
}>({
  isMenuOpen: false,
  navigation: [
    { name: 'Map', href: route('home'), route: 'home', icon: MapPinIcon, active: false },
    {
      name: 'List',
      href: route('events.index'),
      route: 'events.*',
      icon: ListBulletIcon,
      active: false,
    },
    {
      name: 'Organisers',
      href: route('organisers.index'),
      route: 'organisers.*',
      icon: BuildingOfficeIcon,
      active: false,
    },
    {
      name: 'Venues',
      href: route('venues.index'),
      route: 'venues.*',
      icon: MapPinIcon,
      active: false,
    },
  ],
  userNavigation: [
    {
      name: 'Settings',
      display: true,
      method: 'get',
      route: null,
      href: '#',
      current: false,
    },
    {
      name: 'Admin Dashboard',
      display: false,
      method: 'get',
      route: null,
      href: '#',
      current: false,
    },
    {
      name: 'Stop Impersonating',
      display: false,
      method: 'delete',
      route: null,
      href: '#',
      current: false,
    },
    {
      name: 'Sign out',
      display: true,
      method: 'post',
      route: null,
      href: route('logout'),
      current: false,
    },
  ],
})

const adminDashboardItem = data.userNavigation.find((item) => item.name === 'Admin Dashboard')
const adminImpersonatingItem = data.userNavigation.find(
  (item) => item.name === 'Stop Impersonating',
)

onBeforeMount(() => {
  router.on('navigate', () => {
    const currentActive = data.navigation.findIndex((item) => item.active === true)
    const newActive = data.navigation.findIndex((item) => {
      if (item.route === null) {
        return false
      }
      return current(item.route)
    })

    if (newActive === -1 && currentActive !== -1) {
      data.navigation[currentActive].active = false
    }

    if (newActive > -1 && currentActive !== newActive) {
      if (currentActive !== -1) {
        data.navigation[currentActive].active = false
      }

      data.navigation[newActive].active = true
    }

    const currentUserNavActive = data.userNavigation.findIndex((item) => item.current === true)
    const newUserNavActive = data.userNavigation.findIndex((item) => {
      if (item.route === null) {
        return false
      }

      return current(item.route)
    })

    if (newUserNavActive === -1 && currentUserNavActive !== -1) {
      data.userNavigation[currentUserNavActive].current = false
    }

    if (newUserNavActive > -1 && currentUserNavActive !== newUserNavActive) {
      if (currentUserNavActive !== -1) {
        data.userNavigation[currentUserNavActive].current = false
      }

      data.userNavigation[newUserNavActive].current = true
    }

    if (adminDashboardItem) {
      adminDashboardItem.display = useIsAdmin.value
    }

    if (adminImpersonatingItem) {
      adminImpersonatingItem.display = useIsImpersonating.value
    }
  })

  router.on('finish', () => {
    if (adminDashboardItem) {
      adminDashboardItem.display = useIsAdmin.value
    }

    if (adminImpersonatingItem) {
      adminImpersonatingItem.display = useIsImpersonating.value
    }
  })
})
</script>

<template>
  <header class="bg-white dark:bg-gray-800">
    <nav
      class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8"
      aria-label="Global"
    >
      <button
        type="button"
        class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700 lg:hidden dark:text-gray-300"
        @click="data.isMenuOpen = true"
      >
        <span class="sr-only">Open main menu</span>
        <Bars3Icon class="size-6" aria-hidden="true" />
      </button>
      <div class="flex lg:flex-1">
        <InertiaLink :href="route('home')" class="-m-1.5 p-1.5">
          <span class="sr-only">LANList</span>
          <img class="hidden h-8 w-auto dark:block" :src="lanListLogoWhite" alt="" />
          <img class="block h-8 w-auto dark:hidden" :src="lanListLogo" alt="" />
        </InertiaLink>
      </div>
      <div class="flex gap-x-4 lg:hidden">
        <ThemeToggle />
        <Menu v-if="useUser" as="div" class="relative ml-3">
          <div>
            <MenuButton
              class="relative flex max-w-xs items-center rounded-full bg-white text-sm focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none"
            >
              <span class="absolute -inset-1.5" />
              <span class="sr-only">Open user menu</span>
              <img class="size-8 rounded-full" :src="useUser?.profile_photo" alt="" />
            </MenuButton>
          </div>
          <transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95"
          >
            <MenuItems
              class="absolute top-12 right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 ring-1 shadow-lg ring-black/5 focus:outline-none dark:bg-gray-800"
            >
              <template v-for="item in data.userNavigation">
                <MenuItem v-if="item.display" :key="item.name" v-slot="{ active }">
                  <InertiaLink
                    :as="['delete', 'post'].includes(item.method) ? 'button' : 'a'"
                    :method="item.method"
                    :href="item.href"
                    :class="[
                      active ? 'bg-gray-50 dark:bg-gray-700' : '',
                      'block w-full cursor-pointer px-4 py-2 text-left text-sm text-gray-500 dark:text-gray-100',
                    ]"
                    role="menuitem"
                    tabindex="-1"
                  >
                    {{ item.name }}
                  </InertiaLink>
                </MenuItem>
              </template>
            </MenuItems>
          </transition>
        </Menu>
      </div>
      <div class="hidden lg:flex lg:gap-x-6">
        <InertiaLink
          v-for="item in data.navigation"
          :key="item.name"
          :href="item.href"
          :class="[
            'flex items-center gap-x-2 rounded-lg px-3 py-2 text-sm/6 font-semibold',
            {
              'text-gray-700 hover:bg-gray-50 hover:text-black dark:text-white/75 dark:hover:bg-gray-700 dark:hover:text-white':
                !item.active,
              'bg-gray-50 text-black dark:bg-gray-700 dark:text-white': item.active,
            },
          ]"
        >
          <component :is="item.icon" class="size-6" aria-hidden="true" />
          {{ item.name }}
        </InertiaLink>
      </div>
      <div class="hidden items-center gap-x-4 lg:flex lg:flex-1 lg:justify-end">
        <ThemeToggle />
        <InertiaLink
          v-if="!useUser"
          :href="route('auth.login')"
          class="text-sm/6 font-semibold text-gray-900 dark:text-white/75 dark:hover:text-white"
        >
          Log in
          <span aria-hidden="true">&rarr;</span>
        </InertiaLink>
        <Menu v-else as="div" class="relative ml-3">
          <div>
            <MenuButton
              class="relative flex max-w-xs items-center rounded-full bg-white text-sm focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none"
            >
              <span class="absolute -inset-1.5" />
              <span class="sr-only">Open user menu</span>
              <img class="size-8 rounded-full" :src="useUser?.profile_photo" alt="" />
            </MenuButton>
          </div>
          <transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95"
          >
            <MenuItems
              class="absolute top-13 right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 ring-1 shadow-lg ring-black/5 focus:outline-none dark:bg-gray-800"
            >
              <template v-for="item in data.userNavigation">
                <MenuItem v-if="item.display" :key="item.name" v-slot="{ active }">
                  <InertiaLink
                    :as="['delete', 'post'].includes(item.method) ? 'button' : 'a'"
                    :method="item.method"
                    :href="item.href"
                    :class="[
                      active ? 'bg-gray-50 dark:bg-gray-700' : '',
                      'block w-full cursor-pointer px-4 py-2 text-left text-sm text-gray-500 dark:text-gray-100',
                    ]"
                    role="menuitem"
                    tabindex="-1"
                  >
                    {{ item.name }}
                  </InertiaLink>
                </MenuItem>
              </template>
            </MenuItems>
          </transition>
        </Menu>
      </div>
    </nav>
    <Dialog class="lg:hidden" :open="data.isMenuOpen" @close="data.isMenuOpen = false">
      <div class="fixed inset-0 z-10" />
      <DialogPanel
        class="fixed inset-y-0 right-0 z-10 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10 dark:bg-gray-900 dark:sm:ring-white/10"
      >
        <div class="flex items-center justify-between">
          <button
            type="button"
            class="-m-2.5 rounded-md p-2.5 text-gray-700 dark:text-gray-300"
            @click="data.isMenuOpen = false"
          >
            <span class="sr-only">Close menu</span>
            <XMarkIcon class="size-6" aria-hidden="true" />
          </button>
          <InertiaLink :href="route('home')" class="-m-1.5 p-1.5">
            <span class="sr-only">LANList</span>
            <img class="hidden h-8 w-auto dark:block" :src="lanListLogoWhite" alt="" />
            <img class="block h-8 w-auto dark:hidden" :src="lanListLogo" alt="" />
          </InertiaLink>
          <div class="flex gap-x-4 lg:hidden">
            <ThemeToggle />
          </div>
        </div>
        <div class="mt-6 flow-root">
          <div class="-my-6 divide-y divide-gray-500/10 dark:divide-white/15">
            <div class="space-y-2 py-6">
              <InertiaLink
                v-for="item in data.navigation"
                :key="item.name"
                :href="item.href"
                :class="[
                  '-mx-3 flex items-center gap-x-2 rounded-lg px-3 py-2 text-base/7 font-semibold',
                  {
                    'text-gray-700 hover:bg-gray-50 dark:text-white dark:hover:bg-gray-800':
                      !item.active,
                    'bg-gray-50 text-black dark:bg-gray-800 dark:text-white': item.active,
                  },
                ]"
              >
                <component :is="item.icon" class="size-6" aria-hidden="true" />
                {{ item.name }}
              </InertiaLink>
            </div>
            <div v-if="!useUser" class="py-6">
              <InertiaLink
                :href="route('auth.login')"
                class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-gray-900 hover:bg-gray-50 dark:text-white dark:hover:bg-gray-800"
              >
                Log in
              </InertiaLink>
            </div>
          </div>
        </div>
      </DialogPanel>
    </Dialog>
  </header>
</template>
