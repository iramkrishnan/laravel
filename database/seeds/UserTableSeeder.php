<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->times(3)->states('admin')->create();
        factory(User::class, 5)->states('seller')->create();
        factory(User::class, 10)->states('customer')->create();
        factory(User::class, 1)->create();
    }
}
