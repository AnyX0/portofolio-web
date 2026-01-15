<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@portfolio.test'],
            [
                'name' => 'Admin Portfolio',
                'password' => Hash::make('admin12345'),
            ]
        );

        $projects = [
            [
                'title' => 'Neon Banking Mobile',
                'summary' => 'A secure mobile banking app with biometric auth, realtime ledger, dan UI futuristik.',
                'description' => "Dibangun dengan Flutter + Laravel backend, menampilkan offline-first, push notif, dan audit trail. Fokus pada performa dan DX untuk tim.",
                'tech_stack' => 'Flutter, Laravel, Tailwind, Firebase',
                'live_url' => 'https://banking.example.com',
                'repo_url' => null,
                'cover_path' => null,
                'is_published' => true,
            ],
            [
                'title' => 'SaaS Analytics Dashboard',
                'summary' => 'Dashboard multi-tenant dengan chart real-time, role-based access, dan mode gelap.',
                'description' => 'Memanfaatkan Laravel 12, PostgreSQL, dan Tailwind untuk layout responsif. Integrasi WebSocket untuk metrik langsung.',
                'tech_stack' => 'Laravel, Livewire, Tailwind, PostgreSQL',
                'live_url' => 'https://analytics.example.com',
                'repo_url' => 'https://github.com/example/analytics',
                'cover_path' => null,
                'is_published' => true,
            ],
            [
                'title' => 'Portfolio Motion Site',
                'summary' => 'Landing portfolio dengan animasi halus, storytelling, dan CTA jelas.',
                'description' => 'Menonjolkan desain editorial, gradient berlapis, dan komponen yang mudah dikustomisasi.',
                'tech_stack' => 'Laravel, Tailwind, Framer Motion',
                'live_url' => null,
                'repo_url' => null,
                'cover_path' => null,
                'is_published' => true,
            ],
        ];

        foreach ($projects as $project) {
            $project['slug'] = str()->slug($project['title']);
            $project['published_at'] = now()->subDays(rand(1, 120));
            Project::updateOrCreate(['slug' => $project['slug']], $project);
        }
    }
}
