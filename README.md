# github-dashboard

## Requirements

* [Docker (tested with version 17.05.0-ce)](https://docs.docker.com/install/)
* [Docker Compose (tested with version 1.21.0)](https://docs.docker.com/compose/install/)

## Installation

### 1. .env

```
cp .env.dist .env
```

### 2. Docker

```
docker-compose build
docker-compose up -d
```

### 3. Composer

```
docker-compose run -u $(id -u):$(id -g) composer install
```

### 4. Doctrine

```
docker-compose exec -u $(id -u):$(id -g) php-apache php bin/console doctrine:schema:create
```

## Usage

### 1. Fetch

```
docker-compose exec php-apache php bin/console app:repository:fetch ${organizationName}
docker-compose exec php-apache php bin/console app:repository:commit:compare:fetch
docker-compose exec php-apache php bin/console app:pull-request:fetch
```

### 2. Export data

```sql
SELECT r.id, r.full_name, r.pushed_at, rcc.status, rcc.ahead_by, COUNT(pr.id) opened_pull_requests
FROM repository r
  LEFT JOIN repository_commit_compare rcc ON rcc.repository_id = r.id
  LEFT JOIN pull_request pr ON pr.repository_id = r.id AND pr.state = 'open'
WHERE r.archived = FALSE
GROUP BY r.id, rcc.repository_id
```
