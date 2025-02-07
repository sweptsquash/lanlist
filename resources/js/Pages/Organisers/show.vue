<script lang="ts" setup>
import { pickBy } from 'lodash'
import qs from 'qs'

const props = defineProps<{ organiser: App.Organiser }>()

function moreEvents() {
  const query = { filter: { organiser_title: props.organiser.title }, sort: '-start_date' }

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
    <AppHead :title="organiser.title" />

    <HeaderSection>
      <h2 class="mb-4 text-5xl font-semibold tracking-tight text-white sm:text-7xl">
        {{ organiser.title }}
      </h2>
    </HeaderSection>

    <div class="mx-auto mt-12 max-w-2xl space-y-4 lg:max-w-7xl">
      <Panel title="Organiser Details">
        <template #content>
          <!-- TODO -->
          <img
            src="https://lanlist.info/resources/images/organizer-logos/329.jpg"
            class="mx-auto mb-6 h-auto max-w-full object-cover sm:max-w-[40%]"
          />

          <div v-if="organiser.blurb" class="mb-4 dark:text-gray-300">
            {{ organiser.blurb }}
          </div>

          <div class="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
              <div class="mb-2 font-medium dark:text-white">Website</div>
              <div class="flex rounded border p-2 dark:border-white/15 dark:bg-gray-600">
                <a v-if="organiser.website" :href="organiser.website" class="link">
                  {{ organiser.website }}
                </a>
              </div>
            </div>
            <div>
              <div class="mb-2 font-medium dark:text-white">Steam Group</div>
              <div
                class="flex max-w-full overflow-hidden rounded border p-2 text-ellipsis dark:border-white/15 dark:bg-gray-600"
              >
                <a v-if="organiser.steam_group_url" :href="organiser.steam_group_url" class="link">
                  {{ organiser.steam_group_url }}
                </a>
              </div>
            </div>
          </div>
        </template>
      </Panel>
      <Panel title="Upcoming Events">
        <template #content>
          <div
            v-if="organiser.events === undefined || organiser.events?.length === 0"
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
                      Venue
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
                    v-for="(event, index) in organiser.events"
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
                        v-if="event.venue"
                        :href="route('venues.show', { venue: event.venue?.slug })"
                        class="link"
                      >
                        {{ event.venue?.title ?? 'N/A' }}
                      </InertiaLink>
                      <span v-else>N/A</span>
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
