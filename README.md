# Pages module for Laravel Nova

Easily create custom pages in Nova using repeaters blocks for content. See documentation for [Repeater Blocks](https://github.com/dewsign/nova-repeater-blocks) for details.

Pages can be nested (as many levels deep as required), e.g. `/page-one/page-two/page-three/page-four` and a page can have any number of child pages.

## Installation

`composer require dewsign/nova-pages`

Run the migrations

```sh
php artisan migrate
```

Load the tool in your NovaServiceProvider.php

```php
public function tools()
{
    return [
        ...
        new \Dewsign\NovaPages\Nova\NovaPagesTool,
        ...
    ];
}
```

## Templates

The packages doesn't come with any pre-made templates. Simply replace the published `show` view or create new templates inside the `templates` folder. When more than one template exists, a select option will be displayed within nova where you can select the template for the page.

## Configuration

### Repeaters

Add additional repeater blocks by adding it to the nova pages config

```php
'repeaters' => [
    'More\Repeaters'
],
```

Or remove all standard repeaters and use your own selection.

```php
'replaceRepeaters' => true,
```

### Homepage / Default page

You can define which page slug should be loaded as the homepage, accessible at `/`, unless you already have a custom route defined.

```php
'homepageSlug' => 'homepage',
```

### Customisation

If you want more control, you can specify which Nova Resource and Page model to use. Because of the way nova reads the model from a static variable you must provide your own custom resource if you want to use a custom model.

```php
'models' => [
    'page' => 'App\Page',
],
'resources' => [
    'page' => 'App\Nova\Page',
],
```

### Nova Resource Group

```php
'group' => 'Pages',
```

You can customise the nova resource group.

## Routing

This package makes use of a catch-all route, so any url not cought by the applications web routes will be captured and processed to find a page matching the slug. So all pages are accessible without any specific prefix.

## Factories & Seeders

The package comes with pre-made factories and seeders. Should you wish to include them in your application simply call the seeder or use the factory provided.

```php
// database/seeds/DatabaseSeeder.php

public function run()
{
    $this->call(Dewsign\NovaPages\Database\Seeds\PageSeeder::class);
}
```

## Permissions

A PagePolicy is included, but not loaded by default, for [Brandenburg](https://github.com/Silvanite/brandenburg) / [Nova Tool](https://github.com/Silvanite/novatoolpermissions). Simply load the AuthServiceProvider from this package.

```php
// config/app.php

'providers' => [
    ...
    Dewsign\NovaPages\Providers\AuthServiceProvider::class,
],
```

## Domain Maps

You can map sub-domain (e.g. careers.mydomain.com) to Pages to automatically remove the slug and serve it on the domain instead by adding the slugs to the `domainMap` array in the configuration file.

```php
return [
    ...
    'domainMap' => [
        'careers',
    ],
];
```

If you create a page with the `careers` slug, this and any sub-pages will be served on the sub-domain with the base slug removed. E.g. `mydomain.com/careers/vacancies` will become `careers.mydomain.com/vacancies`.

NOTE: The domain name routing is not handled by this package, only the removal of the slug, your application will need to take care of the domain name handling.
