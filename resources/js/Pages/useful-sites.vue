<script lang="ts" setup>
const sites = [
  {
    name: 'lan.party',
    href: 'https://lan.party/',
    description: 'A site created in April 2024, hosting resources for the LAN party community.',
  },
  {
    name: 'lanparty.dk',
    href: 'https://lanparty.dk/',
    description: 'A community and event list for LAN parties in and near Denmark.',
  },
  {
    name: 'LANPartyWiki',
    href: 'http://www.lanpartywiki.net/',
    description: 'A wikipedia-like wiki for all things related to LAN Parties.',
  },
]
</script>

<template>
  <div>
    <AppHead title="Cookies" />

    <div class="mx-auto mt-12 max-w-2xl space-y-4 lg:max-w-7xl">
      <Panel title="Useful Related Sites">
        <template #content>
          <ul class="list-inside list-disc space-y-4">
            <li v-for="site in sites" :key="`site${site.name}`">
              <a :href="site.href" target="_blank" rel="noopener noreferrer" class="link">
                {{ site.name }}
              </a>
              - {{ site.description }}
            </li>
          </ul>
        </template>
      </Panel>
    </div>
  </div>
</template>
