<script lang="ts" setup>
defineProps<{ timezones: { id: string; name: string }[]; countries: App.Country[] }>()

const status = computed(() => usePage().props.notification?.body)

const statusType = computed(() =>
  usePage().props.notification?.type === 'error' ? 'danger' : 'success',
)

const dateFormats = computed(() =>
  $constants.dateFormats.map((dateFormat) => {
    return { name: useDayJs().format(dateFormat.js), value: dateFormat.php }
  }),
)

const form = useForm(() => ({
  username: useUser.value?.username ?? null,
  email: useUser.value?.email ?? null,
  country: useUser.value?.country?.id ?? null,
  date_format: useUser.value?.date_format ?? null,
  timezone: useUser.value?.timezone ?? null,
}))

function updateAccount() {
  form.put(route('account.update'), {
    preserveState: false,
    onSuccess: () => form.reset(),
  })
}
</script>

<template>
  <div>
    <AppHead title="Account Details" />

    <div class="mx-auto mt-12 max-w-2xl space-y-4 lg:max-w-7xl">
      <AccountTabs />

      <Panel title="Account Details">
        <template #content>
          <Alert v-if="status" :type="statusType" class="mb-6">
            <template #message>
              <p>{{ status }}</p>
            </template>
          </Alert>

          <form class="grid grid-cols-1 gap-4 sm:grid-cols-2" @submit.prevent="updateAccount">
            <TextInput id="username" v-model="form.username" label="Username" disabled />
            <EmailInput
              id="email"
              v-model="form.email"
              label="Email"
              required
              :is-valid="!form.errors.email"
              :error="form.errors.email"
            />
            <SelectInput
              id="country"
              v-model="form.country"
              name="country"
              label="Country"
              value-prop="id"
              label-prop="name"
              :options="countries"
              :is-valid="!form.errors.country"
              :error="form.errors.country"
            />
            <SelectInput
              id="timezones"
              v-model="form.timezone"
              name="timezones"
              label="Timezones"
              :options="timezones"
              :is-valid="!form.errors.timezone"
              :error="form.errors.timezone"
            />
            <SelectInput
              id="date_format"
              v-model="form.date_format"
              name="date_format"
              label="Date Format"
              :options="dateFormats"
              value-prop="value"
              :is-valid="!form.errors.date_format"
              :error="form.errors.date_format"
            />

            <div class="sm:col-span-2">
              <button
                type="submit"
                :class="[
                  'btn-primary flex w-full justify-center',
                  { 'opacity-25': form.processing },
                ]"
                :disabled="form.processing"
              >
                <IconLoading v-if="form.processing" class="mr-2 h-5 w-5 animate-spin text-white" />
                Update
              </button>
            </div>
          </form>
        </template>
      </Panel>
    </div>
  </div>
</template>
