<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Tighten\Ziggy\Ziggy;

#[Description('Generate LaraRail routes and TypeScript definitions')]
#[Signature('app:generate-lararail-routes')]
final class GenerateLararailRoutesCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $routes = $this->getRoutes();

        $total = count($routes['routes']);

        if (config('ziggy.output.routes')) {
            $this->storeRoutes($routes);
        }

        $this->storeTypeScript($routes);

        $this->table(
            ['Name', 'URI'],
            collect($routes['routes'] + $routes['wildcards'])
                ->map(fn (array $route, string $name): array => [$name, $route['uri'] ?? ''])
        );

        $this->info(sprintf('Extracted %d Laravel routes', $total));

        return self::SUCCESS;
    }

    private function getRoutes(): array
    {
        $data = (new Ziggy)
            ->filter(['*debugbar.*', '*ignition.*', '*nova.*', 'filament.*'], false)
            ->toArray();

        $data['wildcards'] = self::getWildcardRoutes($data);

        return $data;
    }

    private function getWildcardRoutes(array $data): array
    {
        $wildcards = [];

        foreach (array_keys($data['routes']) as $routeName) {
            $parts = explode('.', (string) $routeName);

            array_pop($parts);

            $partial = '';

            foreach ($parts as $part) {
                $partial .= $part.'.';

                $wildcards[$partial.'*'] = [];
            }
        }

        return $wildcards;
    }

    private function storeRoutes(array $routes): void
    {
        File::put(
            config('ziggy.output.routes'),
            json_encode($routes)
        );
    }

    private function storeTypeScript(array $routes): void
    {
        $definition = json_encode($routes);

        $output = <<<TYPESCRIPT
        import "lararail"

        declare module "lararail" {
            export interface RouterGlobal {$definition}
        }
        TYPESCRIPT;

        File::put(
            config('ziggy.output.typescript'),
            $output
        );
    }
}
