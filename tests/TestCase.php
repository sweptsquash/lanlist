<?php

declare(strict_types=1);

namespace Tests;

use Database\Seeders\CountrySeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        Http::preventStrayRequests();
        Notification::fake();
        Mail::fake();
        Queue::fake();
        Storage::fake();

        $this->seed([
            CountrySeeder::class,
        ]);
    }
}
