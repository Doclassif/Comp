<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 1)->create();
        factory(App\User::class,'user1', 5)->create();
        factory(App\User::class,'user2', 15)->create();
        factory(App\User::class,'user3', 75)->create();
        factory(App\User::class,'user4', 654)->create();

    }
}
