# Bloggi

TBD

## Setting up development environment

### Requirements

- Docker
- Docker Compose
- PHP 8.1 + Composer

### Apply database migrations

To initialize the database, apply all the database migrations:

```shell
./bin/console migrations:migrate
``` 

### Optional: Seed database with example data

You can add example data to test the blog's functionality. This will also create a test user with credentials `test:password`.

```shell
./bin/console orm:fixtures:load
```

### Start the container

In the root directory, run:

```shell
docker-compose up
`````

The application should be available at `http://bloggi-sandbox.test`

## Testing

### Static analysis

This project uses PHPStan for static analysis, run it using:

```shell
./vendor/bin/phpstan analyze .
`````
