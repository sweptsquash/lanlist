<?php

declare(strict_types=1);
arch()
    ->expect('App\\Http\\Middleware')->classes()->toHaveMethod('handle');
