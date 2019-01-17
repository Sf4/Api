# Api

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Simple rest API for Symfony 4

## Structure

If any of the following are applicable to your project, then the directory structure should follow industry best practices by being named the following.

```
bin/        
config/
src/
tests/
vendor/
```


## Install

Via Composer

``` bash
$ composer require Sf4/Api
```

## Usage

``` php
$skeleton = new Sf4\Api();
echo $skeleton->echoPhrase('Hello, League!');
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email siim.liimand@gmail.com instead of using the issue tracker.

## Credits

- [Siim Liimand][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/Sf4/Api.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/Sf4/Api/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/Sf4/Api.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/Sf4/Api.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/Sf4/Api.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/Sf4/Api
[link-travis]: https://travis-ci.org/Sf4/Api
[link-scrutinizer]: https://scrutinizer-ci.com/g/Sf4/Api/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/Sf4/Api
[link-downloads]: https://packagist.org/packages/Sf4/Api
[link-author]: https://github.com/siimliimand
[link-contributors]: ../../contributors
