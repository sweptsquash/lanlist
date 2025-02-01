<script lang="ts" setup>
withDefaults(
  defineProps<{
    type?: 'default' | 'danger' | 'warning' | 'success' | 'info' | 'primary'
    text: string
  }>(),
  {
    type: 'default',
  },
)
</script>

<template>
  <span
    :class="[
      'inline-flex items-center rounded-full px-3 py-0.5 text-sm font-medium',
      {
        'bg-gray-100 text-gray-800': type === 'default',
        'bg-red-100 text-red-800': type === 'danger',
        'bg-yellow-100 text-yellow-800': type === 'warning',
        'bg-green-100 text-green-800': type === 'success',
        'bg-blue-100 text-blue-800': type === 'info',
        'bg-indigo-100 text-indigo-800': type === 'primary',
      },
    ]"
  >
    {{ text }}
  </span>
</template>
