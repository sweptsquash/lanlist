# LANList
A list of LAN Parties

## Technologies Used
- Node 22
- PHP 8.4
- Laravel 11
- InertiaJS
- VueJS 3.x
- TailwindCSS 3.x

## Development

Local development makes use of Docker Desktop through the use of Laravel Sail, before getting started with local development please ensure Docker Desktop is installed and open.

1. First we need to copy our environment files to do this we'll run the following commands:

```bash
cp .env.example .env && cp .env.testing.example .env.testing
```

2. Next run the following command to install our vendor packages:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
```

3. Next we'll need to build our docker image by running 
```bash
./vendor/bin/sail build --no-cache
```

4. Next we'll start our docker image by running 
```bash
./vendor/bin/sail up -d
```

To stop
```bash
./vendor/bin/sail down
```

5. Now we'll install our node packages 
```bash
./vendor/bin/sail npm install
```
Note: You can do this normally if you have Node already installed `npm install`

6. Now lets migrate and seed our database with 
```bash
./vendor/bin/sail artisan migrate:fresh --seed
```

7. Running Hot Module Reloaded instance of our frontend with 
```bash
./vendor/bin/sail npm run dev
```
Note: You can this normally if you have Node already installed `npm run dev`

8. Navigate to `http://localhost:8000` in your browser

## NPM Scripts
- `dev` - Run HMR client/server
- `build:dev` - Build development version of client and SSR
- `build:prod` - Build production version of client and SSR
- `lint` - Run linter and prettier checks and write changes
- `test:lint` - Dry run of `lint` and output a list of warnings/errors
- `tsc` - TypeScript Enforcement Check

## Composer Commands:
Automated Scripts
- `update` will publish third-party assets and regenerate all ide-helpers
- `install` will generate ziggy routes `resources/js/ziggy.js`
- `lint` - Format PHP based to Laravel Standards.
- `test:lint` - Dry run of `lint` output a list of warnings/errors.
- `test` - Run tests in parallel with no coverage and ensure database is recreated
- `doc:models` - [PHPDocs for models](https://github.com/barryvdh/laravel-ide-helper#automatic-PHPDocs-for-models) within `App/Models`
- `analyse` - Analayse the code base using LaraStan

## Artisan Commands:
- `ide-helper:generate` - [PHPDoc generation for Laravel Facades](https://github.com/barryvdh/laravel-ide-helper#automatic-phpdoc-generation-for-laravel-facades) 
- `ide-helper:meta` - [PhpStorm Meta file](https://github.com/barryvdh/laravel-ide-helper#phpstorm-meta-for-container-instances)

**Note:** `ide-helper:generate` `ide-helper:meta` and `doc:models` are always executed on `composer update`.


## Vectors used in Logo
- https://www.vecteezy.com/png/23369057-big-joystick-for-gaming-gaming-scifi
- https://www.vecteezy.com/png/23369058-fat-mouse-gamers-love-to-use-gaming-scifi
