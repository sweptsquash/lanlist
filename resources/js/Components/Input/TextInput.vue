<script lang="ts" setup>
import { ExclamationCircleIcon } from '@heroicons/vue/20/solid'
import type { SetupContext } from 'vue'

withDefaults(
  defineProps<{
    id: string
    type?: 'text' | 'number'
    name?: string
    placeholder?: string
    autocomplete?: string
    required?: boolean
    disabled?: boolean
    readonly?: boolean
    modelValue: string | number | null
    hideLabel?: boolean
    label?: string
    labelPosition?: 'left' | 'top'
    labelAlignment?: 'left' | 'right'
    labelWidth?: number
    caption?: string
    isValid?: boolean
    error?: string
  }>(),
  {
    name: undefined,
    type: 'text',
    placeholder: undefined,
    autocomplete: 'off',
    required: false,
    disabled: false,
    readonly: false,
    hideLabel: false,
    label: undefined,
    labelPosition: 'top',
    labelAlignment: 'left',
    labelWidth: 33,
    caption: undefined,
    isValid: true,
    error: undefined,
  },
)

const emit = defineEmits<{
  'update:modelValue': [value: string]
  keyup: [value: KeyboardEvent]
  blur: [value: FocusEvent]
  focus: [value: FocusEvent]
}>()

const slots: SetupContext['slots'] = useSlots()

const hasIcon = computed(() => (slots.icon ? !!slots.icon() : false))
const hasHelperText = computed(() => (slots.helperText ? !!slots.helperText() : false))

function handleInput(eventTarget: EventTarget | null) {
  if (!eventTarget) return

  emit('update:modelValue', (eventTarget as HTMLInputElement).value)
}
</script>

<template>
  <BaseInput
    :hide-label="hideLabel"
    :label="label"
    :label-position="labelPosition"
    :label-alignment="labelAlignment"
    :label-width="labelWidth"
    :label-for="id"
    :caption="caption"
    :required="required"
  >
    <template #input>
      <div class="relative rounded-md shadow-xs">
        <div
          v-if="hasIcon"
          class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"
        >
          <slot name="icon"></slot>
        </div>
        <input
          :id
          :type
          :name="name ?? id"
          :placeholder
          :autocomplete
          :required
          :disabled
          :readonly
          :value="modelValue"
          :class="['form-input', { 'pl-10': hasIcon, 'pr-10': !isValid, error: !isValid }]"
          :aria-invalid="isValid"
          :aria-describedby="`${name ?? id}-error`"
          @blur="(e) => emit('blur', e)"
          @focus="(e) => emit('focus', e)"
          @input="(e) => handleInput(e.target)"
          @keyup="(e) => emit('keyup', e)"
        />
        <div
          v-if="!isValid"
          class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3"
        >
          <ExclamationCircleIcon class="h-5 w-5 text-red-500" aria-hidden="true" />
        </div>
      </div>
      <p v-if="hasHelperText" class="mt-2 text-sm text-gray-400">
        <slot name="helperText"></slot>
      </p>
      <p v-if="!isValid" :id="`${name ?? id}-error`" class="mt-2 text-sm text-red-600">
        {{ error }}
      </p>
    </template>
  </BaseInput>
</template>
