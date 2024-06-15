# Unit Testing

## Introduction

This project uses phpunit for unit testing. The tests are located in the `tests` directory.

## Running php unit tests

To run the php unit tests use the following command:

```bash
php artisan test
```

## Running php unit tests with coverage

To run the php unit tests with coverage use the following command:

```bash
php artisan test --coverage-clover coverage/xml/cov.xml
```

In ofder to see the coverage report in vs code you can use the coverage gutters extension Watch button that is at the bottom of the vs code window.

## Running php unit tests with coverage and html report

To run the php unit tests with coverage and html report use the following command:

```bash
php artisan test --coverage-html coverage/html
```

The link to the html report: [coverage/html/index.html](/coverage/html/index.html)

To see the report in vs code you can use the coverage gutters extension. Use `shift + cmd + p` and type `Coverage Gutters: Preview Coverage Report` and press `enter`.
