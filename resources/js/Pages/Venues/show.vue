<script lang="ts" setup>
import { pickBy } from 'lodash'
import qs from 'qs'
import { AdvancedMarker, GoogleMap } from 'vue3-google-map'

const props = defineProps<{ venue: App.Venue }>()

const markerOptions = computed(() => {
  return {
    position: { lat: props.venue?.lat ?? 0, lng: props.venue?.lng ?? 0 },
    title: props.venue.title,
  }
})

const zoom = ref(10)

const googleAPIKey = import.meta.env.VITE_GOOGLE_MAPS_API_KEY
const googleMapId = import.meta.env.VITE_GOOGLE_MAPS_MAP_ID

const googleMapsLink = computed(
  () =>
    `https://www.google.com/maps/place/${props.venue?.lat},${props.venue?.lng}/@${props.venue?.lat},${props.venue?.lng},15z`,
)

function moreEvents() {
  const query = { filter: { venue_title: props.venue.title }, sort: '-start_date' }

  router.visit(
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
  )
}
</script>

<template>
  <div>
    <AppHead :title="venue.title" />

    <HeaderSection>
      <h2 class="mb-4 text-5xl font-semibold tracking-tight text-white sm:text-7xl">
        {{ venue.title }}
      </h2>
    </HeaderSection>

    <div class="mx-auto mt-12 max-w-2xl space-y-4 lg:max-w-7xl">
      <Panel v-if="props.venue?.lat !== null && props.venue?.lng !== null" title="Venue Details">
        <template #content>
          <div class="grid grid-cols-1 space-y-4">
            <div>
              <GoogleMap
                :api-key="googleAPIKey"
                :map-id="googleMapId"
                class="z-0 h-[516px] w-full bg-gray-50"
                :center="{ lat: venue?.lat ?? 0, lng: venue?.lng ?? 0 }"
                :zoom
              >
                <AdvancedMarker :options="markerOptions" />
              </GoogleMap>
            </div>
            <div>
              <a
                :href="googleMapsLink"
                class="btn-primary inline-flex w-full justify-center"
                target="_blank"
                rel="noopener noreferrer"
              >
                Get Directions
              </a>
            </div>
          </div>
        </template>
      </Panel>
      <Panel title="Upcoming Events">
        <template #content>
          <div
            v-if="venue.events === undefined || venue.events?.length === 0"
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
          <template v-else>
            <div class="overflow-auto ring-1 ring-gray-300 sm:rounded-lg dark:ring-white/15">
              <table class="min-w-full table-auto divide-y divide-gray-300 dark:divide-white/15">
                <thead>
                  <tr>
                    <th
                      scope="col"
                      class="cursor-pointer px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white"
                    >
                      Event
                    </th>
                    <th
                      scope="col"
                      class="hidden cursor-pointer px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell dark:text-white"
                    >
                      Organiser
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
                      Start Date
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
                  <tr
                    v-for="(event, index) in venue.events"
                    :key="`event${event.id}`"
                    class="hover:bg-gray-50 dark:hover:bg-white/15"
                  >
                    <td
                      :class="[
                        'relative px-3 py-4 text-sm',
                        { 'border-t border-gray-200 dark:border-white/15': index !== 0 },
                      ]"
                    >
                      <InertiaLink :href="route('events.show', { event: event.slug })" class="link">
                        {{ event.title }}
                      </InertiaLink>
                    </td>
                    <td
                      :class="[
                        'relative hidden px-3 py-4 text-sm lg:table-cell',
                        { 'border-t border-gray-200 dark:border-white/15': index !== 0 },
                      ]"
                    >
                      <InertiaLink
                        :href="route('organisers.show', { organiser: event.organiser?.slug })"
                        class="link"
                      >
                        {{ event.organiser?.title ?? 'N/A' }}
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
                </tbody>
              </table>
            </div>
            <div class="mt-4 flex">
              <button class="btn-primary flex-1 text-center" @click="moreEvents">
                View More Upcoming Events
              </button>
            </div>
          </template>
        </template>
      </Panel>
    </div>
  </div>
</template>
