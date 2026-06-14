<?php

declare(strict_types=1);
arch()
    ->expect('App\\Features')->toBeClasses()->ignoring('App\\Features\\Concerns')
    ->and('App\\Features')
    ->toHaveMethod('resolve');
