<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use App\Post;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'content' => $faker->sentence,
        'image' => 'blog-2.jpg',
        'date' => '07/07/19',
        'views' => $faker->numberBetween(0,1000),
        'category_id' => 1,

        'user_id' => 1,
        'status' => 1,
        'is_featured' => 0
    ];
});

$factory->define(\App\Category::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
    ];
});
$factory->define(\App\Tag::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
    ];
});