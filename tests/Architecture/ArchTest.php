<?php

declare(strict_types=1);

arch()
    ->expect([
        'dd', 'ddd', 'dump', 'env', 'exit', 'ray',
    ])->not->toBeUsed();
arch()
    ->expect('App')
    ->toUseStrictTypes();
