# github-dashboard

## Requirements

* [Docker (tested with version 17.05.0-ce)](https://docs.docker.com/install/)
* [Docker Compose (tested with version 1.21.0)](https://docs.docker.com/compose/install/)

## Installation

### 1. .env

Copy the `.env.dist` file and set the GitHub token that will be used by github-dashboard when interacting with GitHub's API.

```
cp .env.dist .env
```

### 2. Docker

```
docker-compose up -d
```

### 3. Composer

```
docker-compose exec -u $(id -u):$(id -g) php-apache composer install
```

### 4. Doctrine

```
docker-compose exec -u $(id -u):$(id -g) php-apache php bin/console doctrine:schema:create
docker-compose exec -u $(id -u):$(id -g) php-apache php bin/console doctrine:database:import ./sql/drop_table_repository_view.sql
docker-compose exec -u $(id -u):$(id -g) php-apache php bin/console doctrine:database:import ./sql/create_view_repository_view.sql
```

### 5. Yarn

```
docker-compose run -u $(id -u):$(id -g) node yarn install
```

### 6. Webpack

```
docker-compose run -u $(id -u):$(id -g) node ./node_modules/.bin/encore dev
```

## Usage

### 1. Fetch

```
docker-compose exec php-apache php bin/console app:repository:fetch ${organizationName}
docker-compose exec php-apache php bin/console app:repository:commit:compare:fetch
docker-compose exec php-apache php bin/console app:pull-request:fetch
```

### 2. Browse

```
x-www-browser "http://$(docker container inspect --format '{{ range .NetworkSettings.Networks }}{{ .IPAddress }}{{ end }}' $(docker container list --format '{{ .Names }}' --filter 'name=php-apache'))"
```

### 3. Reset everything

```
docker-compose exec -u $(id -u):$(id -g) php-apache php bin/console doctrine:database:drop --force
docker-compose exec -u $(id -u):$(id -g) php-apache php bin/console doctrine:database:create
```

Then re-run the Doctrine installation procedure given above.

## Development

### Tests

```
docker-compose exec -u $(id -u):$(id -g) php-apache ./vendor/bin/simple-phpunit --coverage-html ./var/phpunit-coverage-html
```
