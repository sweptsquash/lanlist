<script lang="ts" setup>
const props = withDefaults(
  defineProps<{
    title?: string | null
    ogType?: string
    description?: string
  }>(),
  {
    title: null,
    ogType: 'website',
    description: 'LANList - A list of LAN parties',
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
    <meta property="fb:app_id" content="1020516908881667" />
    <meta property="og:url" :content="url" />
    <meta property="og:type" :content="ogType" />
    <meta property="og:title" :content="pageTitle" />
    <meta property="og:description" :content="description" />
    <meta property="og:locale" content="en_GB" />
    <meta property="og:site_name" content="WestLAN" />
    <meta name="twitter:title" :content="pageTitle" />
    <meta name="twitter:description" :content="description" />
  </InertiaHead>
</template>
