<?php

namespace Database\Seeders;

use App\Models\M_Post;
use App\Models\M_PostComment;
use App\Models\M_PostLike;
use App\Models\M_User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class S_Post extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $faker = Factory::create();
    // foreach (range(1, 20) as $value) {
    //   $user = M_User::inRandomOrder()->first();

    //   $post = M_Post::create([
    //     'user_id' => $user->id,
    //     'image' => "https://source.unsplash.com/random/?city,night&{$value}",
    //     'content' => $faker->paragraph(10),
    //   ]);

    //   // LIKES
    //   $likesCount = $faker->numberBetween(1, 5);
    //   for ($i = 0; $i < $likesCount; $i++) {
    //     $liker = M_User::inRandomOrder()->first();

    //     $like = new M_PostLike([
    //       'post_id' => $post->id,
    //       'user_id' => $liker->id,
    //     ]);
    //     $like->save();
    //   }

    //   // COMMENTS
    //   $commentsCount = $faker->numberBetween(1, 20);
    //   for ($i = 0; $i < $commentsCount; $i++) {
    //     $commenter = M_User::inRandomOrder()->first();

    //     $comment = new M_PostComment([
    //       'post_id' => $post->id,
    //       'user_id' => $commenter->id,
    //       'content' => $faker->paragraph(2)
    //     ]);
    //     $comment->save();
    //   }
    // }
  }
}
