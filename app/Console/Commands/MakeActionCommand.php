<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

#[Description('Create a new action class')]
#[Signature('make:action {name}')]
final class MakeActionCommand extends GeneratorCommand
{
    protected $type = 'Action';

    protected function getStub(): string
    {
        return base_path('stubs/action.stub');
    }

    protected function getDefaultNamespace(
        $rootNamespace // @pest-ignore-type
    ): string {
        return 'App\Actions';
    }

    protected function getPath(
        $name // @pest-ignore-type
    ): string {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return $this->laravel->make('path').'/'.str_replace('\\', '/', $name).'Action.php';
    }
}
