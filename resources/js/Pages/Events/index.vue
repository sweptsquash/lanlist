<script lang="ts" setup>
import IconLoading from '@/Components/Icons/IconLoading.vue'
import SortHeader from '@/Components/SortHeader.vue'
import { CalendarIcon, DocumentIcon, DocumentTextIcon, RssIcon } from '~/@heroicons/vue/24/outline'

const props = defineProps<{ events: App.PageResource<App.Event> }>()

const isLoading = ref(false)

const title = computed(
  () =>
    `Events ${props.events.meta.current_page > 1 ? ' &bull; Page ' + props.events.meta.current_page : ''}`,
)
const currentSort = computed((): { cell: string; direction: 'asc' | 'desc' } => {
  if (typeof window !== 'undefined') {
    const urlParams = new URLSearchParams(window.location.search)

    if (urlParams.has('sort')) {
      const cell = urlParams.get('sort') as string

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

function applySort(cell: string, sort: 'asc' | 'desc') {
  router.get('/events', { sort: `${sort === 'desc' ? '-' : ''}${cell}` }, { replace: true })
  // TODO - Add filters to the query string
}
</script>

<template>
  <div>
    <AppHead :title />

    <div class="mx-auto mt-12 max-w-2xl lg:max-w-7xl">
      <Panel title="Events" subtitle="Upcoming Events World Wide">
        <template #actions>
          <button class="btn-primary">Filters</button>
          <div>
            <span class="btn-group">
              <a href="#" class="btn-default"><RssIcon class="size-5" /></a>
              <a href="#" class="btn-default"><CalendarIcon class="size-5" /></a>
              <a href="#" class="btn-default"><DocumentTextIcon class="size-5" /></a>
              <a href="#" class="btn-default"><DocumentIcon class="size-5" /></a>
            </span>
          </div>
        </template>
        <template #content>
          <div></div>

          <div
            v-if="(events === undefined || events?.data?.length === 0) && !isLoading"
            class="relative block w-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center"
          >
            <div class="absolute inset-0 flex items-center justify-center">
              <div>
                <p class="text-gray-500 dark:text-white">No events found</p>
                <p class="mt-1 text-sm text-gray-500">
                  We have no records of upcoming events at the moment, please check back later.
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
                    class="cursor-pointer px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white"
                  >
                    <SortHeader label="Event" name="title" :sort="currentSort" @sort="applySort" />
                  </th>
                  <th
                    scope="col"
                    class="hidden cursor-pointer px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell dark:text-white"
                  >
                    <SortHeader
                      label="Organiser"
                      name="organiser.title"
                      :sort="currentSort"
                      @sort="applySort"
                    />
                  </th>
                  <th
                    scope="col"
                    class="hidden cursor-pointer px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell dark:text-white"
                  >
                    <SortHeader
                      label="Venue"
                      name="venue.title"
                      :sort="currentSort"
                      @sort="applySort"
                    />
                  </th>
                  <th
                    scope="col"
                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white"
                  >
                    Country
                  </th>
                  <th
                    scope="col"
                    class="cursor-pointer px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white"
                  >
                    <SortHeader
                      label="Start Date"
                      name="start_date"
                      :sort="currentSort"
                      @sort="applySort"
                    />
                  </th>
                  <th
                    scope="col"
                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white"
                  >
                    # Seats
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
                      <span class="font-medium dark:text-white">Loading Events...</span>
                    </div>
                  </td>
                </tr>
                <template v-else>
                  <tr
                    v-for="(event, index) in events.data"
                    :key="`event${event.id}`"
                    class="hover:bg-gray-50 dark:hover:bg-white/15"
                  >
                    <td
                      :class="[
                        'relative px-3 py-4 text-sm',
                        { 'border-t border-gray-200 dark:border-white/15': index !== 0 },
                      ]"
                    >
                      <InertiaLink href="#" class="link">{{ event.title }}</InertiaLink>
                    </td>
                    <td
                      :class="[
                        'relative hidden px-3 py-4 text-sm lg:table-cell',
                        { 'border-t border-gray-200 dark:border-white/15': index !== 0 },
                      ]"
                    >
                      <InertiaLink href="#" class="link">
                        {{ event.organiser?.title ?? 'N/A' }}
                      </InertiaLink>
                    </td>
                    <td
                      :class="[
                        'relative hidden px-3 py-4 text-sm lg:table-cell',
                        { 'border-t border-gray-200 dark:border-white/15': index !== 0 },
                      ]"
                    >
                      <InertiaLink href="#" class="link">
                        {{ event.venue?.title ?? 'N/A' }}
                      </InertiaLink>
                    </td>
                    <td
                      :class="[
                        'relative px-3 py-4 text-sm',
                        { 'border-t border-gray-200 dark:border-white/15': index !== 0 },
                      ]"
                    >
                      {{ event?.venue?.country?.name ?? 'N/A' }}
                    </td>
                    <td
                      :class="[
                        'relative px-3 py-4 text-sm',
                        { 'border-t border-gray-200 dark:border-white/15': index !== 0 },
                      ]"
                    >
                      {{ useDayJs(event.start_date).format(useUserDateFormat) }}
                    </td>
                    <td
                      :class="[
                        'relative px-3 py-4 text-center text-sm',
                        { 'border-t border-gray-200 dark:border-white/15': index !== 0 },
                      ]"
                    >
                      {{ event.seats }}
                    </td>
                  </tr>
                </template>
              </tbody>
            </table>
          </div>
        </template>
      </Panel>
    </div>
  </div>
</template>
