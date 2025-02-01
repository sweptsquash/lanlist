<script lang="ts" setup>
const props = defineProps<{
  label: string
  name: string
  sort: { cell: string; direction: 'asc' | 'desc' }
}>()

const emits = defineEmits<{ sort: [cell: string, direction: 'asc' | 'desc'] }>()

const sorted = computed(() => {
  return props.sort.cell === props.name
})
</script>

<template>
  <div
    class="inline-flex items-center"
    @click="emits('sort', name, sorted ? (props.sort.direction === 'asc' ? 'desc' : 'asc') : 'asc')"
  >
    {{ label }}
    <svg
      aria-hidden="true"
      class="ml-2 h-3 w-3 text-gray-400"
      xmlns="http://www.w3.org/2000/svg"
      viewBox="0 0 320 512"
    >
      <path
        v-if="!sorted"
        fill="currentColor"
        d="M41 288h238c21.4 0 32.1 25.9 17 41L177 448c-9.4 9.4-24.6 9.4-33.9 0L24 329c-15.1-15.1-4.4-41 17-41zm255-105L177 64c-9.4-9.4-24.6-9.4-33.9 0L24 183c-15.1 15.1-4.4 41 17 41h238c21.4 0 32.1-25.9 17-41z"
      />
      <template v-else>
        <path
          v-if="sort.direction === 'asc'"
          fill="currentColor"
          d="M279 224H41c-21.4 0-32.1-25.9-17-41L143 64c9.4-9.4 24.6-9.4 33.9 0l119 119c15.2 15.1 4.5 41-16.9 41z"
        />

        <path
          v-if="sort.direction === 'desc'"
          fill="currentColor"
          d="M41 288h238c21.4 0 32.1 25.9 17 41L177 448c-9.4 9.4-24.6 9.4-33.9 0L24 329c-15.1-15.1-4.4-41 17-41z"
        />
      </template>
    </svg>
  </div>
</template>
