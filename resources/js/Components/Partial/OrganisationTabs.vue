<script lang="ts" setup>
const tabs = computed<{ name: string; href: string; current: boolean; disabled?: boolean }[]>(
  () => {
    return [
      {
        name: 'Organisation Details',
        href: route('account.organisation.index'),
        current: current('account.organisation.*'),
      },
      {
        name: 'Organisation Members',
        href: '#',
        current: false,
      },
      {
        name: 'Organisation Settings',
        href: '#',
        current: false,
      },
    ]
  },
)

function changeTab(eventTarget: EventTarget | null) {
  if (!eventTarget) return

  router.visit((eventTarget as HTMLSelectElement).value)
}
</script>

<template>
  <div class="mt-4 mb-5">
    <div class="sm:hidden">
      <label for="tabs" class="sr-only">Select a tab</label>
      <select id="tabs" name="tabs" class="form-input" @change="(e) => changeTab(e.target)">
        <option v-for="tab in tabs" :key="tab.name" :selected="tab.current" :value="tab.href">
          {{ tab.name }}
        </option>
      </select>
    </div>
    <div class="hidden sm:block">
      <nav
        class="relative z-0 flex divide-x divide-gray-200 rounded-lg shadow-sm dark:divide-gray-400"
        aria-label="Tabs"
      >
        <InertiaLink
          v-for="(tab, tabIdx) in tabs"
          :key="tab.name"
          :href="tab.href"
          :class="[
            'group relative min-w-0 flex-1 overflow-hidden px-4 py-4 text-center text-sm font-medium hover:bg-gray-50 focus:z-10 dark:hover:bg-gray-800 dark:hover:text-white',
            {
              'rounded-l-lg': tabIdx === 0,
              'rounded-r-lg': tabIdx === tabs.length - 1,
              'bg-gray-50 text-gray-900 dark:bg-gray-800 dark:text-white': tab.current,
              'bg-white text-gray-500 hover:text-gray-700 dark:bg-gray-700 dark:text-white/75':
                !tab.current,
              'cursor-not-allowed opacity-50': tab.disabled,
            },
          ]"
          :aria-current="tab.current ? 'page' : undefined"
        >
          <span>{{ tab.name }}</span>
          <span
            aria-hidden="true"
            :class="[
              'absolute inset-x-0 bottom-0 h-0.5',
              {
                'bg-indigo-500 dark:bg-gray-400': tab.current,
                'bg-transparent': !tab.current,
              },
            ]"
          />
        </InertiaLink>
      </nav>
    </div>
  </div>
</template>
