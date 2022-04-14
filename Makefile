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
	heroku logs

test:
	php artisan test

deploy:
	git push heroku main

lint:
	composer phpcs

lint-fix:
	composer phpcbf

setup:
	composer install
	cp -n .env.example .env|| true
	php artisan key:gen --ansi
	touch database/database.sqlite
	php artisan migrate
	php artisan db:seed
	npm install
