<?php

use App\User;
use App\Post;
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
        factory(User::class)->times(1)->states('admin')->create();
        factory(User::class, 1)->states('seller')->create();
        factory(User::class, 1)->states('customer')->create();

        factory(User::class, 1)->states('customer_with_posts')->create();

        factory(User::class, 1)->states('admin')->create()
            ->each(function (User $user) {
                factory(Post::class, 1)->make()
                    ->each(function (Post $post) use ($user){
                        $post->user_id = $user->id;
                        $post->save();
                    });
            });
    }
}
