<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

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
function sexrand(){
    $rand = rand (0,1);
    if ($rand==1) $sex="men"; else $sex="women";
    return $sex;
}
$factory->define(User::class, function (Faker $faker) {
    $min = 1;
    $max = 1;
        return [
            'number_personnel' => $faker->unique()->numberBetween($min,$max),
            'image_url' => 'https://randomuser.me/api/portraits/'.sexrand().'/'.rand(1,80).'.jpg',
            'chief'=> true,
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'middle_name' => $faker->middleName,
            'position' => "Директор компании",
            'сhief_num' => rand(0, 0),
            'date_start_work' => $faker->date,
            'payday' => rand(500,5000),
            'email' => $faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt('123456'), // password
            'remember_token' => Str::random(10),
        ];
});

$factory->defineAs(User::class, 'user1', function (Faker $faker) {
    $min = 2;
    $max = 6;
        return [
            'number_personnel' => $faker->unique()->numberBetween($min,$max),
            'image_url' => 'https://randomuser.me/api/portraits/'.sexrand().'/'.rand(1,80).'.jpg',
            'chief'=> true,
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'middle_name' => $faker->middleName,
            'position' => $faker->jobTitle,
            'сhief_num' => rand(1, 1),
            'date_start_work' => $faker->date,
            'payday' => rand(500,5000),
            'email' => $faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt('123456'), // password
            'remember_token' => Str::random(10),
        ];
});

$factory->defineAs(User::class, 'user2', function (Faker $faker) {
    $min = 7;
    $max = 21;
        return [
            'number_personnel' => $faker->unique()->numberBetween($min,$max),
            'image_url' => 'https://randomuser.me/api/portraits/'.sexrand().'/'.rand(1,80).'.jpg',
            'chief'=> true,
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'middle_name' => $faker->middleName,
            'position' => $faker->jobTitle,
            'сhief_num' => rand(2, 6),
            'date_start_work' => $faker->date,
            'payday' => rand(500,5000),
            'email' => $faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt('123456'), // password
            'remember_token' => Str::random(10),
        ];
});

$factory->defineAs(User::class, 'user3', function (Faker $faker) {
    $min = 22;
    $max = 96;
        return [
            'number_personnel' => $faker->unique()->numberBetween($min,$max),
            'image_url' => 'https://randomuser.me/api/portraits/'.sexrand().'/'.rand(1,80).'.jpg',
            'chief'=> true,
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'middle_name' => $faker->middleName,
            'position' => $faker->jobTitle,
            'сhief_num' => rand(7, 21),
            'date_start_work' => $faker->date,
            'payday' => rand(500,5000),
            'email' => $faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt('123456'), // password
            'remember_token' => Str::random(10),
        ];
});


$factory->defineAs(User::class, 'user4', function (Faker $faker) {
    $min = 97;
    $max = 750;
        return [
            'number_personnel' => $faker->unique()->numberBetween($min,$max),
            'image_url' => 'https://randomuser.me/api/portraits/'.sexrand().'/'.rand(1,80).'.jpg',
            'chief'=> false,
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'middle_name' => $faker->middleName,
            'position' => $faker->jobTitle,
            'сhief_num' => rand(22, 96),
            'date_start_work' => $faker->date,
            'payday' => rand(500,5000),
            'email' => $faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt('123456'), // password
            'remember_token' => Str::random(10),
        ];
});
