
# PHP How-Old Crawler
[![Join the chat at https://gitter.im/smochin/how-old-php-crawler](https://badges.gitter.im/smochin/how-old-php-crawler.svg)](https://gitter.im/smochin/how-old-php-crawler?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![Total Downloads](https://img.shields.io/packagist/dt/smochin/how-old-php-crawler.svg?style=flat-square)](https://packagist.org/packages/smochin/how-old-php-crawler)
[![Latest Stable Version](https://img.shields.io/packagist/v/smochin/how-old-php-crawler.svg?style=flat-square)](https://packagist.org/packages/smochin/how-old-php-crawler)
![Branch master](https://img.shields.io/badge/branch-master-brightgreen.svg?style=flat-square)
[![Build Status](https://img.shields.io/travis/smochin/how-old-php-crawler/master.svg?style=flat-square)](http://travis-ci.org/#!/smochin/how-old-php-crawler)

A simple PHP Crawler for [how-old.net](https://how-old.net).

## Installation
Package is available on [Packagist](http://packagist.org/packages/smochin/how-old-php-crawler),
you can install it using [Composer](http://getcomposer.org).

```shell
composer require smochin/how-old-php-crawler
```

### Dependencies
- PHP 7
- json extension
- cURL extension

## Get started

### Initialize the Crawler
```php
$crawler = new Smochin\HowOld\Crawler();
```

### Analyze image
```php
$result = $crawler->analyze('https://pbs.twimg.com/profile_images/558109954561679360/j1f9DiJi.jpeg');
```
