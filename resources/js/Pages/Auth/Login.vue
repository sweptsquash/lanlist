<script lang="ts" setup>
const form = useForm({
  username: null,
  password: null,
  remember: false,
})

function submit() {
  form.post(route('auth.login'))
}
</script>

<template>
  <div
    class="relative flex h-[calc(100vh-300px)] w-full flex-1 items-center justify-center sm:h-[calc(100vh-460px)]"
  >
    <AppHead title="Login" />

    <div class="z-10 min-w-[320px] sm:min-w-[420px]">
      <h2 class="mt-8 text-center font-bold text-gray-900 dark:text-white">
        Sign in to your account
      </h2>
      <p class="mt-2 text-center text-sm text-gray-900 dark:text-gray-300">
        Or
        {{ ' ' }}
        <InertiaLink
          :href="route('auth.register')"
          class="font-medium text-indigo-600 hover:text-indigo-500 hover:underline dark:text-gray-200 dark:hover:text-white"
        >
          register today
        </InertiaLink>
      </p>

      <Panel class="my-4">
        <template #content>
          <form class="space-y-6" @submit.prevent="submit">
            <TextInput
              id="username"
              v-model="form.username"
              label="Username or Email"
              autocomplete="email"
              placeholder="Username or Email"
              required
              :is-valid="!form.errors.username"
              :error="form.errors.username"
            />

            <PasswordInput
              id="password"
              v-model="form.password"
              label="Password"
              autocomplete="current-password"
              placeholder="••••••••"
              required
              :is-valid="!form.errors.password"
              :error="form.errors.password"
            />

            <div
              class="flex flex-col items-center justify-between space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4"
            >
              <CheckBox id="remember" v-model="form.remember" name="remember" label="Remember me" />

              <div class="text-sm">
                <InertiaLink
                  :href="route('auth.password.request')"
                  class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-gray-200 dark:hover:text-white"
                >
                  Forgot your password?
                </InertiaLink>
              </div>
            </div>

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
                Sign in
              </button>
            </div>
          </form>
        </template>
      </Panel>

      <SocialAuth />
    </div>
  </div>
</template>
