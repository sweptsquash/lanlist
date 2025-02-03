<script lang="ts" setup>
withDefaults(defineProps<{ title?: string; subtitle?: string }>(), {
  title: undefined,
  subtitle: undefined,
})

const slots = useSlots()

const withFooter = computed(() => !!slots['footer'])
</script>

<template>
  <div class="rounded-lg bg-white ring-1 shadow ring-black/5 dark:bg-gray-800 dark:ring-white/15">
    <div
      v-if="title"
      class="flex flex-wrap items-center justify-between border-b border-b-black/5 px-4 py-2 dark:border-b-white/15"
    >
      <div>
        <h3 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ title }}</h3>
        <p v-if="subtitle" class="mt-1 text-sm text-gray-500 dark:text-gray-200">
          {{ subtitle }}
        </p>
      </div>
      <div class="flex items-center">
        <slot name="actions" />
      </div>
    </div>
    <div class="px-4 py-5 text-gray-500 dark:text-gray-300">
      <slot name="content" />
    </div>
    <div
      v-if="withFooter"
      class="dark:bg-surface-700 flex justify-end rounded-b-lg border-t px-4 py-4 text-gray-500 sm:px-6 dark:border-white/15 dark:text-gray-300"
    >
      <slot name="footer" />
    </div>
  </div>
</template>
