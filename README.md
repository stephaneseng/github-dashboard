# github-dashboard

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
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

## Usage

### Fetch

```
php bin/console app:repository:fetch ${organizationName}
php bin/console app:repository:commit:compare:fetch
```

```
php bin/console server:run
```
