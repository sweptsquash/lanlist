<script lang="ts" setup>
import socialBanner from '@/../images/social-banner.png'

const props = withDefaults(
  defineProps<{
    title?: string | null
    ogType?: string
    description?: string
    thumbnail?: string
    imageWidth?: string
    imageHeight?: string
    imageAlt?: string
  }>(),
  {
    title: null,
    ogType: 'website',
    description: 'LANList - A list of LAN parties',
    thumbnail: socialBanner,
    imageWidth: '1280',
    imageHeight: '853',
    imageAlt: undefined,
  },
)

const url = computed(() => usePage().props.location)

const pageTitle = computed(() =>
  props.title ? `${props.title} - LANList` : 'LANList - A list of LAN parties',
)
</script>

<template>
  <InertiaHead :title="pageTitle">
    <link rel="canonical" :content="url" />
    <meta name="description" :content="description" />
    <meta name="author" content="LANList" />
    <meta property="og:url" :content="url" />
    <meta property="og:type" :content="ogType" />
    <meta property="og:title" :content="pageTitle" />
    <meta property="og:description" :content="description" />
    <meta property="og:image" :content="thumbnail" />
    <meta property="og:image:width" :content="imageWidth" />
    <meta property="og:image:height" :content="imageHeight" />
    <meta property="og:image:alt" :content="imageAlt ?? pageTitle" />
    <meta property="og:locale" content="en_GB" />
    <meta property="og:site_name" content="LANList" />
    <meta name="twitter:title" :content="pageTitle" />
    <meta name="twitter:description" :content="description" />
    <meta name="twitter:image" :content="thumbnail" />
    <meta name="twitter:card" content="summary_large_image" />
  </InertiaHead>
</template>
