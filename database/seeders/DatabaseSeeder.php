<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Journal;
use App\Models\Issue;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. KULLANICILARI OLUŞTUR
        $admin = User::create([
            'name' => 'Prof. Dr. Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'title' => 'Sistem Yöneticisi',
        ]);

        $editor = User::create([
            'name' => 'Doç. Dr. Editör',
            'email' => 'editor@test.com',
            'password' => Hash::make('password123'),
            'role' => 'editor',
            'title' => 'Baş Editör',
        ]);

        $user = User::create([
            'name' => 'Dr. Yazar Kullanıcı',
            'email' => 'user@test.com',
            'password' => Hash::make('password123'),
            'role' => 'user', 
            'title' => 'Akademisyen',
        ]);

        // 2. KATEGORİLERİ OLUŞTUR
        $categoriesData = ['Mühendislik ve Teknoloji', 'Sağlık Bilimleri', 'Sosyal ve Beşeri Bilimler', 'Temel Bilimler'];
        $categories = [];
        foreach ($categoriesData as $cat) {
            $categories[] = Category::create([
                'name' => $cat,
                'slug' => Str::slug($cat),
            ]);
        }

        // 3. DERGİLERİ OLUŞTUR (Editöre Ait)
        $journal1 = Journal::create([
            'user_id' => $editor->id,
            'name' => 'Uluslararası Teknoloji Araştırmaları Dergisi',
            'issn' => '1234-5678',
            'description' => 'Mühendislik ve teknoloji alanındaki en güncel akademik makaleleri yayımlar.',
            'status' => 'approved',
            'delete_requested' => false,
        ]);

        $journal2 = Journal::create([
            'user_id' => $editor->id,
            'name' => 'Avrasya Sosyal Bilimler Mecmuası',
            'issn' => '8765-4321',
            'description' => 'Sosyal bilimler, tarih ve edebiyat alanlarında hakemli yayın yapar.',
            'status' => 'approved',
            'delete_requested' => false,
        ]);

        // 4. SAYILARI (ISSUES) OLUŞTUR
        $issues = [];
        for ($i = 1; $i <= 3; $i++) {
            $issues[] = Issue::create([
                'journal_id' => $journal1->id,
                'volume' => 'Cilt 1',
                'number' => 'Sayı ' . $i,
                'year' => 2024,
            ]);
        }
        for ($i = 1; $i <= 2; $i++) {
            $issues[] = Issue::create([
                'journal_id' => $journal2->id,
                'volume' => 'Cilt 5',
                'number' => 'Sayı ' . $i,
                'year' => 2024,
            ]);
        }

        // 5. MAKALELERİ OLUŞTUR (Editör Paneli Dolacak Şekilde 20 Adet Dağılım)
        for ($i = 1; $i <= 20; $i++) {
            
            $selectedJournal = rand(0, 1) ? $journal1 : $journal2;
            $selectedIssue = $issues[array_rand($issues)]->id;
            
            // Dağılım Senaryoları
            if ($i <= 6) {
                // Senaryo 1: Standart yazarın onaylanmış, yayımlanmış makaleleri (Ana sayfada görünür)
                $status = 'approved';
                $articleAuthor = $user->id; 
                $issueId = $selectedIssue;
            } elseif ($i <= 10) {
                // Senaryo 2: Editörün KENDİ yüklediği onaylı makaleler (Editör "Yüklediğim Makaleler" tablosunu doldurur)
                $status = 'approved';
                $articleAuthor = $editor->id; 
                $issueId = $selectedIssue;
            } elseif ($i <= 15) {
                // Senaryo 3: Editörün dergisine gelen onay bekleyenler (Editör "Dergilerime Gelen İstekler" tablosunu doldurur)
                // Controller 'editor_review' ya da 'pending_journal_owner' arıyor olabilir, ikisini de dağıtıyoruz
                $status = $i % 2 == 0 ? 'pending_journal_owner' : 'editor_review'; 
                $articleAuthor = $user->id; 
                $issueId = null;
            } else {
                // Senaryo 4: Sadece Admin onayı bekleyen bağımsız makaleler (Admin paneli için)
                $status = 'pending_admin';
                $articleAuthor = rand(0, 1) ? $editor->id : $user->id;
                $issueId = null;
                $selectedJournal = null; // Bağımsız olsun
            }

            $article = Article::create([
                'user_id' => $articleAuthor,
                'journal_id' => $selectedJournal ? $selectedJournal->id : null,
                'issue_id' => $issueId,
                'title' => 'Akademik Örnek Makale Başlığı - Veri ' . $i,
                'abstract' => 'Bu makale, ilgili alandaki temel problemleri incelemektedir. Araştırma yöntemleri olarak nicel veri analizi kullanılmış olup, elde edilen bulgular literatüre önemli katkılar sağlamaktadır.',
                'pdf_path' => null, 
                'status' => $status,
                'delete_requested' => false,
            ]);

            // Kategori Ataması (Pivot)
            DB::table('article_category')->insert([
                'article_id' => $article->id,
                'category_id' => $categories[array_rand($categories)]->id,
            ]);

            // Yorum Ataması (Onaylı makalelere rastgele)
            if ($status === 'approved' && rand(0, 1)) {
                Comment::create([
                    'user_id' => rand(0, 1) ? $editor->id : $user->id,
                    'article_id' => $article->id,
                    'content' => 'Bu makale literatür için gerçekten harika bir kaynak olmuş, tebrikler.',
                ]);
            }
        }

        // 6. TERMİNALE BİLGİ YAZDIR
        $this->command->info("\n=============================================");
        $this->command->info("SUNUM VERİLERİ BAŞARIYLA YÜKLENDİ! 🚀");
        $this->command->info("=============================================\n");
        $this->command->warn("GİRİŞ BİLGİLERİ (Şifreler: password123)");
        $this->command->line("Admin  : admin@test.com");
        $this->command->line("Editör : editor@test.com");
        $this->command->line("Yazar  : user@test.com");
        $this->command->info("\nToplam: 4 Kategori, 2 Dergi, 5 Sayı, 20 Makale, 3 Kullanıcı");
    }
}