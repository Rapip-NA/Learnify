<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 5 Admins with real names
        $admins = [
            ['name' => 'Ahmad Fauzi', 'email' => 'ahmad@example.com'],
            ['name' => 'Budi Santoso', 'email' => 'budi@example.com'],
            ['name' => 'Citra Lestari', 'email' => 'citra@example.com'],
            ['name' => 'Dedi Wijaya', 'email' => 'dedi@example.com'],
            ['name' => 'Eka Saputra', 'email' => 'eka@example.com'],
        ];
        foreach ($admins as $admin) {
            User::factory()->create(array_merge($admin, ['role' => 'admin']));
        }

        // Create 5 Qualifiers (Penguji) with real names
        $qualifiers = [
            ['name' => 'Fajar Nugraha', 'email' => 'fajar@example.com'],
            ['name' => 'Gita Permata', 'email' => 'gita@example.com'],
            ['name' => 'Hendra Setiawan', 'email' => 'hendra@example.com'],
            ['name' => 'Indah Kusuma', 'email' => 'indah@example.com'],
            ['name' => 'Joko Susilo', 'email' => 'joko@example.com'],
        ];
        foreach ($qualifiers as $qualifier) {
            User::factory()->create(array_merge($qualifier, ['role' => 'qualifier']));
        }

        // Create 10 Peserta with real names
        $pesertas = [
            ['name' => 'Rian Hidayat', 'email' => 'rian@example.com'],
            ['name' => 'Siti Aminah', 'email' => 'siti@example.com'],
            ['name' => 'Taufik Hidayat', 'email' => 'taufik@example.com'],
            ['name' => 'Wulan Dari', 'email' => 'wulan@example.com'],
            ['name' => 'Kevin Sanjaya', 'email' => 'kevin@example.com'],
            ['name' => 'Lani Cahyani', 'email' => 'lani@example.com'],
            ['name' => 'Muhammad Rizky', 'email' => 'rizky@example.com'],
            ['name' => 'Nadia Utami', 'email' => 'nadia@example.com'],
            ['name' => 'Oki Setiawan', 'email' => 'oki@example.com'],
            ['name' => 'Putri Rahmawati', 'email' => 'putri@example.com'],
        ];
        foreach ($pesertas as $peserta) {
            User::factory()->create(array_merge($peserta, ['role' => 'peserta']));
        }

        // Create categories
        $this->call(CategorySeeder::class);

        // Create competitions (requires admin users)
        $this->call(CompetitionSeeder::class);

        // Create questions and answers (requires competitions and categories)
        $this->call(QuestionAndAnswerSeeder::class);
    }
}
