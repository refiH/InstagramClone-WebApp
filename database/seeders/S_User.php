<?php

namespace Database\Seeders;

use App\Models\M_User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class S_User extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $faker = Factory::create();

    M_User::create([
      'username' => 'refih15',
      'email' => 'refihikman06@gmail.com',
      'password' => Hash::make('refihikman123'),
      'image' => "https://i.pinimg.com/236x/f3/e3/b8/f3e3b88697ccdcb460103397619d1e86.jpg",
      'bio' => 'atmin',
      'is_admin' => true,
    ]);

    foreach (range(1, 5) as $value) {
      M_User::create([
        'username' => $faker->userName(),
        'email' => $faker->email(),
        'password' => Hash::make('password'),
        'image' => "https://source.unsplash.com/random/500x500/?random-object&{$value}",
        'bio' => $faker->paragraph(1),
        'is_admin' => false,
      ]);
    }
  }
}
