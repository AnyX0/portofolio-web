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
        try {
            // Get about data from database or create with defaults
            $about = About::first();
            
            if (!$about) {
                $about = About::create([
                    'name' => 'Andi Utama',
                    'title' => 'Mobile & Web Engineer',
                    'email' => 'moxer404@aol.com',
                    'phone' => '+62 822 6989 8199',
                    'location' => 'Padang, Indonesia',
                    'availability' => 'Available for freelance & collaboration',
                    'timeline' => json_encode([
                        [
                            'year' => '2025',
                            'month' => 'Jan',
                            'title' => 'Senior Fullstack Engineer',
                            'company' => 'Tech Startup (Freelance)',
                            'duration' => '1 year 3 months',
                            'type' => 'Full-time',
                            'desc' => 'Lead arsitektur dan development SaaS multi-tenant dengan fokus performa tinggi dan skalabilitas.',
                            'achievements' => [
                                'Mengurangi load time 65% dengan optimization database queries dan caching strategy',
                                'Implementasi CI/CD pipeline yang mengurangi deployment time dari 30 menit ke 5 menit',
                                'Mentoring 3 junior developer dalam clean architecture dan best practices',
                                'Bangun comprehensive test coverage mencapai 85% code coverage',
                            ],
                            'skills' => ['Laravel', 'Flutter', 'PostgreSQL', 'Redis', 'Docker', 'AWS', 'TypeScript'],
                        ],
                        [
                            'year' => '2023',
                            'month' => 'Jun',
                            'title' => 'Fullstack Developer',
                            'company' => 'Digital Agency',
                            'duration' => '1 year 7 months',
                            'type' => 'Full-time',
                            'desc' => 'Develop dan maintain multiple client projects dengan stack modern dan dokumentasi yang solid.',
                            'achievements' => [
                                'Deliver 12+ projects dengan success rate 100%',
                                'Implementasi design system yang digunakan di 5+ project',
                                'Standardisasi REST API convention di seluruh tim',
                                'Kerjasama dengan designer untuk pixel-perfect UI implementation',
                            ],
                            'skills' => ['Laravel', 'Vue.js', 'MySQL', 'Tailwind', 'RESTful API'],
                        ],
                        [
                            'year' => '2021',
                            'month' => 'Aug',
                            'title' => 'Intern - Product Engineering',
                            'company' => 'Tech Company',
                            'duration' => '6 months',
                            'type' => 'Internship',
                            'desc' => 'Eksplorasi arsitektur bersih, otomasi testing, dan best practices dalam development.',
                            'achievements' => [
                                'Belajar clean architecture patterns dan implementation best practices',
                                'Kontribusi pada 3 production features dengan code review yang ketat',
                                'Dokumentasi learning journey dan sharing session ke tim',
                            ],
                            'skills' => ['PHP', 'Laravel', 'MySQL', 'Unit Testing', 'Git'],
                        ],
                    ]),
                    'skills' => json_encode([
                        ['type' => 'Fokus', 'title' => 'Performa & UX', 'detail' => 'Micro-interactions, smooth flow.'],
                        ['type' => 'Stack', 'title' => 'Flutter · Laravel', 'detail' => 'Tailwind, TS, REST/WS.'],
                        ['type' => 'Pipeline', 'title' => 'CI/CD & QA', 'detail' => 'Testing, linting, rollout.'],
                    ]),
                    'bio' => null,
                ]);
            }

            $contact = [
                'email' => $about->email,
                'phone' => $about->phone,
                'location' => $about->location,
                'availability' => $about->availability,
            ];

            $timeline = is_array($about->timeline) ? $about->timeline : [];

            // Normalisasi skills agar selalu berbentuk array of objects {type,title,detail}
            $skillsRaw = is_array($about->skills) ? $about->skills : [];
            $skills = collect($skillsRaw)->map(function ($item) {
                if (is_string($item)) {
                    return [
                        'type' => 'Skill',
                        'title' => $item,
                        'detail' => '',
                    ];
                }
                return [
                    'type' => $item['type'] ?? 'Skill',
                    'title' => $item['title'] ?? '',
                    'detail' => $item['detail'] ?? '',
                ];
            })->toArray();
            $name = $about->name ?? 'Andi Utama';
            $title = $about->title ?? 'Mobile & Web Engineer';
            $bio = $about->bio;

            return view('about', compact('contact', 'timeline', 'skills', 'name', 'title', 'bio'));
        } catch (\Exception $e) {
            \Log::error('About page error: ' . $e->getMessage());
            
            // Fallback dengan data default jika error
            $contact = [
                'email' => 'moxer404@aol.com',
                'phone' => '+62 822 6989 8199',
                'location' => 'Padang, Indonesia',
                'availability' => 'Available for freelance & collaboration',
            ];
            
            $timeline = [];
            $skills = [
                ['type' => 'Fokus', 'title' => 'Performa & UX', 'detail' => 'Micro-interactions, smooth flow.'],
                ['type' => 'Stack', 'title' => 'Flutter · Laravel', 'detail' => 'Tailwind, TS, REST/WS.'],
                ['type' => 'Pipeline', 'title' => 'CI/CD & QA', 'detail' => 'Testing, linting, rollout.'],
            ];
            $name = 'Andi Utama';
            $title = 'Mobile & Web Engineer';
            $bio = null;
            
            return view('about', compact('contact', 'timeline', 'skills', 'name', 'title', 'bio'));
        }
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
