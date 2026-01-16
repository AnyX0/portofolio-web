<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CloudinaryUploader;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function uploadImage(Request $request): JsonResponse
    {
        try {
            $maxKb = (int) config('uploads.image_max_kb', 10240);
            $request->validate([
                'file' => 'required|image|mimes:jpg,jpeg,png,webp|max:' . $maxKb,
                'folder' => 'required|string',
            ]);

            $file = $request->file('file');
            $folder = $request->input('folder');

            if (!$file) {
                return response()->json([
                    'success' => false,
                    'error' => 'File tidak ditemukan'
                ], 400);
            }

            $uploader = new CloudinaryUploader();
            $result = $uploader->uploadWithMetadata($file, $folder);

            if (!$result || !isset($result['url'])) {
                return response()->json([
                    'success' => false,
                    'error' => 'Gagal mengunggah ke Cloudinary'
                ], 500);
            }

            return response()->json([
                'success' => true,
                'url' => $result['url'],
                'public_id' => $result['public_id'] ?? null,
                'message' => 'File berhasil diunggah'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
