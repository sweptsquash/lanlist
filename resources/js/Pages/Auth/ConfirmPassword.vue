<script lang="ts" setup>
const form = useForm({ password: null })

function submit() {
  form.post(route('password.confirm'), {
    onFinish: () => form.reset(),
  })
}
</script>

<template>
  <div
    class="relative flex h-[calc(100vh-300px)] w-full flex-1 items-center justify-center sm:h-[calc(100vh-460px)]"
  >
    <AppHead title="Confirm your password" />

    <div class="z-10 min-w-[320px] sm:min-w-[420px]">
      <h2 class="mt-8 text-center font-bold text-gray-900 dark:text-white">
        Confirm your password
      </h2>
      <p class="mt-2 text-center text-sm text-gray-900 dark:text-gray-300">
        This is a secure area of the application. Please confirm your password before continuing.
      </p>

      <Panel class="my-4">
        <template #content>
          <form class="space-y-6" @submit.prevent="submit">
            <PasswordInput
              id="password"
              v-model="form.password"
              name="password"
              label="Password"
              type="password"
              autocomplete="current-password"
              required
              :is-valid="!form.errors.password"
              :error="form.errors.password"
            />

            <div>
              <button
                type="submit"
                :class="[
                  'btn-primary flex w-full justify-center',
                  { 'opacity-25': form.processing },
                ]"
                :disabled="form.processing"
              >
                <IconLoading v-if="form.processing" class="mr-2 h-5 w-5 animate-spin text-white" />
                Confirm
              </button>
            </div>
          </form>
        </template>
      </Panel>
    </div>
  </div>
</template>
