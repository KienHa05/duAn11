<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ImageService
{
    /**
     * Process and store product image
     *
     * @param UploadedFile $file
     * @param string|null $oldImage
     * @return string|null
     */
    public static function processProductImage(UploadedFile $file, ?string $oldImage = null): ?string
    {
        try {
            // Delete old image if exists
            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }

            // Always store as WebP to match encoded output
            $fileName = time() . '_' . uniqid() . '.webp';
            $filePath = 'products/' . $fileName;

            // Read the image file
            $manager = extension_loaded('imagick') ? ImageManager::imagick() : ImageManager::gd();
            $image = $manager->read($file->getRealPath());

            // Resize image to 800x600 (maintain aspect ratio)
            $image->scale(800, 600);

            // Save to storage
            $webp = $image->toWebp(80);
            Storage::disk('public')->put($filePath, (string) $webp);

            return $filePath;
        } catch (\Exception $e) {
            Log::error('Image processing error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Delete product image
     *
     * @param string|null $image
     * @return bool
     */
    public static function deleteImage(?string $image): bool
    {
        if ($image && Storage::disk('public')->exists($image)) {
            return Storage::disk('public')->delete($image);
        }
        return false;
    }

    /**
     * Get image URL with cache busting
     *
     * @param string|null $image
     * @return string
     */
    public static function getImageUrl(?string $image): string
    {
        if ($image && Storage::disk('public')->exists($image)) {
            return Storage::disk('public')->url($image) . '?v=' . time();
        }
        return asset('storage/products/placeholder.png');
    }
}
