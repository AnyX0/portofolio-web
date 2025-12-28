<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class CloudinaryUploader
{
    private $cloudName;
    private $uploadPreset;
    private $cloudinaryUrl;

    public function __construct()
    {
        $this->cloudName = config('services.cloudinary.cloud_name');
        $this->uploadPreset = config('services.cloudinary.upload_preset');
        $this->cloudinaryUrl = "https://api.cloudinary.com/v1_1/{$this->cloudName}/image/upload";
    }

    /**
     * Upload image to Cloudinary using unsigned upload
     */
    public function upload($file, ?string $folder = null): ?string
    {
        try {
            if (!$this->uploadPreset) {
                Log::error('Cloudinary upload preset not configured', [
                    'folder' => $folder,
                ]);
                return null;
            }

            $client = new Client([
                'verify' => false, // Disable SSL verify for dev
            ]);

            // Get file path and read content
            $filePath = is_string($file) ? $file : $file->getRealPath();
            $fileContent = fopen($filePath, 'r');
            
            if (!$fileContent) {
                Log::error('Cloudinary upload - failed to open file', [
                    'path' => $filePath,
                    'folder' => $folder,
                ]);
                return null;
            }

            // Prepare multipart form
            $multipart = [
                [
                    'name' => 'file',
                    'contents' => $fileContent,
                ],
                [
                    'name' => 'upload_preset',
                    'contents' => $this->uploadPreset,
                ],
            ];

            if ($folder) {
                $multipart[] = [
                    'name' => 'folder',
                    'contents' => $folder,
                ];
            }

            Log::info('Cloudinary upload request', [
                'url' => $this->cloudinaryUrl,
                'preset' => $this->uploadPreset,
                'folder' => $folder,
            ]);

            $response = $client->post($this->cloudinaryUrl, [
                'multipart' => $multipart,
            ]);

            if (is_resource($fileContent)) {
                fclose($fileContent);
            }

            $result = json_decode($response->getBody(), true);

            if (isset($result['secure_url'])) {
                Log::info('Cloudinary upload success', [
                    'folder' => $folder,
                    'url' => $result['secure_url'],
                    'public_id' => $result['public_id'] ?? null,
                ]);
                return $result['secure_url'];
            }

            Log::error('Cloudinary upload failed - no URL in response', [
                'response' => $result,
                'folder' => $folder,
            ]);
            return null;

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $statusCode = $e->getResponse()->getStatusCode();
            $body = (string)$e->getResponse()->getBody();
            
            Log::error('Cloudinary upload client error', [
                'status' => $statusCode,
                'body' => $body,
                'folder' => $folder,
                'preset' => $this->uploadPreset,
            ]);
            return null;
            
        } catch (\Exception $e) {
            Log::error('Cloudinary upload exception', [
                'error' => $e->getMessage(),
                'folder' => $folder,
            ]);
            return null;
        }
    }
}
