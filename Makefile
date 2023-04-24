init: \
	setup-env \
	docker-clean \
	docker-up \
	composer-install \

up: docker-up

stop: docker-stop

lint: \
	composer-validate \
	php-cs-fixer

docker-clean:
	docker-compose down -v --remove-orphans

docker-up:
	docker-compose up --build -d

docker-stop:
	docker-compose stop

setup-env:
	cp .env .env.local

composer-install:
	docker-compose run --rm fpm composer install

composer-update:
	docker-compose run --rm fpm composer update

composer-validate:
	docker-compose run --rm fpm composer validate --no-check-all

php-cs-fixer:
	docker-compose run --rm fpm bin/php-cs-fixer fix --dry-run --diff --show-progress=dots --allow-risky=yes -v

php-cs-fixer-fix:
	docker-compose run --rm fpm bin/php-cs-fixer fix --verbose --diff --show-progress=dots --allow-risky=yes

test:
	docker-compose run --rm fpm bin/phpunit --testsuite Unit,Feature
