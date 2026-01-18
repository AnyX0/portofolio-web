<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Project;
use App\Services\CloudinaryImageFetcher;

class PortfolioController extends Controller
{
    public function home()
    {
        return view('welcome');
    }

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
        // Get about data from database or create with defaults
        $about = About::first();
        
        if (!$about) {
            $about = About::create([
                'email' => 'moxer404@aol.com',
                'phone' => '+62 822 6989 8199',
                'location' => 'Padang, Indonesia',
                'availability' => 'Available for freelance & collaboration',
                'timeline' => [
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
                ],
                'skills' => ['Flutter', 'Laravel', 'Tailwind', 'Clean Architecture', 'CI/CD', 'TypeScript'],
                'bio' => null,
            ]);
        }

        $contact = [
            'email' => $about->email,
            'phone' => $about->phone,
            'location' => $about->location,
            'availability' => $about->availability,
        ];

        $timeline = $about->timeline;
        $skills = $about->skills;

        return view('about', compact('contact', 'timeline', 'skills'));
    }

    public function getProjectData($id)
    {
        $project = Project::find($id);

        if (!$project || !$project->is_published) {
            return response()->json(['error' => 'Project tidak ditemukan'], 404);
        }

        return response()->json([
            'id' => $project->id,
            'title' => $project->title,
            'summary' => $project->summary,
            'description' => $project->description,
            'tech_stack' => $project->tech_stack,
                'live_url' => $project->live_url,
                'repo_url' => $project->repo_url,
            'is_published' => $project->is_published,
        ]);
    }

    public function getProjectDataBySlug($slug)
    {
        // Validate slug format (ASCII slug: letters, numbers, dashes)
        if (!preg_match('/^[A-Za-z0-9]+(?:-[A-Za-z0-9]+)*$/', $slug)) {
            return response()->json(['error' => 'Slug tidak valid'], 422);
        }

        $project = Project::where('slug', $slug)->first();

        if (!$project) {
            return response()->json(['error' => 'Project tidak ditemukan'], 404);
        }

        if (!$project->is_published) {
            return response()->json(['error' => 'Project belum diterbitkan'], 403);
        }

        return response()->json([
            'id' => $project->id,
            'title' => $project->title,
            'summary' => $project->summary,
            'description' => $project->description,
            'tech_stack' => $project->tech_stack,
            'live_url' => $project->live_url,
            'repo_url' => $project->repo_url,
            'is_published' => $project->is_published,
        ]);
    }
}
