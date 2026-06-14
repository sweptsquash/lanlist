<?php

declare(strict_types=1);
arch()
    ->expect('App\\Mail')->classes()->toExtend('Illuminate\\Mail\\Mailable')
    ->and('App\\Mail')->classes()->toImplement('Illuminate\\Contracts\\Queue\\ShouldQueue')
    ->and('App')->not->toExtend('Illuminate\\Mail\\Mailable')->ignoring('App\\Mail');
