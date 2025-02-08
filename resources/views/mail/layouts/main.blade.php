<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="color-scheme" content="light">
        <meta name="supported-color-schemes" content="light">
        <style type="text/css">
            body {
                line-height: 1.5;
                -webkit-text-size-adjust: none;
                font-feature-settings: normal;
                font-variation-settings: normal;
                -webkit-tap-highlight-color: transparent;
                margin: 0;
                padding: 0;
            }

            body,
            body *:not(html):not(style):not(br):not(tr):not(code) {
                box-sizing: border-box;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif,
                    'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
                position: relative;
            }

            [class*='btn-'] {
                border-radius: 0.25rem;
                border-width: 1px;
                border-color: transparent;
                padding-left: 1rem;
                padding-right: 1rem;
                padding-top: 0.5rem;
                padding-bottom: 0.5rem;
                font-size: 0.875rem;
                line-height: 1.25rem;
                font-weight: 500;
                display: inline-block;
                text-decoration: none;
            }

            .btn-primary {
                background-color: rgb(79, 70, 229);
                color: #fff;
            }

            .btn-primary:hover {
                background-color: rgb(67, 56, 202);
            }

            .text-left {
                text-align: left;
            }

            .text-center {
                text-align: center;
            }

            .text-right {
                text-align: right;
            }

            .content-panel {
                background-color: #fff;
                border-radius: 0.5rem;
                padding: 1rem;
                margin-top: 1rem;
                --tw-shadow:  !important;
                --tw-shadow-colored: 0 1px 3px 0 var(--tw-shadow-color), 0 1px 2px -1px var(--tw-shadow-color) !important;
                box-shadow: 0 0 #0000, 0 0 #0000, 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1) !important;
                color: #000;
            }

            .content-panel > p:last-child {
                margin-bottom: 0;
            }

            .mt-4 {
                margin-top: 1rem;
            }

            .text-xs {
                font-size: 0.75rem;
                line-height: 1rem;
            }

            .table table {
                -premailer-cellpadding: 0;
                -premailer-cellspacing: 0;
                -premailer-width: 100%;
                margin: 30px auto;
                width: 100%;
                border-spacing: 0;
            }

            .table > table > thead > th {
                border-bottom: 1px solid #000 !important;
                margin: 0;
                padding-bottom: 8px;
                text-align: left !important;
            }

            .table td {
                color: #74787e;
                font-size: 15px;
                line-height: 18px;
                margin: 0;
                padding: 10px 0;
            }
        </style>
    </head>
    <body>
        <div style="width: 100%; height: 100vh; background-color: #edf2f7;">
            <div style="padding: 2rem; max-width: 640px; margin: auto;">
                <div class="text-center">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('logo.png') }}" alt="{{ config('app.name') }}" style="max-width: 100%; height: auto;">
                    </a>
                </div>
                <div class="content-panel">
                    {{ $slot }}
                </div>
                <div class="text-center mt-4 text-xs">
                    &copy; {{ date('Y') }} {{ config('app.name') }}, All Rights Reserved.
                </div>
            </div>
        </div>
    </body>
</html>
