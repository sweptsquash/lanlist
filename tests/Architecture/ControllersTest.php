<?php

declare(strict_types=1);
arch()
    ->expect('App')->not->toHaveSuffix('Controller')->ignoring('App\\Http\\Controllers')
    ->and('App\\Http\\Controllers')->classes()->toHaveSuffix('Controller')
    ->and('App\\Http')->toOnlyBeUsedIn('App\\Http')->ignoring('App\\Events')
    ->and('App\\Http\\Controllers')->not->toHavePublicMethodsBesides(['__construct', '__invoke', 'index', 'show', 'create', 'store', 'edit', 'update', 'destroy', 'middleware', 'restore']);
