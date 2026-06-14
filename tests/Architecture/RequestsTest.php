<?php

declare(strict_types=1);
arch()
    ->expect('App\\Http\\Requests')->classes()->toHaveSuffix('Request')
    ->and('App\\Http\\Requests')
    ->toExtend('Illuminate\\Foundation\\Http\\FormRequest')
    ->and('App\\Http\\Requests')
    ->toHaveMethod('rules')
    ->and('App')->not->toExtend('Illuminate\\Foundation\\Http\\FormRequest')->ignoring('App\\Http\\Requests');
