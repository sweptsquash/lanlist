<script lang="ts" setup>
const props = defineProps<{ countries: App.Country[] }>()

const form = useForm(() => ({
  username: null,
  email: null,
  password: null,
  password_confirmation: null,
  country: props.countries.find((country) => country.code === 'GB')?.id ?? null,
  terms: false,
}))

function submit() {
  form.post(route('auth.register'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  })
}
</script>

<template>
  <div
    class="relative flex h-[calc(100vh-300px)] w-full flex-1 items-center justify-center sm:h-[calc(100vh-460px)]"
  >
    <AppHead title="Register" />

    <div class="z-10 min-w-[320px] sm:min-w-[420px]">
      <h2 class="mt-8 text-center font-bold text-gray-900 dark:text-white">
        Register your account
      </h2>
      <p class="mt-2 text-center text-sm text-gray-900 dark:text-gray-300">
        Or
        {{ ' ' }}
        <InertiaLink
          :href="route('auth.login')"
          class="font-medium text-indigo-600 hover:text-indigo-500 hover:underline dark:text-gray-200 dark:hover:text-white"
        >
          sign in to your account
        </InertiaLink>
      </p>

      <Panel class="my-4">
        <template #content>
          <form class="space-y-6" @submit.prevent="submit">
            <TextInput
              id="username"
              v-model="form.username"
              label="Username"
              autocomplete="username"
              placeholder="Username"
              required
              :is-valid="!form.errors.username"
              :error="form.errors.username"
            />

            <EmailInput
              id="email"
              v-model="form.email"
              label="Email"
              autocomplete="email"
              placeholder="Email"
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
              placeholder="••••••••"
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
              placeholder="••••••••"
              required
              :is-valid="!form.errors.password_confirmation"
              :error="form.errors.password_confirmation"
            />

            <SelectInput
              id="country"
              v-model="form.country"
              name="country"
              label="Country"
              label-prop="name"
              value-prop="id"
              :can-clear="false"
              :can-deselect="false"
              searchable
              :options="countries"
              :is-valid="!form.errors.country"
              :error="form.errors.country"
            />

            <CheckBox
              id="terms"
              v-model="form.terms"
              name="terms"
              required
              label="I accept the terms and privacy policy "
              :is-valid="!form.errors.terms"
              :error="form.errors.terms"
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
                Register
              </button>
            </div>
          </form>
        </template>
      </Panel>
    </div>
  </div>
</template>
