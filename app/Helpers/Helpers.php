<?php

use App\Models\User;

if (! function_exists('appUserAgent')) {
    function appUserAgent(): string
    {
        return config('app.name').'/'.config('app.version').' | '.config('app.company.name').' - '.config('app.company.support');
    }
}

if (! function_exists('user')) {
    function user(): ?User
    {
        return auth()->user();
    }
}

if (! function_exists('formatCurrency')) {
    function formatCurrency(int|float|null $amount, string $currency = 'GBP', string $locale = 'en_GB'): string
    {
        return numfmt_format_currency(
            numfmt_create($locale, NumberFormatter::CURRENCY),
            $amount ?? 0,
            $currency
        );
    }
}

// https://stackoverflow.com/questions/15188033/human-readable-file-size
if (! function_exists('humanFileSize')) {
    function humanFileSize($size, $unit = ''): string
    {
        if ((! $unit && $size >= 1 << 30) || $unit == 'GB') {
            return number_format($size / (1 << 30), 2).'GB';
        }
        if ((! $unit && $size >= 1 << 20) || $unit == 'MB') {
            return number_format($size / (1 << 20), 2).'MB';
        }
        if ((! $unit && $size >= 1 << 10) || $unit == 'KB') {
            return number_format($size / (1 << 10), 2).'KB';
        }

        return number_format($size).' bytes';
    }
}
