<script lang="ts" setup>
import { DiscordIcon, TwitchIcon } from 'vue3-simple-icons'

const socialsEnabled = computed(() => usePage().props.socials)

const isDisconnectionModalOpen = ref(false)

const data = reactive<{
  selectedService: App.ConnectionService | null
}>({ selectedService: null })

const services = computed<App.ConnectionService[]>(() => [
  {
    name: 'Discord',
    icon: DiscordIcon,
    route: route('auth.discord.redirect'),
    enabled: socialsEnabled.value.discord ?? false,
    connected: useUser.value?.discord_id !== null,
    color: '5865f2',
  },
  {
    name: 'Twitch',
    icon: TwitchIcon,
    route: route('auth.twitch.redirect'),
    enabled: socialsEnabled.value.twitch ?? false,
    connected: useUser.value?.twitch_id !== null,
    color: '9146ff',
  },
])

function serviceConnection(service: App.ConnectionService) {
  if (service.enabled) {
    if (service.connected) {
      data.selectedService = service
      isDisconnectionModalOpen.value = true
    } else {
      window.location.href = service.route
    }
  }
}

function confirmDisconnection() {
  useForm({ service: data.selectedService?.name }).delete(route('account.connections.destroy'), {
    onSuccess: () => cancelDisconnection(),
  })
}

function cancelDisconnection() {
  setTimeout(() => (data.selectedService = null), 500)
  isDisconnectionModalOpen.value = false
}
</script>

<template>
  <div>
    <AppHead title="Account Connections" />

    <div class="mx-auto mt-12 max-w-2xl space-y-4 lg:max-w-7xl">
      <AccountTabs />

      <Panel title="Account Connections" subtitle="Connect your social accounts">
        <template #content>
          <div class="space-y-4">
            <div
              v-for="(service, index) in services"
              :key="`service${index}`"
              class="flex flex-row rounded border border-gray-500 p-4 shadow-md"
              :class="{ 'cursor-not-allowed opacity-50': !service.enabled }"
            >
              <div class="mr-4 flex items-center justify-center">
                <div
                  class="flex h-20 w-20 items-center justify-center rounded bg-gray-500"
                  :style="`background-color: #${service.color} !important`"
                >
                  <component :is="service.icon" v-if="service.icon" class="h-8 w-8 text-white" />
                </div>
              </div>
              <div>
                <div class="mb-4 flex flex-row items-center justify-between">
                  <div>
                    <p class="text-lg font-bold">{{ service.name }}</p>
                    <p v-if="service.connected" class="text-green-500">
                      <CheckCircleIcon class="-mt-0.5 inline-block h-5 w-5" />
                      Your {{ service.name }} account is connected.
                    </p>
                  </div>
                  <div>
                    <button
                      :class="[
                        'btn',
                        {
                          'btn-primary': !service.connected,
                          'btn-danger': service.connected,
                          disabled: !service.enabled,
                        },
                      ]"
                      type="button"
                      @click.prevent="serviceConnection(service)"
                    >
                      {{ service.connected ? 'Disconnect' : 'Connect' }}
                    </button>
                  </div>
                </div>
                <p class="text-sm">
                  By connecting your account with your {{ service.name }} account, you acknowledge
                  and agree that information you choose to share will be uploaded to
                  {{ service.name }} and may be viewed by {{ service.name }} and other
                  {{ service.name }} users. Also, your {{ service.name }} account information may be
                  used by LANList. LANList will not publicly display your {{ service.name }} account
                  information. If you no longer want to share this information, please disconnect
                  your {{ service.name }} account.
                </p>
              </div>
            </div>
          </div>
        </template>
      </Panel>

      <ModalConfirm
        type="danger"
        :is-open="isDisconnectionModalOpen"
        title="Delete account"
        :message="`Are you sure you want to disconnect your ${data.selectedService?.name} account from your LANList account?`"
        action-text="Yes, Disconnect"
        cancel-text="No, Cancel"
        action-class="btn-danger"
        @action="confirmDisconnection"
        @close="cancelDisconnection"
      />
    </div>
  </div>
</template>
