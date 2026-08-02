<script setup lang="ts">
const isImpersonating = computed<boolean>(() => {
    return usePage().props.isImpersonating ?? false
})

const stopImpersonating = () => {
    useForm({}).delete(route('account.impersonation.stop'), {
        preserveState: true,
    })
}
</script>

<template>
    <UAlert
        v-if="isImpersonating"
        class="sticky top-0 right-0 left-0 z-50 rounded-none"
        color="info"
    >
        <template #description>
            <div class="flex flex-row items-center justify-between">
                <div>You are currently impersonating another user.</div>
                <UButton label="Stop Impersonating" color="neutral" @click="stopImpersonating" />
            </div>
        </template>
    </UAlert>
</template>
