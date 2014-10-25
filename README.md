# Projectplace OAuth PHP

Service wrapper for [Projectplace](https://www.projectplace.com/) OAuth 1.0 for
use with the [PHPOAuthLib library](https://github.com/Lusitanian/PHPoAuthLib) by
Lusitanian.

> PHPoAuthLib provides oAuth support in PHP 5.3+ and is very easy to integrate
> with any project which requires an oAuth client.

More about the [Projectplace API](http://api.projectplace.com/).

[![Travis build status](http://img.shields.io/travis/crockett95/projectplaceoauth/master.svg?style=flat)](https://travis-ci.org/crockett95/projectplaceoauth)
[![Packagist License](http://img.shields.io/packagist/l/crockett95/projectplaceoauth.svg?style=flat)](https://packagist.org/packages/crockett95/projectplaceoauth)
[![Packagist Version](http://img.shields.io/packagist/v/crockett95/projectplaceoauth.svg?style=flat)](https://packagist.org/packages/crockett95/projectplaceoauth)
[![Packagist Downloads](http://img.shields.io/packagist/dt/crockett95/projectplaceoauth.svg?style=flat)](https://packagist.org/packages/crockett95/projectplaceoauth)

## Installation

The library is available on [Packagist](https://packagist.org/packages/crockett95/projectplaceoauth).
The recommended way to install it is with [composer](http://getcomposer.org).

Add as a dependency in `composer.json`:

```json
{
    "require": {
        "crockett95/projectplaceoauth": "~0.1"
    }
}
```

Or require with `composer`:

```bash
composer require crockett95/projectplaceoauth
```

## Usage

Use the `ServiceFactory::registerService` method from the PHPOAuthLib library to
register the new service.

```php
<?php
$serviceFactory = new \OAuth\ServiceFactory();
$serviceFactory->registerService('projectplace', 'Crockett95\\ProjectPlace\\OAuthService');
```

See the example for more information.

## Contributing

1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request :D

## Credits

Most of the code is a blatant ripoff of
[PHPOAuthLib library](https://github.com/Lusitanian/PHPoAuthLib).

## License

Released under the terms of the MIT license.
