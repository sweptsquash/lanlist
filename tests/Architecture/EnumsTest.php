<?php

declare(strict_types=1);
arch()
    ->expect('App')->not->toBeEnums()->ignoring('App\\Enums')
    ->and('App\\Enums')
    ->toBeEnums()
    ->ignoring('App\\Enums\\Concerns');
