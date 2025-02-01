<script lang="ts" setup>
import socialBanner from '@/../images/social-banner.png'

defineProps<{ event: App.Event; ogImage: string | null }>()
</script>

<template>
  <div itemscope itemtype="https://schema.org/Event">
    <AppHead
      :title="`Event: ${event.organiser?.title} - ${event.title}`"
      :thumbnail="ogImage ?? undefined"
      :image-width="ogImage ? '1200' : undefined"
      :image-height="ogImage ? '630' : undefined"
    />

    <HeaderSection>
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

              <div></div>
            </template>
          </Panel>
          <Panel></Panel>
        </div>
        <Panel title="Organiser">
          <template #content>
            <div></div>
          </template>
        </Panel>
      </div>
    </div>
  </div>
</template>
