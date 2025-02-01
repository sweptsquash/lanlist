<script lang="ts" setup>
import { isEmpty } from 'lodash'

const props = withDefaults(
  defineProps<{
    image?: string
  }>(),
  {
    image: undefined,
  },
)

const hasImage = computed(() => {
  if (props.image === undefined || props.image === null) {
    return false
  }

  if (isEmpty(props.image)) {
    return false
  }

  return true
})

const imageUrl = computed(() => {
  if (!hasImage.value) {
    return undefined
  }

  return props.image
})
</script>

<template>
  <div
    class="relative isolate -mx-4 -mt-4 mb-4 overflow-hidden bg-gray-900 px-6 py-24 sm:py-32 lg:px-8"
  >
    <img
      v-if="imageUrl"
      class="absolute inset-0 -z-10 size-full object-cover"
      :src="imageUrl"
      alt=""
    />
    <div class="absolute inset-0 -z-10 bg-black/30"></div>
    <div
      class="hidden sm:absolute sm:-top-10 sm:right-1/2 sm:-z-10 sm:mr-10 sm:block sm:transform-gpu sm:blur-3xl"
      aria-hidden="true"
    >
      <div
        class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-20"
        style="
          clip-path: polygon(
            74.1% 44.1%,
            100% 61.6%,
            97.5% 26.9%,
            85.5% 0.1%,
            80.7% 2%,
            72.5% 32.5%,
            60.2% 62.4%,
            52.4% 68.1%,
            47.5% 58.3%,
            45.2% 34.5%,
            27.5% 76.7%,
            0.1% 64.9%,
            17.9% 100%,
            27.6% 76.8%,
            76.1% 97.7%,
            74.1% 44.1%
          );
        "
      />
    </div>
    <div
      class="absolute -top-52 left-1/2 -z-10 -translate-x-1/2 transform-gpu blur-3xl sm:top-[-28rem] sm:ml-16 sm:translate-x-0 sm:transform-gpu"
      aria-hidden="true"
    >
      <div
        class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-20"
        style="
          clip-path: polygon(
            74.1% 44.1%,
            100% 61.6%,
            97.5% 26.9%,
            85.5% 0.1%,
            80.7% 2%,
            72.5% 32.5%,
            60.2% 62.4%,
            52.4% 68.1%,
            47.5% 58.3%,
            45.2% 34.5%,
            27.5% 76.7%,
            0.1% 64.9%,
            17.9% 100%,
            27.6% 76.8%,
            76.1% 97.7%,
            74.1% 44.1%
          );
        "
      />
    </div>
    <div class="mx-auto max-w-2xl text-center">
      <slot />
    </div>
  </div>
</template>
