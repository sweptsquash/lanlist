<script lang="ts" setup>
import LanEvent from '@/../images/lan-event.jpeg'
</script>

<template>
    <UApp>
        <div class="flex min-h-svh flex-col items-center justify-center bg-muted p-6 md:p-10">
            <div class="w-full max-w-sm md:max-w-3xl">
                <div class="flex flex-col gap-6">
                    <UCard
                        id="authContainer"
                        variant="subtle"
                        class="min-h-[525px] overflow-hidden"
                        :ui="{ body: '!p-0' }"
                    >
                        <div class="grid min-h-[525px] p-0 md:grid-cols-2">
                            <div class="p-6 md:p-8">
                                <slot />
                            </div>
                            <div class="relative hidden bg-muted md:block">
                                <img
                                    :src="LanEvent"
                                    alt="Image"
                                    class="absolute inset-0 h-full w-full object-cover dark:brightness-[0.2] dark:grayscale"
                                />
                            </div>
                        </div>
                    </UCard>
                    <div
                        class="text-muted-foreground text-center text-xs text-balance *:[a]:underline *:[a]:underline-offset-4 *:[a]:hover:text-primary"
                    >
                        By clicking continue, you agree to our
                        <a href="#">Terms of Service</a>
                        and
                        <a href="#">Privacy Policy</a>
                        .
                    </div>
                </div>
            </div>
        </div>
    </UApp>
</template>
