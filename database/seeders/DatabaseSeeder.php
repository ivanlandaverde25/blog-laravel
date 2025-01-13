<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Juan Poderoso Mendoza',
            'email' => 'juan@gmail.com',
            'password' => bcrypt('123456789'),
        ]);
        
        User::factory(20)->create();
        Category::factory(5)->create();
        Post::factory(100)->create();
        
        $this->call(TagSeeder::class);
        
    }
}
