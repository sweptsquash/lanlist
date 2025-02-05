<script lang="ts" setup>
defineProps<{ organiser: App.Organiser }>()
</script>

<template>
  <div>
    <AppHead :title="organiser.title" />

    <HeaderSection>
      <h2 class="mb-4 text-5xl font-semibold tracking-tight text-white sm:text-7xl">
        {{ organiser.title }}
      </h2>
    </HeaderSection>
  </div>
</template>
