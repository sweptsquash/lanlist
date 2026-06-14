<?php

declare(strict_types=1);
arch()
    ->expect('App\\Casts')->classes()->toImplement('Illuminate\\Contracts\\Database\\Eloquent\\CastsAttributes')
    ->and('App\\Casts')->classes()->toHaveMethod('get')->and('set');
