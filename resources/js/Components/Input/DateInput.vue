<script lang="ts" setup>
import Datepicker from '@vuepic/vue-datepicker'
import type { SetupContext } from 'vue'

withDefaults(
  defineProps<{
    id: string
    name?: string
    modelType?: string
    format?: string
    range?: boolean
    partialRange?: boolean
    autoApply?: boolean
    autoRange?: number | string
    multiCalendars?: boolean | number | string
    monthPicker?: boolean
    enableTimePicker?: boolean
    timePicker?: boolean
    yearPicker?: boolean
    weekPicker?: boolean
    textInput?: boolean
    textInputOptions?: App.TextInputOptions
    inline?: boolean
    multiDates?: boolean
    flow?: ('month' | 'year' | 'calendar' | 'time' | 'minutes' | 'hours' | 'seconds')[]
    utc?: boolean | 'preserve'
    vertical?: boolean
    modelAuto?: boolean
    timezone?: string
    clearable?: boolean
    minDate?: Date | string
    maxDate?: Date | string
    placeholder?: string
    autocomplete?: string
    required?: boolean
    disabled?: boolean
    readonly?: boolean
    modelValue: string | Date | null
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
    modelType: 'yyyy-MM-dd',
    format: 'dd/MM/yyyy',
    range: false,
    partialRange: false,
    autoApply: false,
    autoRange: undefined,
    multiCalendars: false,
    monthPicker: false,
    enableTimePicker: false,
    timePicker: false,
    yearPicker: false,
    weekPicker: false,
    textInput: false,
    textInputOptions: undefined,
    inline: false,
    multiDates: false,
    flow: () => [],
    utc: false,
    vertical: false,
    modelAuto: false,
    timezone: undefined,
    clearable: true,
    minDate: undefined,
    maxDate: undefined,
    placeholder: 'dd/mm/yyyy',
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
  'text-submit': [value: string]
  open: []
  closed: []
  cleared: []
  focus: []
  blur: []
}>()

const slots: SetupContext['slots'] = useSlots()

const hasHelperText = computed(() => (slots.helperText ? !!slots.helperText() : false))

function handleInput(value: string) {
  emit('update:modelValue', value)
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
      <Datepicker
        :id="id"
        :name="name ?? id"
        :model-value="modelValue"
        :model-type="modelType"
        :model-auto="modelAuto"
        :format="format"
        :range="range"
        :partial-range="partialRange"
        :auto-apply="autoApply"
        :auto-range="autoRange"
        :multi-calendars="multiCalendars"
        :month-picker="monthPicker"
        :enable-time-picker="enableTimePicker"
        :time-picker="timePicker"
        :year-picker="yearPicker"
        :week-picker="weekPicker"
        :text-input="textInput"
        :text-input-options="textInputOptions"
        :inline="inline"
        :multi-dates="multiDates"
        :flow="flow"
        :utc="utc"
        :vertical="vertical"
        :timezone="timezone"
        :clearable="clearable"
        :placeholder="placeholder"
        :autocomplete="autocomplete"
        :required="required"
        :disabled="disabled"
        :readonly="readonly"
        :min-date="minDate"
        :max-date="maxDate"
        :state="isValid ? undefined : false"
        @update:model-value="handleInput"
        @text-submit="(e: string) => emit('text-submit', e)"
        @open="emit('open')"
        @closed="emit('closed')"
        @cleared="emit('cleared')"
        @focus="emit('focus')"
        @blur="emit('blur')"
      />
      <p v-if="hasHelperText" class="mt-2 text-sm text-gray-400">
        <slot name="helperText"></slot>
      </p>
      <p v-if="!isValid" :id="`${name ?? id}-error`" class="mt-2 text-sm text-red-600">
        {{ error }}
      </p>
    </template>
  </BaseInput>
</template>
