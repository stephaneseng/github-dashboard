# github-dashboard

## Requirements

* PHP 7

## Installation

### .env

```
###> doctrine/doctrine-bundle ###
DATABASE_URL=sqlite:///%kernel.project_dir%/var/data.db
###< doctrine/doctrine-bundle ###

###> knplabs/github-api ###
GITHUB_AUTH_METHOD=http_password
GITHUB_USERNAME=username
GITHUB_SECRET=password_or_token
###< knplabs/github-api ###
```

### composer

```
composer install
```

### Doctrine

```
php bin/console doctrine:database:create
php bin/console doctrine:schema:create
```

## Usage

### Fetch

```
php bin/console app:repository:fetch ${organizationName}
php bin/console app:repository:commit:compare:fetch
php bin/console app:pull-request:fetch
```

### Data extract

```sql
SELECT r.id, r.full_name, r.pushed_at, rcc.status, rcc.ahead_by, COUNT(pr.id) opened_pull_requests
FROM repository r
LEFT JOIN repository_commit_compare rcc ON rcc.repository_id = r.id
LEFT JOIN pull_request pr ON pr.repository_id = r.id AND pr.state = 'open'
WHERE r.archived = 0
GROUP BY r.id
```

### Front-end

```
php bin/console server:run
```
