<script lang="ts" setup>
import { useClipboard } from '@vueuse/core'

const props = defineProps<{ id: string; title: string }>()

const { copy, copied, isSupported } = useClipboard()

function copyContent() {
  const content = document.getElementById(`${props.id}code`)?.innerText

  if (!content) {
    return
  }

  copy(content)
}
</script>

<template>
  <div class="relative my-4 max-w-full">
    <div class="rounded-md bg-gray-100 p-4 text-black dark:bg-gray-900 dark:text-white">
      <div class="mb-2 flex items-center justify-between">
        <span class="text-black dark:text-gray-400">{{ title }}:</span>
        <button
          v-if="isSupported"
          class="code btn-default"
          :data-clipboard-target="`#${id}code`"
          @click="copyContent"
        >
          {{ copied ? 'Copied' : 'Copy' }}
        </button>
      </div>
      <div class="overflow-x-auto">
        <pre :id="`${id}code`" class="with-line-numbers p-3" tabindex="0">
          <code class="block"><slot /></code>
        </pre>
      </div>
    </div>
  </div>
</template>
