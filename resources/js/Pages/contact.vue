<script lang="ts" setup>
const form = useForm({
  name: null,
  email: null,
  subject: null,
  message: null,
})

const isSuccessful = ref(false)

function handleSubmit() {
  form.post(route('contact.store'), {
    preserveScroll: true,
    onSuccess: () => {
      isSuccessful.value = true
    },
  })
}
</script>

<template>
  <div>
    <AppHead title="Contact" />

    <div class="mx-auto mt-12 max-w-2xl space-y-4">
      <Panel title="Contact">
        <template #content>
          <p class="mb-4">
            Feel free to get in contact about anything. The site is maintained by
            <a href="https://jread.com/" target="_blank" rel="noopener noreferrer" class="link">
              James Read
            </a>
            .
          </p>
          <Alert v-if="isSuccessful" type="success" class="mb-4">
            <template #message>
              Thank you for reaching out to us, we'll get back to you within 2 - 3 business days.
            </template>
          </Alert>
          <form v-else class="space-y-6" @submit.prevent="handleSubmit">
            <TextInput
              id="name"
              v-model="form.name"
              label="Name"
              required
              :is-valid="!form.errors.name"
              :error="form.errors.name"
            />
            <EmailInput
              id="email"
              v-model="form.email"
              label="Email"
              required
              :is-valid="!form.errors.email"
              :error="form.errors.email"
            />
            <TextInput
              id="subject"
              v-model="form.subject"
              label="Subject"
              required
              :is-valid="!form.errors.subject"
              :error="form.errors.subject"
            />
            <TextareaInput
              id="message"
              v-model="form.message"
              label="Message"
              :rows="10"
              required
              :is-valid="!form.errors.message"
              :error="form.errors.message"
            />
            <button type="submit" class="btn-primary w-full text-center">Send</button>
          </form>
        </template>
      </Panel>
    </div>
  </div>
</template>
