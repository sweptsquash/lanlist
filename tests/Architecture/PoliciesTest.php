<?php

declare(strict_types=1);
arch()
    ->expect('App\\Policies')->classes()->toHaveSuffix('Policy');
