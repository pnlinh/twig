# Twig Engine

Allows you to use [Twig](https://twig.symfony.com/) in [Laravel](https://laravel.com/).

[![Build Status](https://api.travis-ci.org/dinhquochan/twig.svg)](https://travis-ci.org/dinhquochan/twig)
[![Total Downloads](https://poser.pugx.org/handinh/twig/d/total.svg)](https://packagist.org/packages/handinh/twig)
[![Latest Stable Version](https://poser.pugx.org/handinh/twig/v/stable.svg)](https://packagist.org/packages/handinh/twig)
[![License](https://poser.pugx.org/handinh/twig/license.svg)](https://packagist.org/packages/handinh/twig)

## Requirements

- PHP >= 7.1.5
- Laravel >= 5.5.*

## Installation

Require this package with composer.

```bash
composer require handinh/twig
```

If you don't use auto-discovery, add the ServiceProvider to the providers array in config/app.php

```php
\Qh\Twig\TwigServiceProvider::class,
```

If you want to use the facade to extended twig extensions, add this to your facades in app.php:

```php
'Twig' => \Qh\Twig\Facades\Twig::class,
```

To publishes config `config/twig.php`, use command:

```bash
php artisan vendor:publish --tag="twig-config"
```
## Usage

You call the Twig template like you would any other view:

```php
// Normal
return view('template', ['some_variable' => 'some_values]);

// With vender namespace
return view('vendor_namespace::template', $data);
```

Read more in [Twig for Template Designers](https://twig.symfony.com/doc/2.x/templates.html) or [Laravel Views](https://laravel.com/docs/5.7/views).

### Available Extensions

| Name  | Status |
| :--- | :---: |
| Url  | ✔ |
| Collection | ✔ |
| String | ✔ |
| Math | 🍔 |
| Config | 🍔 |
| Request | 🍔 |
| Session | 🍔 |
| Auth | 🍔 |
| Authorization | 🍔 |
| Translation | 🍔 |
| Debug | 🍔 |

### Available Functions

TO DO

### Available Filters

| Extension  | Filters |
| :--- | :--- |
| Url  | `action`, `route`, `url`, `secure_url`, `asset`, `secure_asset` |
| Collection  | `join`, `first`, `last`, `concat`, `merge`, `map`, `reverse`, `length`, `size`, `sort`, `sort_desc`, `unique` |
| String | `append`, `prepend`, `camelcase`, `camel_case`, `kebabcase`, `kebab_case`, `snakecase`, `snake_case`, `studlycase`, `studly_case`, `capitalize`, `downcase`, `lower`, `upcase`, `upper`, `handle`, `handleize`, `slug`, `base64_encode`, `base64_decode` `md5`, `sha1`, `sha256`, `hmac_sha1`, `hmac_sha256`, `newline_to_br`, `nl2br`, `pluralize`, `remove`, `remove_first`, `replace`, `replace_first`, `slice`, `split`, `strip`, `rstrip`, `lstrip`, `strip_html`, `striptags`, `strip_newlines`, `truncate`, `url_encode`, `url_decode`, `json`, `reverse`, `str_*` (Laravel String Helpers starts with `str_`)

### Available Globals

TO DO

### Available Tags

TO DO

### Extending Twig

Twig allows you to define your own filters, functions, globals, tags or extensions using the addExtension method.

The following example creates a `money` filter which formats a number, which should be an instance of int or float:

```php
<?php

namespace App\Providers;

use Twig\TwigFilter;
use Qh\Twig\Facades\Twig;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        Twig::addFilter(new TwigFilter('money', 'number_format'));
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
```

Read more in: [Extending Twig](https://twig.symfony.com/doc/2.x/advanced.html).

### Artisan Commands

TO DO

## Links

- [Twig Reference](https://twig.symfony.com/doc/2.x/)
