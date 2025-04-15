<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


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
            'picture' => '/users/dlsanjkd.jpeg',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@lotus.com',
            'password' => bcrypt(value: '12345'),
            'picture' => '/users/dasfasfa.jpeg',
        ]);

        \App\Models\User::factory(15)->create();
        \App\Models\PostCategory::factory(2)->create();
        \App\Models\Post::factory(30)->withPostCategory()->create();
        \App\Models\ProductCategory::factory(2)->create();
        \App\Models\Product::factory(4)->withProductCategory()->create();
        \App\Models\Collaborator::factory(3)->create();
        \App\Models\Events::factory(5)->withCollaborators()->create();

        DB::table('settings')->insert([
            'hero_text_1' => 'Welcome to Lotus',
            'hero_text_2' => 'Your one-stop solution for all needs',
            'hero_text_3' => 'Quality, Service, and Innovation',
            'shop_text_1' => 'Shop with us for the best products',
            'shop_text_2' => 'Discover our wide range of offerings',
            'shop_text_3' => 'Personalizeaza-ti energia acum!',
            'mission_text' => 'Our mission is to provide the best service to our customers.',
            'mission_bullets' => json_encode([
                'Quality products',
                'Fast delivery',
                'Customer satisfaction',
                'Innovative solutions',
                'Affordable prices',
                'Eco-friendly options',
                'Strong customer support',
                'Continuous improvement'
            ]),
            'about_text' => 'We are a company dedicated to innovation and customer service.',
            'selected_blog_posts' => json_encode([1, 2, 3]), // Example post IDs
            'selected_products' => json_encode([1, 2, 3, 4]), // Example product IDs
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
