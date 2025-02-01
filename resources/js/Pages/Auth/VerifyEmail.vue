<script lang="ts" setup>
const props = withDefaults(defineProps<{ status: string | null }>(), { status: null })

const verificationLinkSent = computed(() => props.status === 'verification-link-sent')

const form = useForm({})

function submit() {
  form.post(route('verification.send'))
}
</script>

<template>
  <div
    class="relative flex h-[calc(100vh-300px)] w-full flex-1 items-center justify-center sm:h-[calc(100vh-460px)]"
  >
    <AppHead title="Email Verification" />

    <div class="z-10 min-w-[320px] sm:min-w-[420px]">
      <h2 class="mt-8 text-center font-bold text-gray-900 dark:text-white">Email Verification</h2>

      <Panel class="my-4">
        <template #content>
          <form class="space-y-6" @submit.prevent="submit">
            <Alert type="info">
              <template #message>
                <p>
                  Thanks for signing up! Before getting started, could you verify your email address
                  by clicking on the link we just emailed to you? If you didn't receive the email,
                  we will gladly send you another.
                </p>
              </template>
            </Alert>

            <Alert v-if="verificationLinkSent" type="success">
              <template #message>
                <p>
                  A new verification link has been sent to the email address you provided during
                  registration.
                </p>
              </template>
            </Alert>

            <div class="mt-4 flex items-center justify-between">
              <button
                type="submit"
                :class="['btn-primary flex justify-center', { 'opacity-25': form.processing }]"
                :disabled="form.processing"
              >
                <IconLoading v-if="form.processing" class="mr-2 h-5 w-5 animate-spin text-white" />
                Resend Verification Email
              </button>
              <InertiaLink :href="route('logout')" method="post" as="button" class="btn-primary">
                Log Out
              </InertiaLink>
            </div>
          </form>
        </template>
      </Panel>
    </div>
  </div>
</template>
