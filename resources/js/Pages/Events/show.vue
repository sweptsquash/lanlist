<script lang="ts" setup>
import socialBanner from '@/../images/social-banner.png'
import { BedIcon, BeerIcon, CigaretteIcon, NetworkIcon, ShowerHeadIcon } from 'lucide-vue-next'
import type { FunctionalComponent } from 'vue'
import { AdvancedMarker, GoogleMap } from 'vue3-google-map'

const props = defineProps<{ event: App.Event; ogImage: string | null }>()

const location = computed(() => usePage().props.location)

const facilities = computed(() => {
  const data: {
    name: string
    icon: FunctionalComponent
    key: keyof App.Event
    value: string | null
  }[] = [
    { name: 'Sleeping', icon: BedIcon, key: 'sleeping', value: null },
    { name: 'Showers', icon: ShowerHeadIcon, key: 'showers', value: null },
    { name: 'Smoking Area', icon: CigaretteIcon, key: 'smoking', value: null },
    { name: 'Alcohol', icon: BeerIcon, key: 'alcohol', value: null },
    { name: 'Network Connection', icon: NetworkIcon, key: 'network_mbps', value: null },
    { name: 'Internet Connection', icon: NetworkIcon, key: 'internet_mbps', value: null },
  ]

  data.forEach((facility) => {
    if (props.event[facility.key]) {
      if (typeof props.event[facility.key] === 'number') {
        facility.value =
          props.event[facility.key] !== undefined && props.event[facility.key] !== null
            ? props.event[facility.key]?.toString() + 'Mbps'
            : 'Not Available'
      } else {
        // @ts-expect-error - We know this is a string
        facility.value = useCapitalizeEachWord(props.event[facility.key]?.split('_')?.join(' '))
      }
    } else {
      facility.value = 'Not Available'
    }
  })

  return data
})

const markerOptions = computed(() => {
  const eventContent = document.createElement('div')
  eventContent.classList.add('map-marker')

  const eventFlag = document.createElement('img')
  eventFlag.src = props.event.organiser?.favicon?.url ?? ''

  eventContent.appendChild(eventFlag)

  return {
    position: { lat: props.event.venue?.lat ?? 0, lng: props.event.venue?.lng ?? 0 },
    content: eventContent,
    title: props.event.title,
  }
})

const zoom = ref(10)

const googleAPIKey = import.meta.env.VITE_GOOGLE_MAPS_API_KEY
const googleMapId = import.meta.env.VITE_GOOGLE_MAPS_MAP_ID

const googleMapsLink = computed(
  () =>
    `https://www.google.com/maps/place/${props.event.venue?.lat},${props.event.venue?.lng}/@${props.event.venue?.lat},${props.event.venue?.lng},15z`,
)
</script>

