<script lang="ts" setup>
import Badge from '@/Components/Badge.vue'
import IconLoading from '@/Components/Icons/IconLoading.vue'
import SortHeader from '@/Components/SortHeader.vue'
import { pickBy } from 'lodash'
import qs from 'qs'
import { CalendarIcon, DocumentIcon, DocumentTextIcon, RssIcon } from '~/@heroicons/vue/24/outline'

const props = defineProps<{
  organisers: App.PageResource<App.Organiser>
  countries: App.Country[]
}>()

const isLoading = ref(false)

const showFilters = ref(false)

const filtersForm = reactive<{
  title: string | null
  events: number | null
  country: string | null
}>({
  title: null,
  events: null,
  country: null,
})

const title = computed(
  () =>
    `Organisers ${props.organisers.meta.current_page > 1 ? ' &bull; Page ' + props.organisers.meta.current_page : ''}`,
)

const currentSort = computed((): { cell: string; direction: 'asc' | 'desc' } => {
  if (typeof location !== 'undefined') {
    const urlParams = qs.parse(location.search, { ignoreQueryPrefix: true })

    if (Object.prototype.hasOwnProperty.call(urlParams, 'sort')) {
      const cell = urlParams.sort as string

      return {
        cell: cell.replace('-', ''),
        direction: cell.indexOf('-') !== -1 ? 'desc' : 'asc',
      }
    }
  }

  return {
    cell: 'title',
    direction: 'asc',
  }
})

const activeFilterCount = computed(() => {
  let count = 0

  if (filtersForm.title) {
    count++
  }

  if (filtersForm.events) {
    count++
  }

  if (filtersForm.country) {
    count++
  }

  return count
})

onMounted(() => {
  if (typeof location !== 'undefined') {
    const urlParams = qs.parse(location.search, { ignoreQueryPrefix: true })

    if (Object.prototype.hasOwnProperty.call(urlParams, 'filter')) {
      const filter = urlParams.filter as Record<string, unknown>

      if (Object.prototype.hasOwnProperty.call(filter, 'title')) {
        filtersForm.title = filter.venue_title as string
      }

      if (Object.prototype.hasOwnProperty.call(filter, 'events')) {
        filtersForm.events = filter.events as number
      }
    }
  }
})

function applySort(cell: string, sort: 'asc' | 'desc') {
  let query: { sort: string; [key: string]: unknown } = {
    sort: `${sort === 'desc' ? '-' : ''}${cell}`,
    filter: null,
  }

  if (filtersForm.title && typeof query.filter === 'object') {
    query.filter = {
      ...query.filter,
      title: filtersForm.title,
    }
  }

  if (filtersForm.events && typeof query.filter === 'object') {
    query.filter = {
      ...query.filter,
      events: filtersForm.events,
    }
  }

  router.get(
    '/organisers?' +
      qs.stringify(query, {
        filter(prefix: string, value: unknown) {
          if (typeof value === 'object' && value !== null) {
            return pickBy(value)
          }

          return value
        },
        skipNulls: true,
        strictNullHandling: true,
        encode: false,
      }),
    {},
    {
      replace: true,
      preserveState: false,
      preserveScroll: true,
      onBefore() {
        isLoading.value = true
      },
      onFinish() {
        isLoading.value = false
      },
    },
  )
}

function applyFilters(pageNumber: number | null = null) {
  let query: { page: number | null; sort: string; [key: string]: unknown } = {
    page: pageNumber ?? null,
    sort: (currentSort.value.direction === 'desc' ? '-' : '') + currentSort.value.cell,
    filter: null,
  }

  if (filtersForm.title && typeof query.filter === 'object') {
    query.filter = {
      ...query.filter,
      title: filtersForm.title,
    }
  }

  if (filtersForm.events && typeof query.filter === 'object') {
    query.filter = {
      ...query.filter,
      events: filtersForm.events,
    }
  }

  router.get(
    '/organisers?' +
      qs.stringify(query, {
        filter(prefix: string, value: unknown) {
          if (typeof value === 'object' && value !== null) {
            return pickBy(value)
          }

          return value
        },
        skipNulls: true,
        strictNullHandling: true,
        encode: false,
      }),
    {},
    {
      replace: true,
      preserveState: false,
      preserveScroll: true,
      onBefore() {
        isLoading.value = true
      },
      onFinish() {
        isLoading.value = false
      },
    },
  )
}

function resetFilters() {
  filtersForm.title = null
  filtersForm.events = null

  applyFilters()
}
</script>

