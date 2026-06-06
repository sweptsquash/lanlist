env ?= ./.env
-include $(env)
ifdef $(env)
	$(shell sed 's/=.*//' $(env))
endif

.PHONY: help

help:
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.DEFAULT_GOAL := help
BRANCH := $(shell git rev-parse --abbrev-ref HEAD)

setup:
	@if ! [ -f .env ]; then \
		cp .env.local.example .env; \
	fi
	@if ! [ -x "`command -v docker`" ]; then \
		echo 'Please ensure Docker is installed'; \
	fi
	@if ! [ -x "`command -v npm`" ]; then \
		echo 'Please ensure Node is installed'; \
	fi
	@if ! [ -x "`command -v sail`" ]; then \
		echo 'Please ensure Sail Alias is setup'; \
	fi
	make composer_install
	@if ! docker image inspect sweptsquash/lanlist >/dev/null 2>&1; then make sail_build; fi
	make sail_up
	make build_spa
	make create_bucket
	docker compose -f compose.yaml exec --user=sail lanlist_app php artisan key:generate
	make db_reset
	make ide_helper
	make setup_ssl_hosts

create_bucket:
	docker compose -f compose.yaml exec --user=root minio bash -c " \
		echo URL: ${AWS_ENDPOINT}; \
		echo Credentials: ${AWS_ACCESS_KEY_ID}:${AWS_SECRET_ACCESS_KEY}; \
		/usr/bin/mc alias set s3 ${AWS_ENDPOINT} ${AWS_ACCESS_KEY_ID} ${AWS_SECRET_ACCESS_KEY}; \
		/usr/bin/mc mb s3/${AWS_BUCKET} --ignore-existing; \
		/usr/bin/mc anonymous set public s3/${AWS_BUCKET} \
	"

shell:
	docker compose -f compose.yaml exec --user=root lanlist_app bash

shell_db:
	docker compose -f compose.yaml exec --user=root mysql bash

sail_build:
	@echo "Building Sail containers..."
	docker compose build --no-cache

sail_up:
	@echo "Starting Sail containers..."
	docker compose up -d

sail_down:
	@echo "Stopping Sail containers..."
	docker compose down

sail_stop:
	@echo "Stopping Sail containers..."
	docker compose stop

composer_install:
	@echo "Installing Composer dependencies..."
	docker run --rm -u "$(shell id -u):$(shell id -g)" -v "$(shell pwd):/app" -w /app composer:latest composer install --ignore-platform-reqs --no-scripts;

clear_cache:
	@echo "Clearing Composer cache..."
	docker compose -f compose.yaml exec --user=sail lanlist_app php artisan optimize:clear
	docker compose -f compose.yaml exec --user=sail lanlist_app php artisan config:cache
	docker compose -f compose.yaml exec --user=sail lanlist_app php artisan route:cache

composer_update:
	@echo "Updating Composer dependencies..."
	docker compose -f compose.yaml exec lanlist_app chown -R 33:33 /composer/cache
	docker compose -f compose.yaml exec --user=sail lanlist_app composer update --prefer-dist --no-interaction --optimize-autoloader
	docker compose -f compose.yaml exec --user=sail lanlist_app composer bump

db_reset:
	@echo "Resetting the database..."
	docker compose -f compose.yaml exec --user=sail lanlist_app php artisan migrate:fresh --seed
	docker compose -f compose.yaml exec --user=sail lanlist_app composer doc:models
	@echo "Database reset complete."

ide_helper:
	@echo "Generating IDE helper files..."
	docker compose -f compose.yaml exec --user=sail lanlist_app composer ide-helper
	docker compose -f compose.yaml exec --user=sail lanlist_app composer doc:models

setup_ssl_hosts:
	@echo "Setting up SSL & Hosts..."
	./scripts/setup.sh

build_spa:
	docker compose -f compose.yaml exec --user=sail lanlist_app npm --prefix=packages/lararail ci
	docker compose -f compose.yaml exec --user=sail lanlist_app npm --prefix=packages/vite-plugin-watch ci
	docker compose -f compose.yaml exec --user=sail lanlist_app npm run prepare
	docker compose -f compose.yaml exec --user=sail lanlist_app npm ci
	docker compose -f compose.yaml exec --user=sail lanlist_app npm run routes
	docker compose -f compose.yaml exec --user=sail lanlist_app npm run build:ssr

serve_spa:
	@echo "Starting SPA..."
	@echo "Note: Queue and Reverb are managed by Supervisor"
	npm run build:ssr
	docker compose -f compose.yaml exec --user=sail lanlist_app php artisan inertia:stop-ssr 2> /dev/null
	npm run dev

reverb_start:
	@echo "Starting Reverb..."
	docker compose -f compose.yaml exec --user=sail lanlist_app php artisan reverb:start --debug --no-interaction --port=8080 --host=0.0.0.0

reverb_restart:
	@echo "Restarting Reverb..."
	docker compose -f compose.yaml exec --user=sail lanlist_app php artisan reverb:restart
