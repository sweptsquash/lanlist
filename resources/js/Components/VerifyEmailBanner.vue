<script lang="ts" setup>
let hideResend = ref(false)
</script>

<template>
  <div class="relative bg-yellow-600">
    <div class="mx-auto max-w-7xl px-3 py-3 sm:px-6 lg:px-8">
      <div class="pr-16 sm:px-16 sm:text-center">
        <p class="font-medium text-white">
          <span class="inline">Please check your inbox and verify your email.</span>
          <span v-if="!hideResend" class="block sm:ml-2 sm:inline-block">
            <InertiaLink
              :href="route('verification.send')"
              method="post"
              as="button"
              class="font-bold text-white underline"
              @click="hideResend = true"
            >
              Resend verification email
            </InertiaLink>
          </span>
        </p>
      </div>
    </div>
  </div>
</template>
