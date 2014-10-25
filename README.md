# Projectplace OAuth PHP

Service wrapper for [Projectplace](https://www.projectplace.com/) OAuth 1.0 for
use with the [PHPOAuthLib library](https://github.com/Lusitanian/PHPoAuthLib) by
Lusitanian.

> PHPoAuthLib provides oAuth support in PHP 5.3+ and is very easy to integrate
> with any project which requires an oAuth client.

More about the [Projectplace API](http://api.projectplace.com/).

## Installation

This package will likely be added to [Packagist](https://packagist.org/) in a
coming release. In the meantime, I would recommend probably not using it yet.

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
