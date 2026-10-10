# websk/php-view

PHP view rendering utilities. The package supports PHP 8.3 and newer, including PHP 8.5.

## Installation

```bash
composer require websk/php-view
```

## Configuration

Configure the site and asset paths before rendering views:

```php
use WebSK\Config\ConfWrapper;

ConfWrapper::setConfig([
    'site_full_path' => '/var/www/my-site',
    'site_title' => 'My site',
    'short_site_title' => 'Site',
    'assets_url_path' => '/assets',
    'assets_version' => 1,
]);
```

`site_full_path`, `site_title`, `short_site_title`, and `assets_url_path` must be strings. `assets_version` may be an integer or string. Invalid values result in an `UnexpectedValueException`.

## Usage

Render a PHP template to a string:

```php
use WebSK\Views\PhpRender;

$html = PhpRender::renderTemplate(
    '/var/www/my-site/views/page.php',
    ['title' => 'Example']
);
```

Add a versioned asset URL:

```php
use WebSK\Views\Assets;

$url = Assets::wrapAssetsVersion('css/app.css');
// /assets/1/css/app.css
```

## Development

Run all checks on PHP 8.5 with:

```bash
composer check
```

Individual checks are available as `composer lint`, `composer test`, and `composer phpstan`.
