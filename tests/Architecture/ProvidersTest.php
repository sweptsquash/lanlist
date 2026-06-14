<?php

declare(strict_types=1);
arch()
    ->expect('App\\Providers')->toHaveSuffix('ServiceProvider')
    ->and('App\\Providers')->toExtend('Illuminate\\Support\\ServiceProvider')
    ->and('App\\Providers')->not->toBeUsed()
    ->and('App')->not->toExtend('Illuminate\\Support\\ServiceProvider')->ignoring('App\\Providers')
    ->and('App')->not->toHaveSuffix('ServiceProvider')->ignoring('App\\Providers');
