<script lang="ts" setup></script>

<template>
  <div>
    <AppHead title="Link Us!" />

    <div class="mx-auto mt-12 max-w-2xl space-y-4 lg:max-w-7xl">
      <Panel title="Link Us">
        <template #content>
          <p>
            If you have a website or similar, a link to us would be most appreciated. Feel free to
            use our logo (without modifications) where you see fit. While we do own a few domains,
            could you link to
            <strong>lanlist.info</strong>
            please. If possible, save the images to your webserver instead of hotlinking them.
          </p>
          <div class="my-4 grid grid-cols-1 gap-y-4 sm:grid-cols-6 sm:divide-y">
            <div class="hidden text-xl font-bold text-black sm:block dark:text-white">Banner</div>
            <div class="hidden text-xl font-bold text-black sm:block dark:text-white">
              Dimensions
            </div>
            <div class="col-span-4 hidden text-xl font-bold text-black sm:block dark:text-white">
              Code
            </div>

            <div>
              <p>Main, Transparent Banner</p>
              <img
                src="https://lanlist.info/resources/images/logoHuge512.png"
                class="h-[32px] w-auto"
              />
            </div>
            <div>128px x 32px</div>
            <div class="border-b sm:col-span-4 sm:border-b-0">
              <CodeBlock id="mainBBCode" title="BBCode">
                <span class="line">
                  [url=https://lanlist.info][img]https://lanlist.info/resources/images/logoHuge512.png[/img][/url]
                </span>
              </CodeBlock>

              <CodeBlock id="mainHTML" title="HTML">
                <span class="line">
                  &lt;a href="https://lanlist.info" target="_blank" rel="noopener
                  noreferrer"&gt;&lt;img src="https://lanlist.info/resources/images/logoHuge512.png"
                  width="128" height="32" alt="lanlist.info" /&gt;&lt;/a&gt;
                </span>
              </CodeBlock>
            </div>

            <div>
              <p>Classic</p>
              <img
                src="https://lanlist.info/resources/images/lanlistClassicButton.png"
                class="h-[31px] w-auto"
              />
            </div>
            <div>88px x 31px</div>
            <div class="border-b sm:col-span-4 sm:border-b-0">
              <CodeBlock id="classicBBCode" title="BBCode">
                <span class="line">
                  [url=https://lanlist.info][img]https://lanlist.info/resources/images/lanlistClassicButton.png[/img][/url]
                </span>
              </CodeBlock>

              <CodeBlock id="classicHTML" title="HTML">
                <span class="line">
                  &lt;a href="https://lanlist.org" target="_blank" rel="noopener
                  noreferrer"&gt;&lt;img
                  src="https://lanlist.info/resources/images/lanlistClassicButton.png" width="88"
                  height="31" alt="lanlist.info" /&gt;&lt;/a&gt;
                </span>
              </CodeBlock>
            </div>

            <div class="border-b-0">
              <p>Tiny</p>
              <img
                src="https://lanlist.info/resources/images/favicon.png"
                class="h-[16px] w-auto"
              />
            </div>
            <div class="border-b-0">16px x 16px</div>
            <div class="border-b-0 sm:col-span-4">
              <CodeBlock id="tinyBBCode" title="BBCode">
                <span class="line">
                  [url=https://lanlist.info][img]https://lanlist.info/resources/images/favicon.png[/img][/url]
                </span>
              </CodeBlock>

              <CodeBlock id="tinyHTML" title="HTML">
                <span class="line">
                  &lt;a href="https://lanlist.info" target="_blank" rel="noopener
                  noreferrer"&gt;&lt;img src="https://lanlist.info/resources/images/favicon.png"
                  width="16" height="16" alt="lanlist.info" /&gt;&lt;/a&gt;
                </span>
              </CodeBlock>
            </div>
          </div>
        </template>
      </Panel>
      <Panel
        title="Write nice things about us, talk about us and whatnot..."
        subtitle="If you are doing something a bit special and want some really really big logos, we thought of that too."
      >
        <template #content>
          <!-- TODO -->
          <ul class="mb-4 list-inside list-disc space-y-4">
            <li>
              <a href="#" class="link">2048x512, Transparent Background</a>
            </li>
            <li>
              <a href="#" class="link">2048x512, White Background</a>
            </li>
            <li>
              <a href="#" class="link">512x128, Transparent Background</a>
            </li>
            <li>
              <a href="#" class="link">512x128, White Background</a>
            </li>
          </ul>
          <p>If you want to say something nice about us, erm, try this;</p>
          <blockquote
            class="mt-6 rounded-md border border-black/75 p-4 text-lg font-semibold text-white sm:text-xl/8 dark:border-white"
          >
            “lanlist.info is a list of LAN parties. It was built for punters to easily keep up with
            their faveourite organizers and find new events. Organizers can advertise their events
            on the site for free.”
          </blockquote>
        </template>
      </Panel>
    </div>
  </div>
</template>
