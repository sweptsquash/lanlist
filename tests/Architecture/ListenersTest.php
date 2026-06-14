<?php

declare(strict_types=1);

$subscribers = array_map(
    fn (string $file): string => 'App\\Listeners\\'.pathinfo($file, PATHINFO_FILENAME),
    glob(dirname(__DIR__, 2).'/app/Listeners/*Subscriber.php') ?: [],
);

arch('listeners should have a handle method')
    ->expect('App\\Listeners')
    ->toHaveMethod('handle')
    ->ignoring($subscribers);

arch('event subscribers should have a subscribe method')
    ->expect($subscribers)
    ->toHaveMethod('subscribe');
