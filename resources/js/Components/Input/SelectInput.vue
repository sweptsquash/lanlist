<script lang="ts" setup>
import Multiselect from '@vueform/multiselect'
import type { SetupContext } from 'vue'

withDefaults(
  defineProps<{
    id: string
    placeholder?: string
    required?: boolean
    modelValue: string | number | null
    options: unknown[]
    valueProp?: string
    captionProp?: string
    labelProp?: string
    canClear?: boolean
    canDeselect?: boolean
    searchable?: boolean
    loading?: boolean
    filterResults?: boolean
    object?: boolean
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
    placeholder: undefined,
    options: () => [],
    valueProp: 'id',
    captionProp: 'caption',
    labelProp: 'name',
    canClear: true,
    canDeselect: true,
    searchable: false,
    loading: false,
    filterResults: true,
    object: false,
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
  'update:modelValue': [value: string | number | null]
  change: [value: string | number | null]
  'search-change': [value: string]
}>()

const slots: SetupContext['slots'] = useSlots()

const hasHelperText = computed(() => (slots.helperText ? !!slots.helperText() : false))

function handleChange(value: string | number | null) {
  emit('update:modelValue', value)
  emit('change', value)
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
      <Multiselect
        :id="id"
        :options="options"
        :label="labelProp"
        :value="modelValue"
        :can-clear="canClear"
        :can-deselect="canDeselect"
        :value-prop="valueProp"
        :searchable="searchable"
        :loading="loading"
        :filter-results="filterResults"
        :placeholder="placeholder"
        :object="object"
        @change="(e) => handleChange(e)"
        @search-change="(e) => emit('search-change', e)"
      >
        <template #option="{ option }">
          <div class="flex flex-col">
            <p v-text="option[labelProp]"></p>
            <span
              v-if="option.hasOwnProperty(captionProp)"
              class="text-sm text-gray-400"
              v-text="option[captionProp]"
            ></span>
          </div>
        </template>
      </Multiselect>
      <p v-if="hasHelperText" class="mt-2 text-sm text-gray-400">
        <slot name="helperText"></slot>
      </p>
      <p v-if="!isValid" :id="`${id}-error`" class="mt-2 text-sm text-red-600">
        {{ error }}
      </p>
    </template>
  </BaseInput>
</template>
