<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CloudinaryImageDeleter
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
     * Delete an image from Cloudinary by public ID
     * @param string $publicId Full public ID (e.g., "portfolio/projects/sawta/publicidhere")
     * @return bool Success status
     */
    public function deleteImage(string $publicId): bool
    {
        if (empty($publicId)) {
            Log::warning('Empty public ID provided to CloudinaryImageDeleter');
            return false;
        }

        try {
            $response = Http::withoutVerifying()
                ->withBasicAuth($this->apiKey, $this->apiSecret)
                ->timeout(10)
                ->post("https://api.cloudinary.com/v1_1/{$this->cloudName}/resources/image/destroy", [
                    'public_id' => $publicId,
                    'invalidate' => true,
                ]);

            if ($response->successful()) {
                Log::info('Cloudinary image deleted successfully', ['public_id' => $publicId]);
                return true;
            }

            Log::warning('Failed to delete Cloudinary image', [
                'public_id' => $publicId,
                'status' => $response->status(),
            ]);

            return false;

        } catch (\Exception $e) {
            Log::error('Cloudinary delete exception', [
                'public_id' => $publicId,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }
}
