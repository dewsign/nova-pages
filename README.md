# Pages module for Laravel Nova

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
