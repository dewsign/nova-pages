# Pages module for Laravel Nova

Easily create custom pages in Nova using repeaters blocks for content. See documentation for [Repeater Blocks](https://github.com/dewsign/nova-repeater-blocks) for details.

Pages can be nested (as many levels deep as required), e.g. `/page-one/page-two/page-three/page-four` and a page can have any number of child pages.

Even though this package does not provide any kind of layout or design, the Page model makes use of various traits and base model of the Maxfactor Laravel Support package to provide a lot of common functionality typically expected with public facing web pages, including Search Engine Optimisation (SEO). See the [Maxfactor Laravel Support](https://github.com/dewsign/maxfactor-laravel-support) repo for more information.

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

## Default Fields

| Title | Description |
| ----- | ----------- |
| Active | A boolean toggle to determine if a page should be treated as active. Inactive pages can still be accessed by default. A scope is provided to help filter these. E.g. `Page::active()->get()`. |
| Featured | A boolean toggle to determine if a page should be treated as featured. Use the provided scope to access them if suitable to do so in a specific situation. `Page::featured()->get()` |
| Priority | A numeric field which can be used as a way of sorting and prioritising pages. Use the scopes `Page::highToLow()->get()` or `Page::lowToHigh()->get` to sort by priority. |
| Name | The name of the page, accessible via the `name` attribute  |
| Slug | Auto-completed from the name but can be customised. This defines the url used to access the page. E.g. `mydomain.com/slug` |
| Parent | Lookup field to assign the current page to a parent page. |
| Image | A default image for this page. Not output anywhere by default. Access via the `image` attribute. |
| Summary | A free text field to provide a summary |
| H1 | An option to define unique text for the page's H1. Default to the name field on first save. |
| Browser Title | An option to define unique text for the page's browser title. Default to the name field on first save. |
| Nav Title | An option to define unique text for the page's navigation title. Default to the name field on first save. |
| Meta Description | An option to define unique text for the page's meta description. |

Using the provided scopes makes for a nice fluent API to lookup pages.  
E.g. `Page::active()->featured()->highToLow()->take(3)->get()`.

## Templates

The packages doesn't come with any pre-made templates. Simply replace the published `resources/views/vendor/nova-pages/show.blade.php` view or create new templates inside the `resources/views/vendor/nova-pages/templates` folder. When more than one template exists, a select option will be displayed within nova where you can select the template for the page.

## Configuration

### Repeaters

Nova Pages will use the Repeater Blocks defined in the [Nova Repeater Blocks](https://github.com/dewsign/nova-repeater-blocks) package config by default and you can add additional repeater blocks by adding them to the nova-pages config file.

```php
'repeaters' => [
    'More\Repeaters'
],
```

Alternatively you can remove all standard repeaters and use your own selection.

```php
'replaceRepeaters' => true,
```

### Homepage / Default page

You can define which page slug should be loaded as the homepage, accessible at `/`, unless you already have a custom route defined, in which case Nova Pages will **not** assign the homepage route!

In the below example, creating a Page with the `homepage` slug will be served as the default page when accessing the website.

```php
'homepageSlug' => 'homepage',
```

### Customisation

If you want more control, you can specify which Nova Resource and Page model to use. Because of the way nova reads the model from a static variable you **must** provide your own custom resource if you want to use a custom model.

In all cases, these should extend the default Page models and resource in this package.

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

You can customise where you want the Pages resource to appear inside Laravel Nova. By default it will sit all by itself in a Pages section.

## Routing

This package makes use of a catch-all route, so any url not caught by the applications web routes will be captured and processed to find a page matching the slug. This allows us to make all pages are accessible without any specific prefix.

A 404 error will be thrown if no matching page was found.

## Factories & Seeders

The package comes with pre-made factories and seeders. Should you wish to include them in your application simply call the seeder or use the factory provided to populate your database with some sample content.

```php
// database/seeds/DatabaseSeeder.php

public function run()
{
    $this->call(Dewsign\NovaPages\Database\Seeds\PageSeeder::class);
}
```

## Domain Maps

You can map sub-domains (e.g. careers.mydomain.com) to Pages to automatically serve pages matching the base slug, and any child pages, on this domain. Any number of sub-domains are supported by adding the slugs to the `domainMap` array in the configuration file.

**Important**: If you are using domain maps, you must set the `rootDomain` in your config or provided env lookup for `ROOT_DOMAIN`. E.g. `mydomain.com`.

```php
return [
    ...
    'domainMap' => [
        'careers',
    ],
];
```

Int he above example, if you create a Page with the `careers` slug, this and any sub-pages will be served on the sub-domain with the base slug removed. E.g. `mydomain.com/careers/vacancies` will become `careers.mydomain.com/vacancies`.

*Important: You will need to ensure that any non-page routes go to the the correct domain name. We recommend always routing to full URLs rather than relative path.*

We provide two route helpers, you can safely use the `pages.show` route name if you are not using domain maps at all. If you are using domain maps, you can use the `domain.pages.show` helper which accepts an additional domain parameter.

```php
route('pages.show', ['path' => 'careers']);
// https://mydomain.com/careers

route('domain.pages.show', ['domain' => 'careers', 'path' => 'vacancies']);
// https://careers.mydomain.com/vacancies
```

## Permissions

A PagePolicy is included, but not loaded by default, for the [Nova Permissions Tool](https://github.com/Silvanite/novatoolpermissions), which uses [Brandenburg](https://github.com/Silvanite/brandenburg) under the hood. Simply load the AuthServiceProvider from this package to make use of this or ignore this if you are using an alternative permissions library.

```php
// config/app.php

'providers' => [
    ...
    Dewsign\NovaPages\Providers\AuthServiceProvider::class,
],
```

## Helpers

### Meta pages

When working with sections of your application which are routed to their own controllers you may still want to allow users to add additional content and manage meta information through the UI. You can include the provided `meta` helper to retrieve this meta data from Pages.

```php
$page = Page::meta('page-slug', 'Default Text');
```

Will return the Page model if a matching page is found, otherwise will return an array with defaults ...

```php
[
    'page_title' => 'Default Text',
    'browser_title' => 'Default Text',
    'meta_description' => 'Default Text',
    'h1' => 'Default Text',
];
```

Use the meta page to provide this content to the front-end means you can re-use a lot of code across all sections of your site to keep things consistent and benefit from the included SEO value.

### Language

You are able to change what html lang type the page will be on creation. You can enable this functionality by setting the `enableLanguageSelection` config value to `true`;

To implement this into your markup, we suggest adding this to your `layouts.default` view:

```php
<html lang="{{ array_get($page ?? [], 'language', app()->getLocale()) }}">
```
