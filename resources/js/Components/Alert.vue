<script lang="ts" setup>
import {
  CheckCircleIcon,
  ExclamationTriangleIcon,
  InformationCircleIcon,
  XCircleIcon,
} from '@heroicons/vue/24/solid'

withDefaults(
  defineProps<{
    type?: 'info' | 'danger' | 'success' | 'warning'
    title?: string | null
  }>(),
  {
    type: 'info',
    title: null,
  },
)
</script>

<template>
  <div
    :class="[
      'rounded-md p-4',
      {
        'bg-green-50': type === 'success',
        'bg-yellow-50': type === 'warning',
        'bg-blue-50': type === 'info',
        'bg-red-50': type === 'danger',
      },
    ]"
  >
    <div class="flex items-center">
      <div class="shrink-0">
        <CheckCircleIcon
          v-if="type === 'success'"
          class="h-5 w-5 text-green-400"
          aria-hidden="true"
        />
        <ExclamationTriangleIcon
          v-if="type === 'warning'"
          class="h-5 w-5 text-yellow-400"
          aria-hidden="true"
        />
        <InformationCircleIcon
          v-if="type === 'info'"
          class="h-5 w-5 text-blue-400"
          aria-hidden="true"
        />
        <XCircleIcon v-if="type === 'danger'" class="h-5 w-5 text-red-400" aria-hidden="true" />
      </div>
      <div class="ml-3">
        <h3
          v-if="title"
          :class="[
            'text-sm font-medium',
            {
              'text-green-800': type === 'success',
              'text-yellow-400': type === 'warning',
              'text-blue-700': type === 'info',
              'text-red-800': type === 'danger',
            },
          ]"
        >
          {{ title }}
        </h3>
        <div
          :class="[
            'text-sm',
            {
              'mt-2': title,
              'text-green-700': type === 'success',
              'text-yellow-700': type === 'warning',
              'text-blue-700': type === 'info',
              'text-red-700': type === 'danger',
            },
          ]"
        >
          <slot name="message" />
        </div>
      </div>
    </div>
  </div>
</template>
