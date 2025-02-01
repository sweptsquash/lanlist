<script lang="ts" setup>
import { DiscordIcon, TwitchIcon } from 'vue3-simple-icons'

withDefaults(defineProps<{ position?: 'top' | 'bottom' }>(), { position: 'bottom' })

const socials = computed(() => {
  const socialsEnabled = usePage().props.socials

  return [
    {
      text: 'Sign in with Discord',
      icon: DiscordIcon,
      route: route('auth.discord.redirect'),
      enabled: socialsEnabled?.discord ?? false,
    },
    {
      text: 'Sign in with Twitch',
      icon: TwitchIcon,
      route: route('auth.twitch.redirect'),
      enabled: socialsEnabled?.twitch ?? false,
    },
  ]
})
</script>

<template>
  <div
    :class="[
      'flex flex-col gap-y-6',
      {
        'mt-6': position === 'bottom',
        'mb-6': position === 'top',
        'flex-col-reverse': position === 'top',
      },
    ]"
  >
    <div class="relative">
      <div class="absolute inset-0 flex items-center">
        <div class="w-full border-t border-gray-300" />
      </div>
      <div class="relative flex justify-center text-sm">
        <span class="rounded-lg bg-white px-2 text-gray-900 dark:bg-gray-800 dark:text-gray-300">
          Or continue with
        </span>
      </div>
    </div>

    <div class="grid grid-cols-2 gap-3">
      <div v-for="(service, index) in socials" :key="`auth${index}`">
        <a
          :href="service.enabled ? service.route : undefined"
          :class="[
            'btn btn-primary inline-flex w-full justify-center',
            { disabled: !service.enabled },
          ]"
        >
          <span class="sr-only">{{ service.text }}</span>
          <component :is="service.icon" v-if="service.icon" class="h-5 w-5" />
        </a>
      </div>
    </div>
  </div>
</template>
