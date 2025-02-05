<script lang="ts" setup>
import Badge from '@/Components/Badge.vue'
import IconLoading from '@/Components/Icons/IconLoading.vue'
import SortHeader from '@/Components/SortHeader.vue'
import { pickBy } from 'lodash'
import qs from 'qs'
import { CalendarIcon, DocumentIcon, DocumentTextIcon, RssIcon } from '~/@heroicons/vue/24/outline'

const props = defineProps<{ venues: App.PageResource<App.Venue>; countries: App.Country[] }>()

const isLoading = ref(false)

const showFilters = ref(false)

const filtersForm = reactive<{
  venue_title: string | null
  events: number | null
  country: string | null
}>({
  venue_title: null,
  events: null,
  country: null,
})

const title = computed(
  () =>
    `Venues ${props.venues.meta.current_page > 1 ? ' &bull; Page ' + props.venues.meta.current_page : ''}`,
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
    cell: 'start_date',
    direction: 'desc',
  }
})

const activeFilterCount = computed(() => {
  let count = 0

  if (filtersForm.venue_title) {
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

      if (Object.prototype.hasOwnProperty.call(filter, 'venue_title')) {
        filtersForm.venue_title = filter.venue_title as string
      }

      if (Object.prototype.hasOwnProperty.call(filter, 'events')) {
        filtersForm.events = filter.events as number
      }

      if (Object.prototype.hasOwnProperty.call(filter, 'country')) {
        filtersForm.country = filter.country as string
      }
    }
  }
})

function applySort(cell: string, sort: 'asc' | 'desc') {
  let query: { sort: string; [key: string]: unknown } = {
    sort: `${sort === 'desc' ? '-' : ''}${cell}`,
    filter: null,
  }

  if (filtersForm.venue_title && typeof query.filter === 'object') {
    query.filter = {
      ...query.filter,
      event_title: filtersForm.venue_title,
    }
  }

  if (filtersForm.events && typeof query.filter === 'object') {
    query.filter = {
      ...query.filter,
      organiser_title: filtersForm.events,
    }
  }

  if (filtersForm.country && typeof query.filter === 'object') {
    query.filter = {
      ...query.filter,
      country: filtersForm.country,
    }
  }

  router.get(
    '/events?' +
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

function applyFilters() {
  let query: { sort: string; [key: string]: unknown } = {
    sort: (currentSort.value.direction === 'desc' ? '-' : '') + currentSort.value.cell,
    filter: null,
  }

  if (filtersForm.venue_title && typeof query.filter === 'object') {
    query.filter = {
      ...query.filter,
      venue_title: filtersForm.venue_title,
    }
  }

  if (filtersForm.events && typeof query.filter === 'object') {
    query.filter = {
      ...query.filter,
      seats: filtersForm.events,
    }
  }

  if (filtersForm.country && typeof query.filter === 'object') {
    query.filter = {
      ...query.filter,
      country: filtersForm.country,
    }
  }

  router.get(
    '/vanues?' +
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
  filtersForm.venue_title = null
  filtersForm.events = null
  filtersForm.country = null

  applyFilters()
}
</script>

<template>
  <div>
    <AppHead :title />

    <div class="mx-auto mt-12 max-w-2xl lg:max-w-7xl">
      <Panel
        title="Venues"
        subtitle="These venues are halls, rooms and places that host LAN Parties. You can view venues by country, or find an organizer that takes your fancy."
      >
        <template #actions>
          <button class="btn-primary" @click="showFilters = !showFilters">
            Filters
            <Badge
              v-if="activeFilterCount > 0"
              :text="activeFilterCount.toString()"
              class="ml-2 text-xs"
            />
          </button>
          <div>
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
          </div>
        </template>
        <template #content>
          <div
            v-if="showFilters"
            class="mb-4 grid grid-cols-1 space-y-4 sm:grid-cols-3 sm:space-x-4"
          >
            <TextInput id="venue_title" v-model="filtersForm.venue_title" label="Venue" />
            <TextInput id="events" v-model="filtersForm.events" label="Events" type="number" />
            <SelectInput
              id="country"
              v-model="filtersForm.country"
              name="country"
              label="Country"
              label-prop="name"
              value-prop="code"
              can-clear
              can-deselect
              searchable
              :options="countries"
            />
            <div class="col-span-1 flex flex-col gap-4 sm:col-span-3 sm:flex-row">
              <button class="btn-primary flex-1" @click="applyFilters">Apply</button>
              <button class="btn-danger flex-1" @click="resetFilters">Reset</button>
            </div>
          </div>

          <div
            v-if="(venues === undefined || venues?.data?.length === 0) && !isLoading"
            class="relative block w-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center"
          >
            <div class="absolute inset-0 flex items-center justify-center">
              <div>
                <p class="text-gray-500 dark:text-white">No venues found</p>
                <p class="mt-1 text-sm text-gray-500">
                  We have no records of venues at the moment, please check back later.
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
                    <SortHeader label="Venue" name="title" :sort="currentSort" @sort="applySort" />
                  </th>
                  <th
                    scope="col"
                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white"
                  >
                    # Events
                  </th>
                  <th
                    scope="col"
                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white"
                  >
                    Country
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
                    v-for="(venue, index) in venues.data"
                    :key="`venue${venue.id}`"
                    class="hover:bg-gray-50 dark:hover:bg-white/15"
                  >
                    <td
                      :class="[
                        'relative px-3 py-4 text-sm',
                        { 'border-t border-gray-200 dark:border-white/15': index !== 0 },
                      ]"
                    >
                      <InertiaLink :href="route('venues.show', { event: venue.slug })" class="link">
                        {{ venue.title }}
                      </InertiaLink>
                    </td>
                    <td
                      :class="[
                        'relative px-3 py-4 text-center text-sm',
                        { 'border-t border-gray-200 dark:border-white/15': index !== 0 },
                      ]"
                    >
                      {{ venue.upcoming_events_count }}
                    </td>
                    <td
                      :class="[
                        'relative px-3 py-4 text-sm',
                        { 'border-t border-gray-200 dark:border-white/15': index !== 0 },
                      ]"
                    >
                      {{ venue?.country?.name ?? 'N/A' }}
                    </td>
                  </tr>
                </template>
              </tbody>
            </table>
          </div>

          <Pagination
            v-if="venues && venues.meta.total > venues.meta.per_page"
            class="mt-4"
            :meta="venues.meta"
          />
        </template>
      </Panel>
    </div>
  </div>
</template>
