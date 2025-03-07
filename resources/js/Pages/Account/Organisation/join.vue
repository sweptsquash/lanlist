<script lang="ts" setup>
defineProps<{ organisers: App.Organiser[] }>()

const status = computed(() => usePage().props.notification?.body)

const statusType = computed(() =>
  usePage().props.notification?.type === 'error' ? 'danger' : 'success',
)

const form = useForm<{ organisation: number | null; comments: string | null }>({
  organisation: null,
  comments: null,
})

function joinOrganisation() {
  form.post(route('account.organisation.join.store'), {
    preserveState: false,
    onSuccess: () => form.reset(),
  })
}
</script>

<template>
  <div>
    <AppHead title="Account Organisation" />

    <div class="mx-auto mt-12 max-w-2xl space-y-4 lg:max-w-7xl">
      <AccountTabs />

      <Panel title="Join A Organisation">
        <template #content>
          <Alert type="info">
            <template #message>
              This will send a request to an administrator for you to join onto a LAN Party
              Organiser. We approve these manaully, but we will do it as quickly as possible.
            </template>
          </Alert>

          <Alert v-if="status" :type="statusType" class="mb-6">
            <template #message>
              <p>{{ status }}</p>
            </template>
          </Alert>

          <form v-else class="mt-4 grid grid-cols-1 gap-4" @submit.prevent="joinOrganisation">
            <SelectInput
              id="organisation"
              v-model="form.organisation"
              name="organisation"
              label="Organisation"
              value-prop="id"
              label-prop="title"
              :options="organisers"
              :is-valid="!form.errors.organisation"
              :error="form.errors.organisation"
              required
              searchable
            />
            <TextareaInput id="comments" v-model="form.comments" label="Comments" :rows="10" />
            <button
              type="submit"
              :class="['btn-primary flex w-full justify-center', { 'opacity-25': form.processing }]"
              :disabled="form.processing"
            >
              <IconLoading v-if="form.processing" class="mr-2 h-5 w-5 animate-spin text-white" />
              Send Request
            </button>
          </form>
        </template>
      </Panel>
    </div>
  </div>
</template>
