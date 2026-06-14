<?php

declare(strict_types=1);
arch()
    ->expect('App\\Models')->classes()->toExtend('Illuminate\\Database\\Eloquent\\Model')->ignoring('App\\Models\\Scopes')
    ->and('App\\Models')
    ->classes()
    ->not
    ->toHaveSuffix('Model')
    ->and('App')
    ->not
    ->toExtend('Illuminate\\Database\\Eloquent\\Model')
    ->ignoring('App\\Models')
    ->and('App\Models')
    ->not->toUse(['app', 'auth', 'session']);
