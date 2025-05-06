PROJECT_NAME=milkshop

up:
	docker compose up -d

down:
	docker compose down

build:
	docker compose build

artisan:
	docker compose exec app php artisan $(filter-out $@,$(MAKECMDGOALS))

composer:
	docker compose exec app composer $(filter-out $@,$(MAKECMDGOALS))

npm:
	docker compose exec app npm $(filter-out $@,$(MAKECMDGOALS))

migrate:
	docker compose exec app php artisan migrate

seed:
	docker compose exec app php artisan db:seed

logs:
	docker compose logs -f

install:
	docker compose run --rm app composer create-project laravel/laravel ./src

.PHONY: up down build artisan composer npm migrate seed logs install fix-perms artisan-clear-cache

fix-perms:
	docker compose exec app chown -R www-data:www-data .
	docker compose exec app chmod -R 775 .

artisan-clear-cache:
	docker compose exec app php artisan cache:clear
	docker compose exec app php artisan config:clear
	docker compose exec app php artisan route:clear
	docker compose exec app php artisan view:clear

