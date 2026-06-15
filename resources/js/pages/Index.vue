<script setup lang="ts">
import lanEvent from '@/../images/lan-event.jpeg'

const upcomingEvents = ref([
    {
        title: 'Insomnia Gaming Festival',
        image: lanEvent,
        location: 'Birmingham, UK',
        startDate: '23/08/2026',
        endDate: '26/08/2026',
        seats: {
            available: 1500,
            total: 2000,
        },
        ticketsAvailable: true,
    },
    {
        title: 'Insomnia Gaming Festival',
        image: lanEvent,
        location: 'Birmingham, UK',
        startDate: '23/08/2026',
        endDate: '26/08/2026',
        seats: {
            available: 1500,
            total: 2000,
        },
        ticketsAvailable: true,
    },
    {
        title: 'Insomnia Gaming Festival',
        image: lanEvent,
        location: 'Birmingham, UK',
        startDate: '23/08/2026',
        endDate: '26/08/2026',
        seats: {
            available: 1500,
            total: 2000,
        },
        ticketsAvailable: true,
    },
    {
        title: 'Insomnia Gaming Festival',
        image: lanEvent,
        location: 'Birmingham, UK',
        startDate: '23/08/2026',
        endDate: '26/08/2026',
        seats: {
            available: 1500,
            total: 2000,
        },
        ticketsAvailable: true,
    }
])
</script>

<template>
    <div>
        <header
            class="relative isolate overflow-hidden bg-linear-to-b from-indigo-100/20 dark:from-indigo-950/10"
        >
            <div
                class="mx-auto max-w-7xl pt-10 pb-24 sm:pb-32 lg:grid lg:grid-cols-2 lg:gap-x-8 lg:px-8 lg:py-10"
            >
                <div class="px-6 lg:px-0">
                    <div class="mx-auto max-w-2xl">
                        <div class="max-w-lg">
                            <div class="mt-24 sm:mt-32 lg:mt-16">
                                <a href="#" class="inline-flex space-x-6">
                                    <span
                                        class="rounded-full bg-indigo-50 px-3 py-1 text-sm/6 font-semibold text-indigo-600 ring-1 ring-indigo-600/20 ring-inset dark:bg-indigo-500/10 dark:text-indigo-400 dark:ring-indigo-500/25"
                                    >
                                        The Global Directory
                                    </span>
                                </a>
                            </div>
                            <h1
                                class="mt-10 text-5xl font-semibold tracking-tight text-pretty text-gray-900 sm:text-7xl dark:text-white"
                            >
                                Find LAN tournaments
                                <span class="text-blue-500">anywhere in the world.</span>
                            </h1>
                            <p
                                class="mt-8 text-lg font-medium text-pretty text-gray-500 sm:text-xl/8 dark:text-gray-400"
                            >
                                Discover, compare and book LAN events and tournments worldwide.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-20 sm:mt-24 md:mx-auto md:max-w-2xl lg:mx-0 lg:mt-0 lg:w-screen">
                    <div
                        aria-hidden="true"
                        class="absolute inset-y-0 right-1/2 -z-10 -mr-10 w-[200%] skew-x-[-30deg] bg-white shadow-xl ring-1 shadow-indigo-600/10 ring-indigo-50 md:-mr-20 lg:-mr-36 dark:bg-gray-800/30 dark:shadow-indigo-400/10 dark:ring-white/5"
                    ></div>
                    <div>
                        <PixelMap />
                    </div>
                </div>
            </div>
            <div
                class="absolute inset-x-0 bottom-0 -z-10 h-24 bg-linear-to-t from-white sm:h-32 dark:from-gray-900"
            ></div>
        </header>
        <section class="py-4 space-y-4">
            <div class="flex flex-row justify-between items-center">
                <div>
                    <h2>Upcoming Events</h2>
                </div>
                <div>
                    <UButton
                        label="View All"
                        color="neutral"
                        variant="ghost"
                        trailing-icon="i-lucide-arrow-right"
                        :ui="{ trailingIcon: 'text-dimmed ms-auto' }"
                    />
                </div>
            </div>

            <div class="grid grid-cols-4 gap-4">
                <UCard v-for="event in upcomingEvents" :key="event.title" :ui="{ body: '!p-0' }">
                    <div class="relative">
                        <img class="object-cover" :src="event.image" />
                        <div class="p-4 sm:p-6 absolute inset-0">
                            <UBadge color="warning">Ending soon</UBadge>
                        </div>
                    </div>

                    <template #footer>
                        <div class="space-y-1">
                        <div>{{ event.title }}</div>
                        <p class="text-sm text-dimmed">{{ event.location }}</p>
                        <p class="text-dimmed text-sm">{{ event.startDate}} - {{ event.endDate }}</p>
                        <div class="flex flex-row justify-between items-center space-4 text-sm">
                            <div>{{ event.seats.available }} / {{ event.seats.total }}</div>
                            <UBadge>{{ event.ticketsAvailable ? 'Tickets Available' : 'Sold Out'}}</UBadge>
                        </div></div>
                    </template>
                </UCard>
            </div>
        </section>
    </div>
</template>
