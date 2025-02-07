<script lang="ts" setup></script>

<template>
  <div>
    <AppHead title="Cookies" />

    <div class="mx-auto mt-12 max-w-2xl space-y-4 lg:max-w-7xl">
      <Panel title="Cookies">
        <template #content>
          <p>
            LANList only has functional cookies for user logins, it does not use tracking cookies
            for advertising or marketing purposes, so no cookie consent screen is required.
          </p>
          <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="hidden font-bold sm:block">Cookie Name</div>
            <div class="hidden font-bold sm:block">Duration/Expires</div>
            <div class="hidden font-bold sm:block">Description</div>

            <div>lanlist_session</div>
            <div>2 Hour Lifespan</div>
            <div>
              Stores an encrypted session token for the current users helping identify a guest
              and/or authorised users session.
            </div>

            <div class="border-b sm:col-span-3"></div>

            <div>remember_web_*</div>
            <div>1 Year Lifespan</div>
            <div>
              Stores an encrypted session token to remember the authenticated user allowing them to
              stay logged in for upto 1 year.
            </div>

            <div class="border-b sm:col-span-3"></div>

            <div>XSRF-TOKEN</div>
            <div>2 Hour Lifespan</div>
            <div>Cross-Site Request Forgery (XSRF) protection</div>
          </div>
        </template>
      </Panel>
      <Panel title="How to block cookies in your browser">
        <template #content>
          <p>
            If you really want to block cookies, we suggest you use a search engine to find the
            manual page for your browser. These links might help you out too...
          </p>
          <ul class="mt-4 list-inside list-disc space-y-4">
            <li>
              <a
                href="http://www.aboutcookies.org/"
                target="_blank"
                rel="noopener noreferrer"
                class="link"
              >
                aboutcookies.org
              </a>
            </li>
            <li>
              <a
                href="http://support.mozilla.org/en-US/kb/Blocking%20cookies"
                target="_blank"
                rel="noopener noreferrer"
                class="link"
              >
                Manual page for Firefox
              </a>
            </li>
            <li>
              <a
                href="http://help.opera.com/Linux/9.00/en/cookies.html"
                target="_blank"
                rel="noopener noreferrer"
                class="link"
              >
                Manual page for Opera
              </a>
            </li>
            <li>
              <a
                href="https://support.google.com/chrome/bin/answer.py?hl=en&answer=95647&p=cpn_cookies"
                target="_blank"
                rel="noopener noreferrer"
                class="link"
              >
                Manual page for Chrome
              </a>
            </li>
            <li>
              <a
                href="http://elinks.or.cz/documentation/manpages/elinks.conf.5.html"
                target="_blank"
                rel="noopener noreferrer"
                class="link"
              >
                Manual page for Elinks
              </a>
            </li>
          </ul>
        </template>
      </Panel>
    </div>
  </div>
</template>
