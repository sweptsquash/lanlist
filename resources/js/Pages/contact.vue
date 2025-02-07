<script lang="ts" setup>
const form = useForm({
  name: null,
  email: null,
  subject: null,
  message: null,
})

// TODO Has Error

// TODO Was Successful

function handleSubmit() {
  // TODO Submit
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
          <Alert type="danger" class="mb-4">
            <template #message>Testing</template>
          </Alert>
          <form class="space-y-6" @submit.prevent="handleSubmit">
            <TextInput id="name" v-model="form.name" label="Name" required />
            <EmailInput id="email" v-model="form.email" label="Email" required />
            <TextInput id="subject" v-model="form.subject" label="Subject" required />
            <TextareaInput
              id="message"
              v-model="form.message"
              label="Message"
              :rows="10"
              required
            />
            <button type="submit" class="btn-primary w-full text-center">Send</button>
          </form>
        </template>
      </Panel>
    </div>
  </div>
</template>
