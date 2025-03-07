<script lang="ts" setup>
defineProps<{ organisers: App.Organiser[] }>()

const status = computed(() => usePage().props.notification?.body)

const statusType = computed(() =>
  usePage().props.notification?.type === 'error' ? 'danger' : 'success',
)

const form = useForm<{
  title: string | null
  website: string | null
  steam_group_url: string | null
  blurb: string | null
}>({
  title: null,
  website: null,
  steam_group_url: null,
  blurb: null,
})

function createOrganisation() {
  form.post(route('account.organisation.join.store'), {
    preserveState: false,
    onSuccess: () => {
      form.reset()

      setTimeout(() => {
        router.visit(route('account.organisation.index'))
      }, 2000)
    },
  })
}
</script>

<template>
  <div>
    <AppHead title="Account Organisation" />

    <div class="mx-auto mt-12 max-w-2xl space-y-4 lg:max-w-7xl">
      <AccountTabs />

      <Panel title="Create An Organisation">
        <template #content>
          <Alert type="info">
            <template #message>
              This will not appear in the organisers list immidiately, it will first have to be
              approved by one of our smiling friendly admins - they accept bribes in the form of
              cake.
            </template>
          </Alert>

          <Alert v-if="status" :type="statusType" class="mb-6">
            <template #message>
              <p>{{ status }}</p>
            </template>
          </Alert>

          <form v-else class="mt-4 grid grid-cols-1 gap-4" @submit.prevent="createOrganisation">
            <TextInput
              id="title"
              v-model="form.title"
              name="title"
              label="Organisation Title"
              :is-valid="!form.errors.title"
              :error="form.errors.title"
              required
            />

            <TextInput
              id="website"
              v-model="form.website"
              name="website"
              label="Website"
              :is-valid="!form.errors.website"
              :error="form.errors.website"
            >
              <template #helperText>
                This is the URL to your LAN Parties website, if you have one.
              </template>
            </TextInput>

            <TextInput
              id="steam_group_url"
              v-model="form.steam_group_url"
              name="steam_group_url"
              label="Steam Group URL"
              :is-valid="!form.errors.steam_group_url"
              :error="form.errors.steam_group_url"
            >
              <template #helperText>This is the URL to your steam group, if you have one.</template>
            </TextInput>

            <TextareaInput
              id="blurb"
              v-model="form.blurb"
              name="blurb"
              label="Blurb"
              :is-valid="!form.errors.blurb"
              :error="form.errors.blurb"
              required
              :rows="10"
            >
              <template #helperText>
                A blurb describes the organiser, prehaps the year you started, how experienced you
                are, or if you like cake. Its best to leave event specific information to when you
                go to create events.
              </template>
            </TextareaInput>

            <!-- TODO: LOGO IMAGE UPLOAD -->
            <FileInput id="logo" label="Logo" caption="Upload a logo for your organisation" />

            <button
              type="submit"
              :class="['btn-primary flex w-full justify-center', { 'opacity-25': form.processing }]"
              :disabled="form.processing"
            >
              <IconLoading v-if="form.processing" class="mr-2 h-5 w-5 animate-spin text-white" />
              Create Organisation
            </button>
          </form>
        </template>
      </Panel>
    </div>
  </div>
</template>
