<script lang="ts" setup>
withDefaults(
  defineProps<{
    hideLabel?: boolean
    label?: string
    labelPosition?: 'left' | 'top'
    labelAlignment?: 'left' | 'right'
    labelWidth?: number
    labelFor?: string
    caption?: string
    required?: boolean
  }>(),
  {
    hideLabel: false,
    label: undefined,
    labelPosition: 'top',
    labelAlignment: 'left',
    labelWidth: 35,
    labelFor: undefined,
    caption: undefined,
    required: false,
  },
)
</script>

<template>
  <div
    :class="['flex', { 'flex-col': labelPosition === 'top', 'flex-row': labelPosition === 'left' }]"
  >
    <label
      v-if="!hideLabel && (label != null || caption != null)"
      :class="[
        'form-label mb-1',
        {
          'w-full': labelPosition === 'top',
          'px-0': labelPosition === 'top',
          'text-left': labelAlignment === 'left',
          'text-right': labelAlignment === 'right',
          required,
        },
      ]"
      :for="labelFor"
      :style="`width: ${labelWidth}%`"
    >
      {{ label }}
      <div v-if="caption" class="text-sm font-normal text-gray-400">{{ caption }}</div>
    </label>
    <div class="flex-1">
      <slot name="input"></slot>
    </div>
  </div>
</template>
