<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->admin()->create([
            'name' => 'Admin User',
            'email' => 'admin@test',
        ]);

        User::factory(25)->create()->each(function (User $user) {
            $numberOfPosts = rand(1, 5);
            Post::factory()->count($numberOfPosts)->create([
                'user_id' => $user->id,
            ])->each(function (Post $post) use ($user) {
                $numberOfComments = rand(1, 10);
                Comment::factory()->count($numberOfComments)->create([
                    'user_id' => fn() => User::inRandomOrder()->first()->id,
                    'post_id' => $post->id,
                ]);
            });
        });
    }
}
