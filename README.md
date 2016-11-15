# PHP Lua Serializer/Deserializer
[![Build](https://img.shields.io/scrutinizer/build/g/koesie10/UnitConverter.svg)](https://scrutinizer-ci.com/g/koesie10/UnitConverter)
[![Version](https://img.shields.io/packagist/v/koesie10/unit-converter.svg)](https://packagist.org/packages/koesie10/unit-converter)
[![License](https://img.shields.io/packagist/l/koesie10/unit-converter.svg)](https://packagist.org/packages/koesie10/unit-converter)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/koesie10/UnitConverter.svg)](https://scrutinizer-ci.com/g/koesie10/UnitConverter)
[![Code Quality](https://img.shields.io/scrutinizer/g/koesie10/UnitConverter.svg)](https://scrutinizer-ci.com/g/koesie10/UnitConverter)
[![Downloads](https://img.shields.io/packagist/dt/koesie10/unit-converter.svg)](https://packagist.org/packages/koesie10/unit-converter)

This is a SI unit converter for PHP, that will convert all kinds of units from one into the other, with support for composite units.

## Installation
Install with [Composer](http://getcomposer.org):

```
composer require koesie10/unit-converter
```

## Usage
Simply create a `\Vlaswinkel\UnitConverter\UnitConverter` object and call the `convert` method:

```php
$converter = new \Vlaswinkel\UnitConverter\UnitConverter();

echo $converter->convert('1', 'm/s', 'km/h'); // prints 3.6, as expected
```

This library will try to use BC math if it is available, which is highly recommended for more accurate results. In that case, it is recommended to always supply
strings to the convert function, otherwise there will still be floating point errors.

**Note**: If you do not get proper results, check that you have [set the scale](http://php.net/manual/en/bc.configuration.php) for BC math correctly.
It is recommended to set the value to at least 3, but for more precision, it is recommended to increase the value more.

If you would like to use the default PHP math functions, which will have floating point errors but will not require a scale, you can instantiate the `UnitConverter` as follows:
```php
$converter = new \Vlaswinkel\UnitConverter\UnitConverter(null, new \Vlaswinkel\UnitConverter\Math\DefaultMathWrapper());
```

## Running tests
You can run automated unit tests using [PHPUnit](http://phpunit.de) after installing dependencies:

```
vendor/bin/phpunit
```

## License
This library is licensed under the MIT license. See the [LICENSE](LICENSE) file for details.