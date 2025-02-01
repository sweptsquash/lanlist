<script lang="ts" setup>
withDefaults(
  defineProps<{
    wrapperClass?: string
    size?: string
    src?: string | null
    alt?: string
    showStatus?: boolean
    isOnline?: boolean
  }>(),
  {
    wrapperClass: undefined,
    size: 'h-8 w-8',
    src: undefined,
    alt: '',
    showStatus: false,
    isOnline: false,
  },
)
</script>

<template>
  <span :class="['relative inline-block', wrapperClass]">
    <img v-if="src" :class="['rounded-full bg-white object-cover', size]" :src="src" :alt="alt" />
    <span v-else class="overflow-hidden rounded-full">
      <svg
        :class="['rounded-full dark:text-gray-300', size]"
        fill="currentColor"
        viewBox="0 0 24 24"
      >
        <path
          d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z"
        />
      </svg>
    </span>
    <span
      v-if="showStatus"
      :class="[
        'absolute top-0 right-0 block h-2 w-2 rounded-full ring-2 ring-white',
        { 'bg-green-400': isOnline, 'bg-red-400': !isOnline },
      ]"
    ></span>
  </span>
</template>
