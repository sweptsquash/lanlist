<script lang="ts" setup>
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/24/solid/index.js'

const props = withDefaults(
  defineProps<{
    meta: App.PageMeta
    range?: number
  }>(),
  {
    range: 10,
  },
)

const emit = defineEmits<{ pageChange: [value: number] }>()

const data = reactive<{
  page: {
    first: number
    current: number
    previous: number
    next: number
    last: number
    min: number
    max: number
    range: { [key: number]: number }
  }
}>({
  page: {
    first: 1,
    current: 1,
    previous: 0,
    next: 0,
    last: 0,
    min: 0,
    max: 0,
    range: [],
  },
})

watch(() => props.meta, calcPageRange, { deep: true, immediate: true })

function calcPageRange() {
  let previousPage: number = props.meta?.current_page - 1
  let nextPage: number = props.meta?.current_page + 1

  const maxPagesBeforeCurrentPage = Math.floor(props.range / 2)
  const maxPagesAfterCurrentPage = Math.floor(props.range / 2) - 1

  if (previousPage < 1) {
    previousPage = 0
  }

  if (nextPage > props.meta?.last_page) {
    nextPage = 0
  }

  data.page.current = props.meta?.current_page
  data.page.previous = previousPage
  data.page.next = nextPage
  data.page.last = props.meta?.last_page ?? 1

  if (data.page.last <= props.range) {
    data.page.min = 1
    data.page.max = data.page.last
  } else if (data.page.current <= maxPagesBeforeCurrentPage) {
    data.page.min = 1
    data.page.max = props.range
  } else if (data.page.current + maxPagesAfterCurrentPage >= data.page.last) {
    data.page.min = data.page.last - props.range + 1
    data.page.max = data.page.last
  } else {
    data.page.min = data.page.current - maxPagesBeforeCurrentPage
    data.page.max = data.page.current + maxPagesAfterCurrentPage
  }

  data.page.range = Array.from(Array(data.page.max + 1 - data.page.min).keys()).map(
    (i) => data.page.min + i,
  )
}
</script>

<template>
  <div class="flex w-full items-center justify-between">
    <div class="flex flex-1 justify-between sm:hidden">
      <button
        type="button"
        class="btn btn-default relative inline-flex"
        :class="{ disabled: data.page.current <= 1 && data.page.previous === 0 }"
        @click.prevent="
          data.page.current <= 1 && data.page.previous === 0
            ? undefined
            : emit('pageChange', data.page.previous)
        "
      >
        Previous
      </button>
      <button
        type="button"
        class="btn btn-default relative inline-flex"
        :class="{
          disabled: data.page.current >= data.page.last,
        }"
        @click.prevent="
          data.page.current >= data.page.last ? undefined : emit('pageChange', data.page.next)
        "
      >
        Next
      </button>
    </div>
    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
      <div>
        <p class="text-sm text-gray-700 dark:text-gray-300">
          Showing
          {{ ' ' }}
          <span class="font-medium">{{ meta?.from }}</span>
          {{ ' ' }}
          to
          {{ ' ' }}
          <span class="font-medium">{{ meta?.to }}</span>
          {{ ' ' }}
          of
          {{ ' ' }}
          <span class="font-medium">{{ meta?.total }}</span>
          {{ ' ' }}
          results
        </p>
      </div>
      <div>
        <nav
          class="relative z-0 inline-flex -space-x-px rounded-md shadow-xs"
          aria-label="Pagination"
        >
          <button
            type="button"
            class="btn btn-default relative inline-flex rounded-r-none"
            :class="{ disabled: data.page.current <= 1 && data.page.previous === 0 }"
            @click.prevent="
              data.page.current <= 1 && data.page.previous === 0
                ? undefined
                : emit('pageChange', data.page.previous)
            "
          >
            <span class="sr-only">Previous</span>
            <ChevronLeftIcon class="h-5 w-5" aria-hidden="true" />
          </button>
          <button
            v-for="p in data.page.range"
            :key="`page${p}`"
            type="button"
            :aria-current="data.page.current === p ? 'page' : undefined"
            class="btn btn-default relative inline-flex items-center rounded-none"
            :class="{
              'btn-primary z-10': data.page.current === p,
            }"
            @click.prevent="emit('pageChange', p)"
          >
            {{ p }}
          </button>
          <button
            type="button"
            class="btn btn-default relative inline-flex rounded-l-none"
            :class="{
              disabled: data.page.current >= data.page.last,
            }"
            @click.prevent="
              data.page.current >= data.page.last ? undefined : emit('pageChange', data.page.next)
            "
          >
            <span class="sr-only">Next</span>
            <ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
          </button>
        </nav>
      </div>
    </div>
  </div>
</template>
