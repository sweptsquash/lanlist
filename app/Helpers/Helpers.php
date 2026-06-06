<?php

declare(strict_types=1);

use App\Models\User;

// @codeCoverageIgnoreStart
if (! function_exists('currentGuard')) {
    // @codeCoverageIgnoreEnd
    function currentGuard(): string
    {
        return auth()->guard('web')->check() ? 'web' : (auth()->guard('api')->check() ? 'api' : 'guest');
    }

    // @codeCoverageIgnoreStart
}

// @codeCoverageIgnoreEnd

// @codeCoverageIgnoreStart
if (! function_exists('user')) {
    // @codeCoverageIgnoreEnd
    function user(): ?User
    {
        $guard = currentGuard();

        if ($guard === 'guest') {
            return null;
        }

        /** @var ?User $user */
        $user = auth($guard)->user();

        $user?->load([
            'roles.permissions',
            'permissions',
        ]);

        return $user;
    }

    // @codeCoverageIgnoreStart
}

// @codeCoverageIgnoreEnd

// @codeCoverageIgnoreStart
if (! function_exists('humanFileSize')) {
    // @codeCoverageIgnoreEnd

    // https://stackoverflow.com/questions/15188033/human-readable-file-size
    function humanFileSize(int|float $size, string $unit = ''): string
    {
        if ((($unit === '' || $unit === '0') && $size >= 1 << 30) || $unit === 'GB') {
            return number_format($size / (1 << 30), 2).'GB';
        }

        if ((($unit === '' || $unit === '0') && $size >= 1 << 20) || $unit === 'MB') {
            return number_format($size / (1 << 20), 2).'MB';
        }

        if ((($unit === '' || $unit === '0') && $size >= 1 << 10) || $unit === 'KB') {
            return number_format($size / (1 << 10), 2).'KB';
        }

        return number_format($size).' bytes';
    }

    // @codeCoverageIgnoreStart
}

// @codeCoverageIgnoreEnd

// @codeCoverageIgnoreStart
if (! function_exists('toMinorAmount')) {
    // @codeCoverageIgnoreEnd
    function toMinorAmount(int|float|null $value): int|float|null
    {
        if (is_null($value)) {
            return null;
        }

        return $value * 100;
    }

    // @codeCoverageIgnoreStart
}

// @codeCoverageIgnoreEnd

// @codeCoverageIgnoreStart
if (! function_exists('toMajorAmount')) {
    // @codeCoverageIgnoreEnd
    function toMajorAmount(int|float|null $value): int|float|null
    {
        if (is_null($value)) {
            return null;
        }

        return $value / 100;
    }

    // @codeCoverageIgnoreStart
}

// @codeCoverageIgnoreEnd

// @codeCoverageIgnoreStart
if (! function_exists('formatCurrency')) {
    // @codeCoverageIgnoreEnd
    function formatCurrency(int|float|null $amount, string $currency = 'GBP', string $locale = 'en_GB'): string|false
    {
        try {
            $numberFormatter = numfmt_create($locale, NumberFormatter::CURRENCY);

            if (! $numberFormatter instanceof NumberFormatter) {
                return false;
            }
        } catch (ValueError) {
            return false;
        }

        return numfmt_format_currency(
            $numberFormatter,
            $amount ?? 0,
            $currency
        );
    }

    // @codeCoverageIgnoreStart
}

// @codeCoverageIgnoreEnd

// @codeCoverageIgnoreStart
if (! function_exists('formatAddress')) {
    // @codeCoverageIgnoreEnd

    function formatAddress(array $address): string
    {
        $lines = [];

        if (! empty($address['flat_number']) && ! empty($address['building_name_number'])) {
            $lines[] = $address['flat_number'].'/'.$address['building_name_number'];
        } elseif (! empty($address['building_name_number'])) {
            $lines[] = $address['building_name_number'];
        } elseif (! empty($address['flat_number'])) {
            $lines[] = $address['flat_number'];
        }

        if (! empty($address['street_name'])) {
            $lines[] = $address['street_name'];
        }

        if (! empty($address['line_2'])) {
            $lines[] = $address['line_2'];
        }

        if (! empty($address['line_3'])) {
            $lines[] = $address['line_3'];
        }

        if (! empty($address['city'])) {
            $lines[] = $address['city'];
        }

        if (! empty($address['county'])) {
            $lines[] = $address['county'];
        }

        if (! empty($address['postcode'])) {
            $lines[] = $address['postcode'];
        }

        if (! empty($address['country'])) {
            $lines[] = $address['country'];
        }

        return implode(', ', $lines);
    }

    // @codeCoverageIgnoreStart
}

// @codeCoverageIgnoreEnd
