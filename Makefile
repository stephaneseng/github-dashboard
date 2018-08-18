build: build-docker-compose

build-docker-compose:
	docker-compose up -d

install: install-php-composer install-php-doctrine install-js-yarn install-js-webpack

install-php-composer:
	docker-compose exec -u $(shell id -u):$(shell id -g) php-apache composer install

install-php-doctrine:
	docker-compose exec -u $(shell id -u):$(shell id -g) php-apache php bin/console doctrine:schema:create
	docker-compose exec -u $(shell id -u):$(shell id -g) php-apache php bin/console doctrine:database:import ./sql/drop_table_repository_view.sql
	docker-compose exec -u $(shell id -u):$(shell id -g) php-apache php bin/console doctrine:database:import ./sql/create_view_repository_view.sql

install-js-yarn:
	docker-compose run -u $(shell id -u):$(shell id -g) node yarn install

install-js-webpack:
	docker-compose run -u $(shell id -u):$(shell id -g) node ./node_modules/.bin/encore dev

run: build

reset:
	docker-compose exec -u $(shell id -u):$(shell id -g) php-apache php bin/console doctrine:database:drop --force
	docker-compose exec -u $(shell id -u):$(shell id -g) php-apache php bin/console doctrine:database:create

test:
	docker-compose exec -u $(shell id -u):$(shell id -g) php-apache ./vendor/bin/simple-phpunit --coverage-html ./var/phpunit-coverage-html
