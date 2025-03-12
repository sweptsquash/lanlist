<?php

declare(strict_types=1);

use App\Models\User;

use function Pest\Laravel\actingAs;
use function PHPUnit\Framework\assertEquals;

describe('Helpers', function () {
    it('Returns the App User Agent', function () {
        assertEquals(config('app.name').'/'.config('app.version').' | '.config('app.company.name').' - '.config('app.company.support'), appUserAgent());
    });

    it('Returns the authenticated user', function () {
        /** @var User $user */
        $user = User::factory()->create();

        actingAs($user);

        assertEquals($user->id, user()->id);
    });

    it('Returns null when the authenticated user is not found', function () {
        assertEquals(null, user());
    });

    it('Formats a currency', function () {
        assertEquals('£0.00', formatCurrency(null));
        assertEquals('£1.00', formatCurrency(1));
        assertEquals('£1.10', formatCurrency(1.1));
        assertEquals('£1.17', formatCurrency(1.17));
    });

    it('Formats a human file size', function () {
        assertEquals('1.00GB', humanFileSize(1073741824));
        assertEquals('1.50GB', humanFileSize(1610612736));
        assertEquals('2.00GB', humanFileSize(2147483648));
        assertEquals('4.00GB', humanFileSize(4294967296, 'GB'));
        assertEquals('2.00MB', humanFileSize(2097152, 'MB'));
        assertEquals('10.00KB', humanFileSize(10240, 'KB'));
        assertEquals('100 bytes', humanFileSize(100));
    });
});