<template>
  <div>
    <AppHead :title />

    <div class="mx-auto mt-12 max-w-2xl lg:max-w-7xl">
      <Panel title="Organisers">
        <template #actions>
          <button class="btn-primary" @click="showFilters = !showFilters">
            Filters
            <Badge
              v-if="activeFilterCount > 0"
              :text="activeFilterCount.toString()"
              class="ml-2 text-xs"
            />
          </button>
          <span class="btn-group">
            <a v-tooltip="'RSS'" href="#" class="btn-default"><RssIcon class="size-5" /></a>
            <a v-tooltip="'iCalendar'" href="#" class="btn-default">
              <CalendarIcon class="size-5" />
            </a>
            <a v-tooltip="'CSV'" href="#" class="btn-default">
              <DocumentTextIcon class="size-5" />
            </a>
            <a v-tooltip="'JSON'" href="#" class="btn-default"><DocumentIcon class="size-5" /></a>
          </span>
        </template>
        <template #content>
          <div v-if="showFilters" class="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
            <TextInput id="title" v-model="filtersForm.title" label="Venue" />
            <TextInput
              id="events"
              v-model="filtersForm.events"
              label="Number Of Events"
              type="number"
            />
            <div class="col-span-1 flex flex-col gap-4 sm:col-span-3 sm:flex-row">
              <button class="btn-primary flex-1" @click="applyFilters()">Apply</button>
              <button class="btn-danger flex-1" @click="resetFilters">Reset</button>
            </div>
          </div>

          <div
            v-if="(organisers === undefined || organisers?.data?.length === 0) && !isLoading"
            class="relative block w-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center"
          >
            <div class="absolute inset-0 flex items-center justify-center">
              <div>
                <p class="text-gray-500 dark:text-white">No organisers found</p>
                <p class="mt-1 text-sm text-gray-500">
                  We have no records of organisers at the moment, please check back later.
                </p>
              </div>
            </div>
          </div>
          <div v-else class="overflow-auto ring-1 ring-gray-300 sm:rounded-lg dark:ring-white/15">
            <table class="min-w-full table-auto divide-y divide-gray-300 dark:divide-white/15">
              <thead>
                <tr>
                  <th
                    scope="col"
                    class="hidden cursor-pointer px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell dark:text-white"
                  >
                    <SortHeader
                      label="Organiser"
                      name="title"
                      :sort="currentSort"
                      @sort="applySort"
                    />
                  </th>
                  <th
                    scope="col"
                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white"
                  >
                    Website
                  </th>
                  <th
                    scope="col"
                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white"
                  >
                    <SortHeader
                      label="# Events"
                      name="events_count"
                      :sort="currentSort"
                      @sort="applySort"
                    />
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-if="isLoading">
                  <td colspan="6" class="px-3 py-4 text-sm dark:text-gray-100">
                    <div class="flex w-full items-center justify-center">
                      <IconLoading
                        class="text-primary-500 mr-4 size-8 animate-spin dark:text-white"
                      />
                      <span class="font-medium dark:text-white">Loading Venues...</span>
                    </div>
                  </td>
                </tr>
                <template v-else>
                  <tr
                    v-for="(organiser, index) in organisers.data"
                    :key="`organiser${organiser.id}`"
                    class="hover:bg-gray-50 dark:hover:bg-white/15"
                  >
                    <td
                      :class="[
                        'relative px-3 py-4 text-sm',
                        { 'border-t border-gray-200 dark:border-white/15': index !== 0 },
                      ]"
                    >
                      <InertiaLink
                        :href="route('organisers.show', { organiser: organiser.slug })"
                        class="link"
                      >
                        {{ organiser.title }}
                      </InertiaLink>
                    </td>
                    <td
                      :class="[
                        'relative px-3 py-4 text-sm',
                        { 'border-t border-gray-200 dark:border-white/15': index !== 0 },
                      ]"
                    >
                      {{ organiser?.website ?? 'N/A' }}
                    </td>
                    <td
                      :class="[
                        'relative px-3 py-4 text-center text-sm',
                        { 'border-t border-gray-200 dark:border-white/15': index !== 0 },
                      ]"
                    >
                      <Badge :text="organiser.events_count?.toString() ?? 'N/A'" />
                    </td>
                  </tr>
                </template>
              </tbody>
            </table>
          </div>

          <Pagination
            v-if="organisers && organisers.meta.total > organisers.meta.per_page"
            class="mt-4"
            :meta="organisers.meta"
            @page-change="applyFilters"
          />
        </template>
      </Panel>
    </div>
  </div>
</template>
