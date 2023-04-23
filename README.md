# Tende Pay API Library

[![GitHub Tests Workflow](https://github.com/DrH97/laravel-tendepay/actions/workflows/run-tests.yml/badge.svg)](https://github.com/DrH97/laravel-tendepay/actions/workflows/run-tests.yml)
[![Github Style Workflow](https://github.com/DrH97/laravel-tendepay/actions/workflows/fix-php-code-style-issues.yml/badge.svg)](https://github.com/DrH97/laravel-tendepay/actions/workflows/fix-php-code-style-issues.yml)
[![codecov](https://codecov.io/gh/DrH97/laravel-tendepay/branch/main/graph/badge.svg?token=6b0d0ba1-c2c6-4077-8c3a-1f567eea88a0)](https://codecov.io/gh/DrH97/laravel-tendepay)

[![Latest Stable Version](http://poser.pugx.org/drh/laravel-tendepay/v)](https://packagist.org/packages/drh/laravel-tendepay)
[![Total Downloads](http://poser.pugx.org/drh/laravel-tendepay/downloads)](https://packagist.org/packages/drh/laravel-tendepay)
[![License](http://poser.pugx.org/drh/laravel-tendepay/license)](https://packagist.org/packages/drh/laravel-tendepay)
[![PHP Version Require](http://poser.pugx.org/drh/laravel-tendepay/require/php)](https://packagist.org/packages/drh/laravel-tendepay)

## Installation

You can install the package via composer:

```bash
composer require drh/laravel-tendepay
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-tendepay-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-tendepay-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$tendePay = new DrH\TendePay();
echo $tendePay->echoPhrase('Hello, DrH!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Dr H](https://github.com/DrH97)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
