<script lang="ts" setup>
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { ExclamationTriangleIcon } from '@heroicons/vue/24/solid/index.js'

withDefaults(
  defineProps<{
    isOpen: boolean
    title: string
    message: string
    type?: string
    actionText?: string
    actionClass?: string
    cancelText?: string
  }>(),
  {
    type: 'info',
    actionText: 'Confirm',
    actionClass: 'btn-primary',
    cancelText: 'Cancel',
  },
)

const emit = defineEmits<{ close: []; action: [] }>()
</script>

<template>
  <TransitionRoot as="template" :show="isOpen">
    <Dialog as="div" class="relative z-10" @close="emit('close')">
      <TransitionChild
        as="template"
        enter="ease-out duration-300"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="ease-in duration-200"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-gray-500/75 transition-opacity" />
      </TransitionChild>

      <div class="fixed inset-0 z-10 overflow-y-auto">
        <div
          class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
        >
          <TransitionChild
            as="template"
            enter="ease-out duration-300"
            enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            enter-to="opacity-100 translate-y-0 sm:scale-100"
            leave="ease-in duration-200"
            leave-from="opacity-100 translate-y-0 sm:scale-100"
            leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          >
            <DialogPanel
              class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg dark:bg-gray-600"
            >
              <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 dark:bg-gray-600">
                <div class="sm:flex sm:items-start">
                  <div
                    class="mx-auto flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10"
                  >
                    <ExclamationTriangleIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
                  </div>
                  <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <DialogTitle
                      as="h3"
                      class="text-lg leading-6 font-medium text-gray-900 dark:text-white"
                    >
                      {{ title }}
                    </DialogTitle>
                    <div class="mt-2">
                      <p class="text-sm text-gray-500 dark:text-gray-300">
                        {{ message }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div
                class="gap-x-4 bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 dark:bg-gray-800"
              >
                <button type="button" :class="['btn', actionClass]" @click="emit('action')">
                  {{ actionText }}
                </button>
                <button type="button" class="btn btn-default" @click="emit('close')">
                  {{ cancelText }}
                </button>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>
