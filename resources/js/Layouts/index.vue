<script lang="ts" setup>
import AppNav from '@/Components/AppNav.vue'

onMounted(() => {
  const timezone = useDayJs.tz.guess() ?? 'Europe/London'
  useDayJs.tz.setDefault(timezone)
})
</script>

<template>
  <main class="flex min-h-screen flex-col">
    <AppNav />
    <div class="p-4">
      <slot />
    </div>
    <AppFooter />
  </main>
</template>
