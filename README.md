# Elementor Datepicker Localization

Load current site locale for Elementor form datepicker.

## Installation

#### Composer:

**Recommended method**, [Roots Bedrock](https://roots.io/bedrock/) and [WP-CLI](http://wp-cli.org/)
```shell
$ composer require creame/elementor-datepicker-localization
$ wp plugin activate elementor-datepicker-localization
```

#### Manual:

* Download the [zip file](https://github.com/creame/creame/elementor-datepicker-localization/archive/master.zip)
* Unzip to your sites plugin folder
* Activate via WordPress

#### WP-CLI:

```shell
$ wp plugin install https://github.com/creame/elementor-datepicker-localization/archive/master.zip --activate
```

#### Requirements:

* [PHP](http://php.net/manual/en/install.php) >= 7.x
* [Wordpress](https://wordpress.org/download/) >= 4.7
* [Elementor](https://wordpress.org/plugins/elementor/) >= 2.x

## Usage

Install, activate and ready!

## Filters

You can change localization language with filter `'elementor/datepicker/locale'` or date format with filter `'elementor/datepicker/format'`.

Place on your themes functions.php file.

```php
// Example, force 'es' language
add_filter( 'elementor/datepicker/locale', function(){ return 'es'; } );

// Example, change date format to dd/mm/yyyy
add_filter( 'elementor/datepicker/format', function(){ return 'd/m/Y'; } );
```

## Support

* Follow [@creapuntome](https://twitter.com/creapuntome) on Twitter
* Donate [https://www.paypal.me/creapuntome/](https://www.paypal.me/creapuntome/)

## Changelog

### 1.0.0 - 20 November 2019
* Initial release
