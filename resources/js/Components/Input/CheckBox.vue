<script lang="ts" setup>
withDefaults(
  defineProps<{
    id: string
    name: string
    label?: string
    required?: boolean
    disabled?: boolean
    modelValue?: boolean
    isValid?: boolean
    error?: string
  }>(),
  {
    label: undefined,
    required: false,
    disabled: false,
    modelValue: false,
    isValid: true,
    error: undefined,
  },
)

const emit = defineEmits<{
  'update:modelValue': [value: boolean]
  keyup: [value: KeyboardEvent]
}>()

function handleInput(eventTarget: EventTarget | null) {
  if (!eventTarget) return

  emit('update:modelValue', (eventTarget as HTMLInputElement).checked)
}
</script>

<template>
  <div>
    <div class="flex items-center">
      <input
        :id="id"
        :name="name"
        type="checkbox"
        :checked="modelValue"
        :disabled="disabled"
        :required="required"
        :class="[
          'h-4 w-4 rounded-sm',
          {
            'border-gray-300 text-indigo-600 focus:ring-indigo-500': isValid,
            'border-red-300 text-red-900 focus:ring-red-500': !isValid,
          },
        ]"
        :aria-invalid="isValid"
        :aria-describedby="`${name}-error`"
        @input="(e) => handleInput(e.target)"
        @keyup="(e) => emit('keyup', e)"
      />
      <label
        :for="name"
        :class="['ml-2 block text-sm text-gray-900 dark:text-gray-300', { required }]"
      >
        {{ label }}
      </label>
    </div>
    <p v-if="!isValid" :id="`${name}-error`" class="mt-2 text-sm text-red-600">
      {{ error }}
    </p>
  </div>
</template>
