<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Journal;
use App\Models\Issue;
use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Uygulama veritabanını test verileriyle doldurur.
     */
    public function run(): void
    {
        // 1. Kullanıcı Rollere Göre Örnek Kullanıcılar Oluşturma
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

        // 2. Örnek Dergi Oluşturma
        $journal = Journal::create([
            'name' => 'Mühendislik Bilimleri Dergisi',
            'issn' => '1234-5678',
            'description' => 'Yapay zeka ve yazılım mühendisliği odaklı akademik yayınlar.',
            'cover_image' => 'journal_cover_default.jpg'
        ]);

        // 3. Dergiye Ait Bir Sayı (Issue) Oluşturma
        $issue = Issue::create([
            'journal_id' => $journal->id,
            'volume' => 'Cilt 1',
            'number' => 'Sayı 1',
            'year' => 2026
        ]);

        // 4. Örnek Makaleler (Farklı Durumlarda)
        // Editör Onayında Bekleyen Makale
        Article::create([
            'user_id' => $author->id,
            'journal_id' => $journal->id,
            'title' => 'Laravel ile Mikroservis Mimarisi',
            'abstract' => 'Bu makalede modern PHP frameworkleri ile ölçeklenebilir sistemler incelenmiştir.',
            'status' => 'editor_review', 
        ]);

        // Hakem Değerlendirmesinde Olan Makale
        Article::create([
            'user_id' => $author->id,
            'journal_id' => $journal->id,
            'title' => 'Yapay Zeka ve Etik Sınırlar',
            'abstract' => 'Geleceğin dünyasında yapay zeka algoritmalarının etik boyutları.',
            'status' => 'peer_review',
        ]);
        
        // Kabul Edilmiş ve Sayıya Atanmış Makale
        Article::create([
            'user_id' => $author->id,
            'journal_id' => $journal->id,
            'issue_id' => $issue->id,
            'title' => 'Docker ve Konteyner Teknolojileri',
            'abstract' => 'Yazılım geliştirme süreçlerinde Docker kullanımının verimlilik analizi.',
            'status' => 'accepted',
        ]);
    }
}