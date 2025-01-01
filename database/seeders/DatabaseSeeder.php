<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@lotus.com',
            'password' => bcrypt('12345'),
            // 'picture' => '/users/dlsanjkd.jpeg',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@lotus.com',
            'password' => bcrypt(value: '12345'),
            'picture' => '/users/dasfasfa.jpeg',
        ]);

        \App\Models\User::factory(15)->create();
        \App\Models\PostCategory::factory(20)->create();
        \App\Models\Post::factory(150)->withPostCategory()->create();
        \App\Models\ProductCategory::factory(20)->create();
        \App\Models\Product::factory(150)->withProductCategory()->create();
        \App\Models\Collaborator::factory(150)->create();
        \App\Models\Events::factory(10)->withCollaborators()->create();
    }
}
