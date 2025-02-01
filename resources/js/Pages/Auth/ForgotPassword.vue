<script lang="ts" setup>
withDefaults(defineProps<{ status: string | null }>(), { status: null })

const form = useForm({ email: null })

function submit() {
  form.post(route('auth.password.email'))
}
</script>

<template>
  <div
    class="relative flex h-[calc(100vh-300px)] w-full flex-1 items-center justify-center sm:h-[calc(100vh-460px)]"
  >
    <AppHead title="Forgot your password?" />

    <div class="z-10 min-w-[320px] sm:min-w-[420px]">
      <h2 class="mt-8 text-center font-bold text-gray-900 dark:text-white">
        Forgot your password?
      </h2>
      <Panel class="mt-4">
        <template #content>
          <form class="space-y-6" @submit.prevent="submit">
            <Alert v-if="status" type="success">
              <template #message>
                <p>{{ status }}</p>
              </template>
            </Alert>

            <EmailInput
              id="email"
              v-model="form.email"
              name="email"
              label="Email"
              autocomplete="email"
              required
              :is-valid="!form.errors.email"
              :error="form.errors.email"
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
                Email Password Reset Link
              </button>
            </div>
          </form>
        </template>
      </Panel>
    </div>
  </div>
</template>
