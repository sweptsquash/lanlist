<script lang="ts" setup>
const props = withDefaults(
  defineProps<{
    token: string | null
    email: string | null
  }>(),
  {
    token: null,
    email: null,
  },
)

const form = useForm({
  token: props.token,
  email: props.email,
  password: null,
  password_confirmation: null,
})

function submit() {
  form.post(route('auth.password.update'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  })
}
</script>

<template>
  <div
    class="relative flex h-[calc(100vh-300px)] w-full flex-1 items-center justify-center sm:h-[calc(100vh-460px)]"
  >
    <AppHead title="Reset password" />

    <div class="z-10 min-w-[320px] sm:min-w-[420px]">
      <h2 class="mt-8 text-center font-bold text-gray-900 dark:text-white">Reset Password</h2>

      <Panel class="my-4">
        <template #content>
          <form class="space-y-6" @submit.prevent="submit">
            <input id="token" v-model="form.token" name="token" type="hidden" />

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

            <PasswordInput
              id="password"
              v-model="form.password"
              name="password"
              label="Password"
              autocomplete="new-password"
              required
              :is-valid="!form.errors.password"
              :error="form.errors.password"
            />

            <PasswordInput
              id="password_confirmation"
              v-model="form.password_confirmation"
              name="password_confirmation"
              label="Confirm Password"
              autocomplete="new-password"
              required
              :is-valid="!form.errors.password_confirmation"
              :error="form.errors.password_confirmation"
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
                Reset Password
              </button>
            </div>
          </form>
        </template>
      </Panel>
    </div>
  </div>
</template>
