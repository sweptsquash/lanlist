<script lang="ts" setup>
import { GitHubIcon } from 'vue3-simple-icons'

const navigation = {
  main: [
    { name: 'Link to us', href: route('linkus') },
    { name: 'Contact', href: route('contact.index') },
    { name: 'Cookies', href: '#' },
    { name: 'Useful related sites', href: '#' },
    { name: 'Licensing', href: route('licensing') },
    { name: 'Sitemap', href: '#' },
  ],
  social: [{ name: 'GitHub', icon: GitHubIcon, href: 'https://github.com/jamesread/lanlist' }],
}

const year = computed(() => new Date().getFullYear())
</script>

<template>
  <footer>
    <div class="mx-auto max-w-7xl overflow-hidden px-6 py-20 sm:py-24 lg:px-8">
      <nav
        class="-mb-6 flex flex-wrap justify-center gap-x-12 gap-y-3 text-sm/6"
        aria-label="Footer"
      >
        <a
          v-for="item in navigation.main"
          :key="item.name"
          :href="item.href"
          class="text-gray-600 hover:text-gray-900 dark:text-white/75 dark:hover:text-white"
        >
          {{ item.name }}
        </a>
      </nav>
      <div class="mt-16 flex justify-center gap-x-10">
        <a
          v-for="item in navigation.social"
          :key="item.name"
          :href="item.href"
          class="text-gray-600 hover:text-gray-800 dark:text-white/75 dark:hover:text-white"
          target="_blank"
          rel="noopener noreferrer"
        >
          <span class="sr-only">{{ item.name }}</span>
          <component :is="item.icon" class="size-6" aria-hidden="true" />
        </a>
      </div>
      <p class="mt-10 text-center text-sm/6 text-gray-600 dark:text-white">
        &copy; {{ year }} LANList. All rights reserved.
      </p>
    </div>
  </footer>
</template>
