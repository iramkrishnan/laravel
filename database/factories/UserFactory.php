<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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
        'password' => bcrypt('12345678'),
        'remember_token' => Str::random(10),
        'api_token' => Str::random(40),
    ];
})->afterCreating(User::class, function ($user) {
    factory(Post::class, 1)->make()
        ->each(function (Post $post) use ($user) {
            $post->user_id = $user->id;
            $post->save();
        });
});

$factory->afterCreating(User::class, function ($user) {
    $user->posts()->save(factory(Post::class)->make([
        'user_id' => $user->id,
    ]));
});

$factory->state(User::class, 'admin', function ($faker) {
    return [
        'role' => 'admin',
        'name' => $faker->name,
    ];
});

$factory->state(User::class, 'seller', [
    'role' => 'seller',
]);

$factory->state(User::class, 'customer', [
    'role' => 'customer',
]);

$factory->state(User::class, 'customer_with_posts', [
    'role' => 'customer',
])->afterCreatingState(User::class, 'customer_with_posts', function (User $user) {
    factory(Post::class, 1)->make()
        ->each(function (Post $post) use ($user) {
            $post->user_id = $user->id;
            $post->save();
        });
});


$factory->afterCreatingState(User::class, 'seller', function (User $user) {
    factory(Post::class, 1)->make()
        ->each(function (Post $post) use ($user) {
            $post->user_id = $user->id;
            $post->save();
        });
});
