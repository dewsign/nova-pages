<?php

use Faker\Generator as Faker;
use Dewsign\NovaPages\Models\Page;

$factory->define(Page::class, function (Faker $faker) {
    return [
        'active' => $faker->boolean(90),
        'featured' => $faker->boolean(20),
        'name' => $name = "{$faker->company}",
        'slug' => str_slug($name),
        'image' => $faker->boolean(80) ? $faker->imageUrl($width = 640, $height = 480, 'business') : null,
        'summary' => $faker->realText(rand(70, 500)),
        'priority' => $faker->numberBetween(1, 100),
    ];
});
