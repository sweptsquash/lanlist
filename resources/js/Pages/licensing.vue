<script lang="ts" setup></script>

<template>
  <div>
    <AppHead title="Licensing" />

    <div class="mx-auto mt-12 max-w-2xl space-y-4 lg:max-w-7xl">
      <Panel title="Licensing">
        <template #content>
          <h4 class="mb-4 dark:text-white">Source Code</h4>
          <p>
            The source code for this website fully open source, licensed AGPL-v3. You can find the
            code on
            <a
              href="https://github.com/jamesread/lanlist/"
              class="link"
              rel="noopener noreferrer"
              target="_blank"
            >
              GitHub
            </a>
            .
          </p>
          <h4 class="my-4 dark:text-white">Database</h4>
          <p class="mb-2">
            This site's content is it's database, which is built and maintained by the LAN Party
            Community.
          </p>
          <p>
            The list of LAN Parties on this website is licensed Creative Commons
            Attributution-Share-Alike 4.0. This license refers to the list in all forms - text, csv,
            ical, etc. Each format can be found on the
            <InertiaLink :href="route('events.index')" class="link">list page</InertiaLink>
            . PLEASE don't use a web-page scraping tool to hammer this webserver. For what you are
            allowed to do with the list, please
            <a
              href="http://creativecommons.org/licenses/by-sa/4.0/"
              class="link"
              rel="noopener noreferrer"
              target="_blank"
            >
              see the license
            </a>
            .
          </p>

          <div
            class="my-4 flex flex-col justify-center rounded border-2 border-dashed p-8 dark:border-white"
          >
            <div class="mx-auto mb-2">
              <img src="http://i.creativecommons.org/l/by-sa/4.0/88x31.png" class="h-8 w-auto" />
            </div>
            <div class="text-center">
              <p>
                The lanlist.org LAN Party Lists by
                <InertiaLink href="#" class="link">lanlist.org Admin Team</InertiaLink>
                are licensed under a
                <a
                  href="http://creativecommons.org/licenses/by-sa/4.0/"
                  class="link"
                  rel="noopener noreferrer"
                  target="_blank"
                >
                  Creative Commons Attribution-ShareAlike 4.0 Unported License
                </a>
                .
              </p>
            </div>
          </div>

          <h4 class="my-4 dark:text-white">Link To Us!</h4>
          <p>
            If you would like to use the data, please feel free. Linking to us is part of the
            license though. The aptly named
            <InertiaLink :href="route('linkus')">"Link to us!"</InertiaLink>
            page gives you lots of pretty buttons that you can use.
          </p>
        </template>
      </Panel>
    </div>
  </div>
</template>
