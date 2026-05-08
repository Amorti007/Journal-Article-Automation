<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Journal;
use App\Models\Issue;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Sistem Yöneticisi',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $editor = User::create([
            'name' => 'Dergi Editörü',
            'email' => 'editor@test.com',
            'password' => Hash::make('password'),
            'role' => 'editor',
        ]);

        $author = User::create([
            'name' => 'Akademik Yazar',
            'email' => 'yazar@test.com',
            'password' => Hash::make('password'),
            'role' => 'author',
        ]);

        $referee = User::create([
            'name' => 'Hakem Kullanıcı',
            'email' => 'hakem@test.com',
            'password' => Hash::make('password'),
            'role' => 'referee',
        ]);

        $categoryBilim = Category::create(['name' => 'Bilim', 'slug' => 'bilim']);
        $categoryYazilim = Category::create(['name' => 'Yazılım', 'slug' => 'yazilim']);
        $categoryTeknoloji = Category::create(['name' => 'Teknoloji', 'slug' => 'teknoloji']);

    }
}