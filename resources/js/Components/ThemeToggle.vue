<script lang="ts" setup>
import { ComputerDesktopIcon, MoonIcon, SunIcon } from '@heroicons/vue/24/solid'
import { type BasicColorSchema, useColorMode, useCycleList } from '@vueuse/core'
import { watchEffect } from 'vue-demi'

const mode = useColorMode({ emitAuto: true })

const { state, next } = useCycleList(['dark', 'light', 'auto'], { initialValue: mode })

watchEffect(() => (mode.value = state.value as BasicColorSchema))
</script>

<template>
  <button class="cursor-pointer" @click="next()">
    <MoonIcon
      v-if="state === 'dark'"
      aria-hidden="true"
      class="inline-block h-6 w-6 align-middle dark:text-white/75 dark:hover:text-white"
    />
    <SunIcon
      v-if="state === 'light'"
      aria-hidden="true"
      class="inline-block h-6 w-6 align-middle dark:text-white/75 dark:hover:text-white"
    />
    <ComputerDesktopIcon
      v-if="state === 'auto'"
      aria-hidden="true"
      class="inline-block h-6 w-6 align-middle dark:text-white/75 dark:hover:text-white"
    />
  </button>
</template>
