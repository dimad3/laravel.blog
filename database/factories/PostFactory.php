<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->realText(50),
        // 'slug' => $faker->slug(2),
        'description' => $faker->sentences(2, true),
        // BUG - paragraphs()
        // https://laracasts.com/discuss/channels/laravel/seeding-problem-array-to-string-conversion
        // $faker->paragraphs($number -of- paragraphs, $true -for-string return);
        'content' => $faker->paragraphs(7, true),
        'category_id' => $faker->randomElement([19, 20, 22, 23, 26]),
        'views' => $faker->numberBetween(1, 20),
        'thumbnail' => $faker->imageUrl(800, 600, 'cats'),
        'created_at' => $faker->dateTimeBetween('-2 months'),
        'updated_at' => now()
    ];
});
