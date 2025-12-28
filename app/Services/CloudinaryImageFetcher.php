<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CloudinaryImageFetcher
{
    private $cloudName;
    private $apiKey;
    private $apiSecret;

    public function __construct()
    {
        $this->cloudName = config('services.cloudinary.cloud_name');
        $this->apiKey = config('services.cloudinary.api_key');
        $this->apiSecret = config('services.cloudinary.api_secret');
        
        if (!$this->cloudName || !$this->apiKey || !$this->apiSecret) {
            throw new \Exception('Cloudinary configuration missing');
        }
    }

    /**
     * Get all images from a Cloudinary folder
     * @param string $folder Folder path (e.g., "portfolio/projects/sawta")
     * @return array Array of secure_url strings
     */
    public function getImagesFromFolder(string $folder): array
    {
        if (empty($folder)) {
            Log::warning('Empty folder path provided to CloudinaryImageFetcher');
            return [];
        }

        try {
            $response = Http::withoutVerifying()
                ->withBasicAuth($this->apiKey, $this->apiSecret)
                ->timeout(5)
                ->post("https://api.cloudinary.com/v1_1/{$this->cloudName}/resources/search", [
                    'expression' => "folder:{$folder}/*",
                    'max_results' => 100,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['resources'])) {
                    return collect($data['resources'])
                        ->map(fn($resource) => $resource['secure_url'])
                        ->toArray();
                }
            }

            Log::warning('Failed to fetch Cloudinary images', [
                'folder' => $folder,
                'status' => $response->status(),
            ]);

            return [];

        } catch (\Exception $e) {
            Log::error('Cloudinary fetch exception', [
                'folder' => $folder,
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);
            return [];
        }
    }
}
