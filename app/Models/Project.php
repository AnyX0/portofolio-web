<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'description',
        'tech_stack',
        'live_url',
        'repo_url',
        'cover_image',
        'cloudinary_folder',
        'published_at',
        'is_published',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
        'cover_image' => 'array', // Auto decode JSON to array
    ];

    /**
     * When deleting a project, also delete all images from Cloudinary
     */
    protected static function booted()
    {
        static::deleting(function (Project $project) {
            // Delete all images from Cloudinary folder when project is deleted
            if ($project->cloudinary_folder) {
                try {
                    $fetcher = new \App\Services\CloudinaryImageFetcher();
                    $images = $fetcher->getImagesFromFolder($project->cloudinary_folder);
                    
                    if (!empty($images)) {
                        $deleter = new \App\Services\CloudinaryImageDeleter();
                        
                        foreach ($images as $imageUrl) {
                            // Extract public_id from URL
                            if (preg_match('/\/upload\/(?:v\d+\/)?(.+?)\.[^.]+$/', $imageUrl, $matches)) {
                                $publicId = $matches[1];
                                $deleter->deleteImage($publicId);
                            }
                        }
                    }
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Failed to delete Cloudinary images on project delete', [
                        'project_id' => $project->id,
                        'folder' => $project->cloudinary_folder,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        });
    }
}

