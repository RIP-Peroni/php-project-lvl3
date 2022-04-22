start:
	php artisan serve

watch:
	npm run watch

migrate:
	php artisan migrate

console:
	php artisan tinker

log:
	#tail -f storage/logs/laravel.log
	heroku logs --tail

test:
	php artisan test

deploy:
	git push heroku main

lint:
	composer exec phpcs app routes tests

lint-fix:
	composer exec phpcbf app routes tests

setup:
	composer install
	cp -n .env.example .env|| true
	php artisan key:gen --ansi
	touch database/database.sqlite
	php artisan migrate
	php artisan db:seed
	npm install
