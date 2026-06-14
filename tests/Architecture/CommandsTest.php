<?php

declare(strict_types=1);
arch()
    ->expect('App\\Console\\Commands')
    ->classes()
    ->toHaveSuffix('Command')
    ->and('App\\Console\\Commands')
    ->classes()
    ->toExtend('Illuminate\\Console\\Command')
    ->and('App\\Console\\Commands')
    ->classes()
    ->toHaveMethod('handle')
    ->and('App')
    ->not
    ->toExtend('Illuminate\\Console\\Command')
    ->ignoring('App\\Console\\Commands');
