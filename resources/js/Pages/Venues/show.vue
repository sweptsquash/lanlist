<script lang="ts" setup>
import { LMap, LMarker, LTileLayer } from '@vue-leaflet/vue-leaflet'
import { pickBy } from 'lodash'
import qs from 'qs'
import type { LatLngExpression, PointExpression } from '~/@types/leaflet'

const props = defineProps<{ venue: App.Venue }>()

const zoom = ref(15)

const coordinates = computed<LatLngExpression>(() => [props.venue?.lat ?? 0, props.venue?.lng ?? 0])

const coordinateCenter = computed<PointExpression>(() => [
  props.venue?.lat ?? 0,
  props.venue?.lng ?? 0,
])

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
              <LMap
                v-model:zoom="zoom"
                class="z-0 h-100 w-full bg-gray-50"
                :center="coordinateCenter"
                :min-zoom="0"
                :max-zoom="18"
                :use-global-leaflet="false"
              >
                <LTileLayer
                  url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                  layer-type="base"
                  name="OpenStreetMap"
                />
                <LMarker :lat-lng="coordinates" />
              </LMap>
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
