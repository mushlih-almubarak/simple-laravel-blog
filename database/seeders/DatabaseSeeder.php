<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Mushlih Almubarak',
            'email' => 'mushlih2004@gmail.com',
            'password' => bcrypt('123Tes'),
            'username' => 'mushlih-almubarak',
            'role' => 'admin',
            'profile' => 'mushlih-almubarak.jpg',
            'email_verified_at' => now(),
            'ip_address' => fake()->ipv4,
            'country' => fake()->country,
            'city' => fake()->city
        ]);

        User::create([
            'name' => 'Syakira',
            'email' => fake()->email(),
            'password' => bcrypt('Tes123'),
            'username' => 'syakira',
            'profile' => 'syakira.jpg',
            'ip_address' => fake()->ipv4,
            'country' => fake()->country,
            'city' => fake()->city
        ]);

        User::create([
            'name' => 'Muhammad Alhadziq',
            'email' => fake()->email(),
            'password' => bcrypt('P12345'),
            'username' => 'muhammad-alhadziq',
            'profile' => 'hadziq.png',
            'ip_address' => fake()->ipv4,
            'country' => fake()->country,
            'city' => fake()->city
        ]);

        Category::create([
            'name' => 'Tak Berkategori',
            'name' => 'Tak Berkategori',
            'slug' => 'tak-berkategori'
        ]);

        Category::create([
            'name' => 'Programming',
            'name' => 'Programming',
            'slug' => 'programming'
        ]);

        Category::create([
            'name' => 'Personal',
            'name' => 'Personal',
            'slug' => 'personal'
        ]);

        Category::create([
            'name' => 'Web Desain',
            'name' => 'Web Desain',
            'slug' => 'web-desain'
        ]);

        Category::create([
            'name' => 'Tutorial',
            'name' => 'Tutorial',
            'slug' => 'tutorial'
        ]);

        User::factory(7)->create();
        Post::factory(100)->create();
    }
}
