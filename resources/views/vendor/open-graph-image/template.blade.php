<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex,nofollow">
        <style>
        @font-face {
            font-family: ui-sans-serif;
            font-weight: 100;
            src: url("https://applesocial.s3.amazonaws.com/assets/styles/fonts/sanfrancisco/sanfranciscodisplay-ultralight-webfont.woff");
        }
        @font-face {
            font-family: ui-sans-serif;
            font-weight: 200;
            src: url("https://applesocial.s3.amazonaws.com/assets/styles/fonts/sanfrancisco/sanfranciscodisplay-thin-webfont.woff");
        }
        @font-face {
            font-family: ui-sans-serif;
            font-weight: 400;
            src: url("https://applesocial.s3.amazonaws.com/assets/styles/fonts/sanfrancisco/sanfranciscodisplay-regular-webfont.woff");
        }
        @font-face {
            font-family: ui-sans-serif;
            font-weight: 500;
            src: url("https://applesocial.s3.amazonaws.com/assets/styles/fonts/sanfrancisco/sanfranciscodisplay-medium-webfont.woff");
        }
        @font-face {
            font-family: ui-sans-serif;
            font-weight: 600;
            src: url("https://applesocial.s3.amazonaws.com/assets/styles/fonts/sanfrancisco/sanfranciscodisplay-semibold-webfont.woff");
        }
        @font-face {
            font-family: ui-sans-serif;
            font-weight: 700;
            src: url("https://applesocial.s3.amazonaws.com/assets/styles/fonts/sanfrancisco/sanfranciscodisplay-bold-webfont.woff");
        }
        </style>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="m-0 p-0">
        <div
            class="relative isolate flex h-[630px] w-[1200px] items-center gap-x-10 bg-gray-900 px-8 pt-0 shadow-2xl overflow-hidden"
        >
            <svg
                viewBox="0 0 1024 1024"
                class="absolute left-1/2 top-1/2 -z-10 ml-0 h-[64rem] w-[64rem] -translate-x-1/2 translate-y-0 [mask-image:radial-gradient(closest-side,white,transparent)]"
                aria-hidden="true"
            >
                <circle
                    cx="512"
                    cy="512"
                    r="512"
                    fill="url(#759c1415-0410-454c-8f7c-9a820de03641)"
                    fill-opacity="0.7"
                ></circle>
                <defs>
                    <radialGradient id="759c1415-0410-454c-8f7c-9a820de03641">
                        <stop stop-color="#4338ca"></stop>
                        <stop offset="1" stop-color="#4338ca"></stop>
                    </radialGradient>
                </defs>
            </svg>
            <div class="mx-0 w-[750px] flex-auto flex-col py-32 text-left">
                <h2 class="text-6xl font-bold tracking-tight text-white">{!! explode(' - ', $title)[0] !!}</h2>
                @if(isset($subtitle))
                    <p class="mt-2 text-2xl leading-8 text-gray-300">{{ $subtitle }}</p>
                @endif
                @if(isset($learnmore))
                    <a
                        href="#"
                        class="mt-2 flex items-center justify-start gap-x-2 text-lg font-semibold leading-6 text-white"
                    >
                        Learn more
                        <span aria-hidden="true">→</span>
                    </a>
                @endif
            </div>
            @if(isset($image))
                <div class="relative mt-[250px] h-[550px] w-[800px]">
                    <img
                        class="absolute left-0 top-0 h-full object-cover max-w-none rounded-md bg-white/5 ring-1 ring-white/10"
                        src="{{ storage_path('app/media/') }}{{ $image }}"
                    />
                </div>
            @endif
        </div>
    </body>
</html>
