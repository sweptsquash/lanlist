<?php

declare(strict_types=1);
arch()
    ->expect('App\\Notifications')->toExtend('Illuminate\\Notifications\\Notification')
    ->and('App')->not->toExtend('Illuminate\\Notifications\\Notification')->ignoring('App\\Notifications');
