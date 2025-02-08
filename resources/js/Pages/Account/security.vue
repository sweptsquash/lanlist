<script lang="ts" setup>
const status = computed(() => usePage().props.notification?.body)

const statusType = computed(() =>
  usePage().props.notification?.type === 'error' ? 'danger' : 'success',
)

const passwordForm = useForm<{
  current_password: string | null
  new_password: string | null
  new_password_confirmation: string | null
}>({
  current_password: null,
  new_password: null,
  new_password_confirmation: null,
})

function updatePassword() {
  passwordForm.put(route('account.security.update'), {
    onSuccess: () => passwordForm.reset(),
  })
}
</script>

<template>
  <div>
    <AppHead title="Account Security" />

    <div class="mx-auto mt-12 max-w-2xl space-y-4 lg:max-w-7xl">
      <AccountTabs />

      <Panel title="Account Security" subtitle="Update your account password.">
        <template #content>
          <Alert v-if="status" :type="statusType" class="mb-6">
            <template #message>
              <p>{{ status }}</p>
            </template>
          </Alert>

          <form class="space-y-6">
            <PasswordInput
              id="current_password"
              v-model="passwordForm.current_password"
              name="current_password"
              label="Current Password"
              autocomplete="current-password"
              required
              :is-valid="!passwordForm.errors.current_password"
              :error="passwordForm.errors.current_password"
            />

            <PasswordInput
              id="new_password"
              v-model="passwordForm.new_password"
              name="new_password"
              label="New Password"
              autocomplete="new-password"
              required
              :is-valid="!passwordForm.errors.new_password"
              :error="passwordForm.errors.new_password"
            />

            <PasswordInput
              id="new_password_confirmation"
              v-model="passwordForm.new_password_confirmation"
              name="new_password_confirmation"
              label="Confirm New Password"
              autocomplete="new-password"
              required
              :is-valid="!passwordForm.errors.new_password_confirmation"
              :error="passwordForm.errors.new_password_confirmation"
            />

            <button
              type="submit"
              :class="[
                'btn-primary flex w-full justify-center',
                { 'opacity-25': passwordForm.processing },
              ]"
              :disabled="passwordForm.processing"
              @click.prevent="updatePassword"
            >
              <IconLoading
                v-if="passwordForm.processing"
                class="mr-2 h-5 w-5 animate-spin text-white"
              />
              Update
            </button>
          </form>
        </template>
      </Panel>
    </div>
  </div>
</template>
