<script lang="ts" setup>
defineProps<{ organiser: App.Organiser | null }>()
</script>

<template>
  <div>
    <AppHead title="Account Organisation" />

    <div class="mx-auto mt-12 max-w-2xl space-y-4 lg:max-w-7xl">
      <AccountTabs />

      <OrganisationTabs v-if="useUser?.organiser" />

      <Panel v-if="!organiser" title="Organisation">
        <template #content>
          <div
            class="relative block w-full rounded-lg border-2 border-dashed border-gray-300 p-20 text-center"
          >
            <div class="absolute inset-0 flex flex-col items-center justify-center">
              <div class="mb-4">
                <p class="text-gray-500 dark:text-white">No organisation found</p>
                <p class="mt-1 text-sm text-gray-500">
                  Looks like you're not part of an organisation yet. You can create one below or
                  request to join one.
                </p>
              </div>
              <div class="flex flex-col items-center gap-4 sm:flex-row">
                <InertiaLink :href="route('account.organisation.join.index')" class="btn-primary">
                  Join An Organisation
                </InertiaLink>
                <InertiaLink :href="route('account.organisation.create.index')" class="btn-primary">
                  Create Organisation
                </InertiaLink>
              </div>
            </div>
          </div>
        </template>
      </Panel>

      <Panel v-else title="Organisation Details">
        <template #content></template>
      </Panel>
    </div>
  </div>
</template>
