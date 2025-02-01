<script lang="ts" setup>
import { LIcon, LMap, LMarker, LTileLayer, LTooltip } from '@vue-leaflet/vue-leaflet'
import { GoogleMap } from 'vue3-google-map'
import type { LatLngExpression, PointExpression } from '~/@types/leaflet'

defineProps<{
  events: Array<Array<App.Event>>
}>()

const mapCenter = {
  lat: 51.5074,
  lng: 0.1278,
}

const zoom = ref(5)

const attribution =
  '&copy; <a target="_blank" href="http://osm.org/copyright">OpenStreetMap</a> contributors'

const googleMapApi = null

const coordinates = computed<LatLngExpression>(() => [mapCenter.lat, mapCenter.lng])

const coordinateCenter = computed<PointExpression>(() => [mapCenter.lat, mapCenter.lng])
</script>

<template>
  <div>
    <AppHead />

    <div class="py-24">
      <div class="mx-auto max-w-2xl lg:max-w-7xl">
        <h2
          class="mt-2 w-full text-center text-4xl font-semibold tracking-tight text-pretty sm:text-5xl dark:text-white"
        >
          World Wide LAN Parties
        </h2>
        <div class="mt-10 grid grid-cols-1 gap-4 sm:mt-16 lg:grid-cols-6">
          <div class="flex p-px lg:col-span-4">
            <div
              class="min-h-[400px] min-w-full overflow-hidden rounded-lg bg-white ring-1 shadow ring-black/5 max-lg:rounded-t-[2rem] lg:min-h-auto lg:rounded-tl-[2rem] dark:bg-gray-800 dark:ring-white/15"
            >
              <GoogleMap v-if="googleMapApi" :api-key="googleMapApi" :center="mapCenter" :zoom />
              <LMap
                v-else
                v-model:zoom="zoom"
                class="z-0 w-full bg-gray-50"
                :center="coordinateCenter"
                :min-zoom="0"
                :max-zoom="18"
                :use-global-leaflet="false"
              >
                <LTileLayer
                  url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                  layer-type="base"
                  name="OpenStreetMap"
                  :attribution
                />
                <LMarker :lat-lng="coordinates" @click="console.log('You clicked me!')">
                  <LTooltip>London</LTooltip>
                  <LIcon :icon-size="[32, 32]">
                    <img
                      src="https://lanlist.info/resources/images/organizer-favicons/329.png"
                      class="h-auto w-full"
                    />
                  </LIcon>
                </LMarker>
              </LMap>
            </div>
          </div>
          <div class="flex p-px lg:col-span-2">
            <div
              class="overflow-hidden rounded-lg bg-white ring-1 shadow ring-black/5 lg:rounded-tr-[2rem] dark:bg-gray-800 dark:ring-white/15"
            >
              <div class="h-80 overflow-hidden">
                <table class="w-full table-auto">
                  <tbody>
                    <template v-for="(eventsInMonth, month) in events" :key="month">
                      <tr>
                        <td
                          colspan="3"
                          class="bg-gray-100 p-2 font-medium dark:bg-gray-700 dark:text-white"
                        >
                          {{ useDayJs(eventsInMonth.at(0)?.start_date).format('MMMM YYYY') }}
                        </td>
                      </tr>
                      <tr v-for="event in eventsInMonth" :key="event.id">
                        <td class="p-2 dark:text-gray-100">{{ event.venue?.country?.code }}</td>
                        <td class="p-2 dark:text-gray-100">
                          <InertiaLink
                            :href="route('events.show', { event: event.slug })"
                            class="link"
                          >
                            {{ event.title }}
                          </InertiaLink>
                        </td>
                        <td class="p-2 dark:text-gray-100">
                          {{ useDayJs(event.start_date).format('ddd Do') }}
                        </td>
                      </tr>
                    </template>
                  </tbody>
                </table>
              </div>
              <div class="p-10">
                <h3 class="text-lg font-semibold dark:text-white">Upcoming Events World Wide</h3>
                <p class="my-2 max-w-lg text-sm/6 text-gray-400">
                  Stay up-to-date with all the upcoming LAN events world wide.
                </p>
                <InertiaLink
                  :href="route('events.index')"
                  class="text-sm/4 text-indigo-400 underline decoration-dotted underline-offset-4 hover:text-indigo-700 dark:text-gray-300 dark:hover:text-white"
                >
                  View Upcoming Events &raquo;
                </InertiaLink>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="-mx-4 bg-white py-24 dark:bg-gray-800">
      <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl lg:text-center">
          <h2 class="text-base/7 font-semibold text-indigo-400">Publish Today</h2>
          <p
            class="mt-2 text-4xl font-semibold tracking-tight text-pretty sm:text-5xl lg:text-balance dark:text-white"
          >
            List your event today
          </p>
          <p class="mt-6 mb-8 text-lg/8 dark:text-gray-300">
            Simply create your account and list your event today. It's that simple.
          </p>
          <a href="#" class="btn-primary">Register Today</a>
        </div>
      </div>
    </div>

    <div class="py-12">
      <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div
          class="-mx-6 grid grid-cols-2 gap-0.5 overflow-hidden sm:mx-0 sm:rounded-2xl md:grid-cols-3"
        >
          <div class="bg-gray-400/5 p-6 sm:p-10 dark:bg-white/10">
            <img
              class="max-h-12 w-full object-contain"
              src="https://tailwindui.com/plus/img/logos/158x48/transistor-logo-gray-900.svg"
              alt="Transistor"
              width="158"
              height="48"
            />
          </div>
          <div class="bg-gray-400/5 p-6 sm:p-10 dark:bg-white/10">
            <img
              class="max-h-12 w-full object-contain"
              src="https://tailwindui.com/plus/img/logos/158x48/reform-logo-gray-900.svg"
              alt="Reform"
              width="158"
              height="48"
            />
          </div>
          <div class="bg-gray-400/5 p-6 sm:p-10 dark:bg-white/10">
            <img
              class="max-h-12 w-full object-contain"
              src="https://tailwindui.com/plus/img/logos/158x48/tuple-logo-gray-900.svg"
              alt="Tuple"
              width="158"
              height="48"
            />
          </div>
          <div class="bg-gray-400/5 p-6 sm:p-10 dark:bg-white/10">
            <img
              class="max-h-12 w-full object-contain"
              src="https://tailwindui.com/plus/img/logos/158x48/laravel-logo-gray-900.svg"
              alt="Laravel"
              width="158"
              height="48"
            />
          </div>
          <div class="bg-gray-400/5 p-6 sm:p-10 dark:bg-white/10">
            <img
              class="max-h-12 w-full object-contain"
              src="https://tailwindui.com/plus/img/logos/158x48/savvycal-logo-gray-900.svg"
              alt="SavvyCal"
              width="158"
              height="48"
            />
          </div>
          <div class="bg-gray-400/5 p-6 sm:p-10 dark:bg-white/10">
            <img
              class="max-h-12 w-full object-contain"
              src="https://tailwindui.com/plus/img/logos/158x48/statamic-logo-gray-900.svg"
              alt="Statamic"
              width="158"
              height="48"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