<template>
  <div itemscope itemtype="https://schema.org/Event">
    <AppHead
      :title="`Event: ${event.organiser?.title} - ${event.title}`"
      :thumbnail="ogImage ?? undefined"
      :image-width="ogImage ? '1200' : undefined"
      :image-height="ogImage ? '630' : undefined"
    />

    <HeaderSection :image="event.banner?.url">
      <h2 class="mb-4 text-5xl font-semibold tracking-tight text-white sm:text-7xl">
        {{ event.title }}
      </h2>
      <p class="font-medium text-gray-300">
        {{ useDayJs(event.start_date).format(useUserDateFormat) }} -
        {{ useDayJs(event.end_date).format(useUserDateFormat) }}
      </p>
    </HeaderSection>

    <div class="mx-auto mt-12 max-w-2xl lg:max-w-7xl">
      <div class="grid grid-cols-1 space-y-4 sm:grid-cols-3 sm:space-x-4">
        <div class="space-y-4 sm:col-span-2">
          <Panel title="Event Information & Location">
            <template #content>
              <meta itemprop="image" :content="ogImage ?? socialBanner" />
              <meta itemprop="eventAttendanceMode" content="OfflineEventAttendanceMode" />
              <meta itemprop="eventStatus" content="eventScheduled" />

              <div itemprop="organizer" itemscope itemtype="https://schema.org/Organization">
                <meta itemprop="legalName" content="LANList" />
                <meta itemprop="url" content="https://lanlist.info" />
                <meta itemprop="logo" content="https://lanlist.info/logo.png" />
              </div>

              <div itemprop="performer" itemscope itemtype="https://schema.org/Organization">
                <meta itemprop="legalName" content="LANList" />
                <meta itemprop="url" content="https://lanlist.info" />
                <meta itemprop="logo" content="https://lanlist.info/logo.png" />
              </div>
              <meta
                itemprop="previousStartDate"
                :content="useDayJs(event.start_date).toISOString()"
              />
              <meta itemprop="doorTime" :content="useDayJs(event.start_date).toISOString()" />

              <div itemprop="offers" itemscope itemtype="https://schema.org/AggregateOffer">
                <meta v-if="event.seats" itemprop="offerCount" :content="event.seats?.toString()" />
                <meta itemprop="url" :content="location" />
                <meta itemprop="priceCurrency" content="GBP" />
                <meta
                  v-if="event.price_in_adv"
                  itemprop="lowPrice"
                  :content="useFormatCurrency(event.price_in_adv, 'GBP', false)"
                />
                <meta
                  v-if="event.price_on_door"
                  itemprop="highPrice"
                  :content="useFormatCurrency(event.price_on_door, 'GBP', false)"
                />
                <meta
                  itemprop="availabilityEnds"
                  :content="useDayJs(event.end_date).toISOString()"
                />
                <meta itemprop="validFrom" :content="useDayJs(event.start_date).toISOString()" />
                <meta itemprop="validThrough" :content="useDayJs(event.end_date).toISOString()" />
              </div>

              <div v-if="event.blurb" class="mb-4 dark:text-gray-300" itemprop="description">
                {{ event.blurb }}
              </div>

              <div class="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                  <div class="mb-2 font-medium dark:text-white">Dates</div>
                  <div class="flex rounded border p-2 dark:border-white/15 dark:bg-gray-600">
                    <time :datetime="useDayJs(event.start_date).toISOString()" itemprop="startDate">
                      {{ useDayJs(event.start_date).format(useUserDateFormat) }}
                    </time>
                    <span class="mx-2">-</span>
                    <time :datetime="useDayJs(event.end_date).toISOString()" itemprop="endDate">
                      {{ useDayJs(event.end_date).format(useUserDateFormat) }}
                    </time>
                  </div>
                </div>

                <div>
                  <div class="mb-2 font-medium dark:text-white">Number Of Seats</div>
                  <div class="flex rounded border p-2 dark:border-white/15 dark:bg-gray-600">
                    {{ event.seats ?? 'Unknown' }}
                  </div>
                </div>

                <div class="sm:col-span-2">
                  <div class="mb-2 font-medium dark:text-white">Age Restrictions</div>
                  <div class="flex rounded border p-2 dark:border-white/15 dark:bg-gray-600">
                    {{ event.age_restrictions ?? 'Unknown' }}
                  </div>
                </div>
              </div>
              <div class="mb-4 border-b text-2xl font-bold">Facilities</div>
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div v-for="facility in facilities" :key="`facility${facility.key}`">
                  <div class="mb-2 font-medium dark:text-white">{{ facility.name }}</div>
                  <div class="flex rounded border dark:border-white/15 dark:bg-gray-600">
                    <div class="mr-2 flex items-center border-r p-2 dark:border-white/15">
                      <component :is="facility.icon" class="size-6" />
                    </div>
                    <div class="flex flex-1 items-center p-2">
                      {{ facility.value }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="my-4 border-b text-2xl font-bold">Tickets</div>
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                  <div class="mb-2 font-medium dark:text-white">On Door</div>
                  <div class="flex rounded border p-2 dark:border-white/15 dark:bg-gray-600">
                    {{
                      event.price_on_door ? useFormatCurrency(event.price_on_door) : 'Not Available'
                    }}
                  </div>
                </div>
                <div>
                  <div class="mb-2 font-medium dark:text-white">In Advance</div>
                  <div class="flex rounded border p-2 dark:border-white/15 dark:bg-gray-600">
                    {{
                      event.price_in_adv ? useFormatCurrency(event.price_in_adv) : 'Not Available'
                    }}
                  </div>
                </div>
              </div>
            </template>
          </Panel>
          <Panel title="Venue Information">
            <template #content>
              <div
                class="grid grid-cols-1 space-y-4"
                itemprop="location"
                itemscope
                itemtype="https://schema.org/Place"
              >
                <div>
                  <GoogleMap
                    :api-key="googleAPIKey"
                    :map-id="googleMapId"
                    class="z-0 h-[516px] w-full bg-gray-50"
                    :center="{ lat: event.venue?.lat ?? 0, lng: event.venue?.lng ?? 0 }"
                    :zoom
                  >
                    <AdvancedMarker :options="markerOptions" />
                  </GoogleMap>
                </div>
                <div>
                  <meta itemprop="name" :content="event.venue?.title" />
                  <div itemprop="geo" itemscope itemtype="https://schema.org/GeoCoordinates">
                    <meta itemprop="latitude" :content="event.venue?.lat?.toString()" />
                    <meta itemprop="longitude" :content="event.venue?.lng?.toString()" />
                  </div>
                  <a
                    :href="googleMapsLink"
                    class="btn-primary inline-flex w-full justify-center"
                    target="_blank"
                    rel="noopener noreferrer"
                    itemprop="url"
                  >
                    Get Directions
                  </a>
                </div>
              </div>
            </template>
          </Panel>
        </div>
        <div>
          <Panel v-if="event.organiser" title="Organiser">
            <template #content>
              <div>
                <img
                  :src="event.organiser?.logo?.url"
                  class="mx-auto h-auto max-w-[90%] object-cover"
                />
                <dl class="divide-y divide-gray-300 dark:divide-white/15">
                  <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-sm/6 font-medium text-gray-900 dark:text-white">Name</dt>
                    <dd
                      class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-300"
                    >
                      <InertiaLink
                        :href="route('organisers.show', { organiser: event.organiser.slug })"
                      >
                        {{ event.organiser?.title }}
                      </InertiaLink>
                    </dd>
                  </div>
                  <div
                    v-if="event.organiser.website"
                    class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0"
                  >
                    <dt class="text-sm/6 font-medium text-gray-900 dark:text-white">Website</dt>
                    <dd
                      class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-300"
                    >
                      <a
                        :href="event.organiser?.website"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="link"
                      >
                        {{ event.organiser?.website }}
                      </a>
                    </dd>
                  </div>
                  <div
                    v-if="event.organiser.steam_group_url"
                    class="px-4 pt-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0"
                  >
                    <dt class="text-sm/6 font-medium text-gray-900 dark:text-white">Steam Group</dt>
                    <dd
                      class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-300"
                    >
                      <a
                        :href="event.organiser?.steam_group_url"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="link"
                      >
                        {{ event.organiser?.steam_group_url }}
                      </a>
                    </dd>
                  </div>
                </dl>
              </div>
            </template>
          </Panel>
        </div>
      </div>
    </div>
  </div>
</template>
