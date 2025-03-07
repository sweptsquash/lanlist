<script lang="ts" setup>
import { PhotoIcon } from '@heroicons/vue/24/solid'
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
      <div
        class="mt-2 flex justify-center rounded-lg border-2 border-dashed border-gray-900/25 px-6 py-10 dark:border-white/15"
      >
        <div class="text-center">
          <PhotoIcon class="mx-auto size-12 text-gray-300" aria-hidden="true" />
          <div class="mt-4 flex text-sm/6 text-gray-600">
            <label
              for="file-upload"
              class="relative cursor-pointer rounded-md font-semibold text-indigo-600 focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 focus-within:outline-none hover:text-indigo-500"
            >
              <span>Upload a file</span>
              <input id="file-upload" name="file-upload" type="file" class="sr-only" />
            </label>
            <p class="pl-1">or drag and drop</p>
          </div>
          <p class="text-xs/5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
        </div>
      </div>
    </template>
  </BaseInput>
</template>
