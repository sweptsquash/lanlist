<?php

declare(strict_types=1);
arch()
    ->expect('App\\Jobs')->classes()->toImplement('Illuminate\\Contracts\\Queue\\ShouldQueue')
    ->and('App\\Jobs')->classes()->toHaveMethod('handle');
