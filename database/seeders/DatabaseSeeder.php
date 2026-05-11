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

        $reader1 = User::create([
            'name' => 'Akademik Okur',
            'email' => 'okur1@test.com',
            'password' => Hash::make('password'),
            'role' => 'reader',
        ]);

        $reader2 = User::create([
            'name' => 'Normal Kullanıcı',
            'email' => 'okur2@test.com',
            'password' => Hash::make('password'),
            'role' => 'reader',
        ]);

        $categoryBilim = Category::create(['name' => 'Bilim', 'slug' => 'bilim']);
        $categoryYazilim = Category::create(['name' => 'Yazılım', 'slug' => 'yazilim']);
        $categoryTeknoloji = Category::create(['name' => 'Teknoloji', 'slug' => 'teknoloji']);

    }
}