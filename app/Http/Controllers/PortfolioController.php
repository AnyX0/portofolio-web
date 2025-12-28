<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\CloudinaryImageFetcher;

class PortfolioController extends Controller
{
    public function index()
    {
        $projects = Project::where('is_published', true)
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->get();

        // Batch fetch all images at once instead of N+1 calls
        $allProjectImages = [];
        if ($projects->isNotEmpty()) {
            $fetcher = new CloudinaryImageFetcher();
            foreach ($projects as $project) {
                if ($project->cloudinary_folder) {
                    // Cache images untuk 24 jam
                    $cacheKey = 'cloudinary_images_' . md5($project->cloudinary_folder);
                    $allProjectImages[$project->id] = \Illuminate\Support\Facades\Cache::remember(
                        $cacheKey,
                        86400, // 24 hours
                        function () use ($fetcher, $project) {
                            return $fetcher->getImagesFromFolder($project->cloudinary_folder);
                        }
                    );
                }
            }
        }

        return view('portfolio.index', compact('projects', 'allProjectImages'));
    }

    public function show(string $slug)
    {
        $project = Project::where('slug', $slug)->where('is_published', true)->firstOrFail();
        
        // Fetch images from Cloudinary folder with caching
        $images = [];
        if ($project->cloudinary_folder) {
            $cacheKey = 'cloudinary_images_' . md5($project->cloudinary_folder);
            $fetcher = new CloudinaryImageFetcher();
            $images = \Illuminate\Support\Facades\Cache::remember(
                $cacheKey,
                86400, // 24 hours
                function () use ($fetcher, $project) {
                    return $fetcher->getImagesFromFolder($project->cloudinary_folder);
                }
            );
        }

        return view('portfolio.show', compact('project', 'images'));
    }

    public function about()
    {
        $contact = [
            'email' => 'andi.portfolio@mail.test',
            'phone' => '+62 811-0000-123',
            'location' => 'Bandung, Indonesia',
            'availability' => 'Available for freelance & collaboration',
        ];

        $timeline = [
            [
                'year' => '2025',
                'title' => 'Lead Mobile Engineer',
                'desc' => 'Memimpin squad mobile, mentori junior, fokus performa & CI/CD.',
            ],
            [
                'year' => '2023',
                'title' => 'Fullstack Developer',
                'desc' => 'Bangun SaaS multi-tenant dengan Laravel + Flutter front layer.',
            ],
            [
                'year' => '2021',
                'title' => 'Intern - Product Engineering',
                'desc' => 'Eksplorasi arsitektur bersih dan otomasi testing.',
            ],
        ];

        $skills = ['Flutter', 'Laravel', 'Tailwind', 'Clean Architecture', 'CI/CD', 'TypeScript'];

        return view('about', compact('contact', 'timeline', 'skills'));
    }
}
