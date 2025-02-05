<script lang="ts" setup>
defineProps<{ venue: App.Venue }>()
</script>

<template>
  <div>
    <AppHead :title="venue.title" />

    <HeaderSection>
      <h2 class="mb-4 text-5xl font-semibold tracking-tight text-white sm:text-7xl">
        {{ venue.title }}
      </h2>
    </HeaderSection>
  </div>
</template>
