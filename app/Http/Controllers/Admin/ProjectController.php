<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\CloudinaryUploader;
use App\Services\CloudinaryImageFetcher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        $query = Project::whereNull('archived_at')->latest();
        
        // Filter by status
        if (request('status') === 'published') {
            $query->where('is_published', true);
        } elseif (request('status') === 'draft') {
            $query->where('is_published', false);
        }
        
        $projects = $query->paginate(15);
        $totalCount = Project::whereNull('archived_at')->count();
        $publishedCount = Project::whereNull('archived_at')->where('is_published', true)->count();
        $draftCount = Project::whereNull('archived_at')->where('is_published', false)->count();
        $recentCount = Project::whereNull('archived_at')->where('created_at', '>', now()->subDays(7))->count();
        
        return view('admin.projects.index', compact('projects', 'totalCount', 'publishedCount', 'draftCount', 'recentCount'));
    }

    public function archived()
    {
        $projects = Project::whereNotNull('archived_at')->latest('archived_at')->paginate(15);
        $archivedCount = Project::whereNotNull('archived_at')->count();
        
        return view('admin.projects.archived', compact('projects', 'archivedCount'));
    }

    public function archive(Project $project): RedirectResponse
    {
        $project->update(['archived_at' => now()]);
        
        return redirect()->back()->with('status', 'Project berhasil diarsipkan.');
    }

    public function unarchive(Project $project): RedirectResponse
    {
        $project->update(['archived_at' => null]);
        
        return redirect()->back()->with('status', 'Project berhasil dipulihkan dari arsip.');
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        // Generate slug first (needed for folder name)
        $slug = $this->makeSlug($data['title']);
        $cloudinaryFolder = "portfolio/projects/{$slug}";

        // Handle multiple image uploads to Cloudinary
        if ($request->hasFile('cover_images')) {
            $uploader = new CloudinaryUploader();
            
            foreach ($request->file('cover_images') as $image) {
                $uploader->upload($image, $cloudinaryFolder);
            }
        }

        // Convert is_published to boolean (remove from $data first)
        $isPublished = !empty($data['is_published']);
        unset($data['is_published']);

        $projectData = $data + [
            'slug' => $slug,
            'cloudinary_folder' => $cloudinaryFolder,
            'is_published' => $isPublished ? 1 : 0,
            'published_at' => $isPublished ? now() : null,
        ];

        Project::create($projectData);

        return redirect()->route('admin.projects.index')->with('status', 'Project berhasil dibuat.');
    }

    public function edit(Project $project)
    {
        $images = [];
        if ($project->cloudinary_folder) {
            $fetcher = new CloudinaryImageFetcher();
            $images = $fetcher->getImagesFromFolder($project->cloudinary_folder);
        }
        return view('admin.projects.edit', compact('project', 'images'));
    }

    public function deleteImage(Request $request, Project $project)
    {
        try {
            $publicId = $request->input('public_id');
            
            if (!$publicId) {
                return response()->json(['error' => 'Missing public_id'], 400);
            }
            
            $deleter = new \App\Services\CloudinaryImageDeleter();
            $success = $deleter->deleteImage($publicId);
            
            if ($success) {
                return response()->json(['success' => true, 'message' => 'Gambar berhasil dihapus']);
            }
            
            return response()->json(['error' => 'Gagal menghapus gambar dari Cloudinary'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $data = $this->validated($request);

        // Use existing cloudinary folder or create new one
        $cloudinaryFolder = $project->cloudinary_folder ?? "portfolio/projects/{$project->slug}";

        // Handle multiple image uploads to Cloudinary
        if ($request->hasFile('cover_images')) {
            $uploader = new CloudinaryUploader();
            
            foreach ($request->file('cover_images') as $image) {
                $uploader->upload($image, $cloudinaryFolder);
            }
        }

        // Convert is_published to boolean (remove from $data first)
        $isPublished = !empty($data['is_published']);
        unset($data['is_published']);

        $projectData = $data + [
            'slug' => $this->makeSlug($data['title'], $project->id),
            'cloudinary_folder' => $cloudinaryFolder,
            'is_published' => $isPublished ? 1 : 0,
            'published_at' => $isPublished ? ($project->published_at ?? now()) : null,
        ];

        $project->update($projectData);

        return redirect()->route('admin.projects.index')->with('status', 'Project diperbarui.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()->route('admin.projects.index')->with('status', 'Project dihapus.');
    }

    private function validated(Request $request): array
    {
        $maxKb = (int) config('uploads.image_max_kb', 10240);
        return $request->validate([
            'title' => ['required', 'max:150'],
            'summary' => ['required', 'max:255'],
            'description' => ['nullable'],
            'tech_stack' => ['nullable', 'max:255'],
            'live_url' => ['nullable', 'url'],
            'repo_url' => ['nullable', 'url'],
            'cover_images' => ['nullable', 'array'],
            'cover_images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:' . $maxKb],
            'is_published' => ['nullable'], // Accept any value including "on"
        ]);
    }

    private function makeSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $counter = 1;

        while (Project::where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
